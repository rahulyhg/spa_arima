<?php

class customers_model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    private $_objName = "customers";
    private $_table = "
        customers 
            LEFT JOIN city ON customers.cus_city_id=city.city_id
            LEFT JOIN customers_level l ON customers.cus_level_id=l.level_id
    ";
    private $_field = "
          cus_level_id
        , cus_code
        , cus_id
        , cus_prefix_name
        , cus_first_name
        , cus_last_name
        , cus_nickname
        , cus_created
        , cus_updated
        , cus_birthday
        , cus_card_id
        , cus_phone
        , cus_email
        , cus_lineID
        , cus_bookmark
        , cus_address
        , cus_zip
        , cus_city_id
        , city_name
        
        , cus_status
        , cus_is_unlimit

        , level_id
        , level_name
        , level_discount

    ";
    private $_cutNamefield = "cus_";

    private function _setDate($data) {
        if( !isset($data['cus_updated']) ){
            $data['cus_updated'] = date('c');
        }

        return $data;
    }
    public function insert(&$data) {
        if( !isset($data['cus_created']) ){
            $data['cus_created'] = date('c');
        }

        $this->db->insert( $this->_objName, $this->_setDate($data) );
        $data['cus_id'] = $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $this->db->update( $this->_objName, $this->_setDate($data), "`cus_id`={$id}" );
    }
    public function delete($id) {
        $this->db->delete( 'customers_notes', "`note_cus_id`={$id}", $this->db->count('customers_notes', "`note_cus_id`=:id", array(':id'=>$id)) );

        $this->db->delete( 'customers_options', "`option_customer_id`={$id}", $this->db->count('customers_options', "`option_customer_id`=:id", array(':id'=>$id)) );

        $this->db->delete( $this->_objName, "`cus_id`={$id}" );
    }


    public function set_option($data) { 
        
        $post = array(
            'option_customer_id' => $data['cus_id'],
            'option_type' => $data['type'],
            'option_label' => $data['label'],
            'option_value' => $data['value'],
        );

        if( empty($data['id']) ){
            $this->db->insert('customers_options', $post);
        }
        else{
            // update 
            $this->db->update('customers_options', $post, "`option_id`={$data['id']}");
        }
    }
    public function del_option($id) {
        $this->db->delete('customers_options', "`option_id`={$id}");
    }

    public function getOptions($id, $type='') {
        $data = $this->db->select("SELECT 
            option_id as id, 
            option_type as type, 
            option_label as label, 
            option_value as value 
        FROM customers_options WHERE option_customer_id=:id", 
            array(
                ':id' => $id
            )
        );

        $results = array();

        foreach ($data as $key => $value) {
            $results[$value['type']][] = array(
                'id' => $value['id'],
                'name' => $value['label'],
                'value' => $value['value'],
            );
        }

        return $results;
    }

    public function setExpired( $data ){

        $data['ex_updated'] = date('c');

        if( empty($data['ex_id']) ){
            $this->db->insert('customers_expired', $data);
        }
        else{
            $this->db->update('customers_expired', $data, "`ex_id`={$data['ex_id']}");
        }
    }

    public function getExpired( $id ){
        $data = $this->db->select("SELECT
            ex_id AS id,
            ex_start_date AS start_date,
            ex_end_date AS end_date,
            ex_updated AS updated,
            ex_emp_id AS emp_id,
            ex_status AS status,
            DATEDIFF(ex_end_date, ex_start_date) AS total_date
        FROM customers_expired WHERE ex_cus_id=:id ORDER BY ex_end_date DESC",
            array(
                ':id' => $id
            )
        );

        $results = array();

        foreach ($data as $key => $value) {
            $results[] = array(
                'id' => $value['id'],
                'start_date' => $value['start_date'],
                'end_date' => $value['end_date'],
                'updated' => $value['updated'],
                'total_date' => $value['total_date'],
                'status' => $value['status'],
                'emp' => $this->query('employees')->get( $value['emp_id'] , array('view_stype'=>'bucketed') ),
            );
        }

        return $results;
    }

    public function lists( $options=array() ) {

        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,

            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'updated',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',

            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:'',

            'more' => true
        ), $options);

    
        if( isset($_REQUEST['view_stype']) ){
            $options['view_stype'] = $_REQUEST['view_stype'];
        }
        elseif( isset($_REQUEST['view']) ){
            $options['view'] = $_REQUEST['view'];
        }
        

        $date = date('Y-m-d H:i:s', $options['time']);

        $where_str = "";
        $where_arr = array();

        if( isset($options['not']) ){
            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str = "{$this->_cutNamefield}id!=:not";
            $where_arr[':not'] = $options['not'];
        }
       

        if( !empty($options['q']) ){

            $arrQ = explode(' ', $options['q']);
            $wq = '';
            foreach ($arrQ as $key => $value) {
                $wq .= !empty( $wq ) ? " OR ":'';
                $wq .= "cus_first_name LIKE :q{$key} OR cus_first_name=:f{$key} OR cus_last_name LIKE :q{$key} OR cus_last_name=:f{$key} OR cus_phone LIKE :s{$key} OR cus_phone=:f{$key} OR cus_email LIKE :s{$key} OR cus_email=:f{$key} OR cus_card_id=:f{$key}";
                $where_arr[":q{$key}"] = "%{$value}%";
                $where_arr[":s{$key}"] = "{$value}%";
                $where_arr[":f{$key}"] = $value;
            }

            if( !empty($wq) ){
                $where_str .= !empty( $where_str ) ? " AND ":'';
                $where_str .= "($wq)";
            }
        }

        if( ( !empty($_REQUEST['period_start']) && !empty($_REQUEST['period_end']) ) || ( !empty($options['period_start']) && !empty($options['period_end']) ) ){

            $period_start = !empty($options['period_start']) ? $options['period_start'] : $_REQUEST['period_start'];
            $period_end = !empty($options['period_end']) ? $options['period_end'] : $_REQUEST['period_end'];

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "(cus_created BETWEEN :startDate AND :endDate)";
            $where_arr[':startDate'] = $period_start;
            $where_arr[':endDate'] = $period_end;
        }

        if( !empty($_REQUEST['status']) ){
            $options['status'] = $_REQUEST['status'];
        }
        if( !empty($options['status']) ){
            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .="`cus_status`=:status";
            $where_arr[':status'] = $options['status'];
        }

        if( isset($_REQUEST['level']) ){
            $options['level'] = $_REQUEST['level'];
        }
        if( !empty($options['level']) ){
            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "`cus_level_id`={$options['level']}";
        }

        $arr['total'] = $this->db->count($this->_table, $where_str, $where_arr);

        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $orderby = $this->orderby( $this->_cutNamefield.$options['sort'], $options['dir'] );
        $limit = $this->limited( $options['limit'], $options['pager'] );
        $arr['lists'] = $this->buildFrag( $this->db->select("SELECT {$this->_field} FROM {$this->_table} {$where_str} {$orderby} {$limit}", $where_arr ), $options );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        return $arr;
    }
    public function get($id, $options=array()){
        $select = $this->_field;

        if( isset($_REQUEST['view_stype']) ){
            $options['view_stype'] = $_REQUEST['view_stype'];
        }
        elseif( isset($_REQUEST['view']) ){
            $options['view_stype'] = $_REQUEST['view'];
        }

        $sth = $this->db->prepare("SELECT {$select} FROM {$this->_table} WHERE {$this->_cutNamefield}id=:id LIMIT 1");
        $sth->execute( array(
            ':id' => $id
        ) );

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ), $options )
            : array();
    }
    public function buildFrag($results, $options=array()) {
        
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convert($value, $options);
        }
        return $data;
    }

    public function convert($data, $options=array()){

        // level
        $data = $this->cut($this->_cutNamefield, $data);
        $data = $this->_convert($data);

        if( !empty($data['address']) ){
            $data['address'] = json_decode($data['address'], true);
        }

        if( !empty($data['address']['city']) ){
            $data['address']['city_name'] = $this->query('system')->city_name($data['address']['city']);
        }

        // name
        foreach ($this->query('system')->_prefixName() as $key => $value) {
            if( $value['id']==$data['prefix_name'] ){
                
                $data['prefix_name_str'] = $value['name'];
                break;
            }
        }
        if( empty($data['prefix_name_str']) ){
            $data['prefix_name_str'] = '';
        }
        $data['fullname'] = "{$data['prefix_name_str']}{$data['first_name']} {$data['last_name']}";
        $data['initials'] = $this->fn->q('text')->initials( $data['first_name'] );


        if( !empty($options['options']) ){
            $data['options'] = $this->getOptions($data['id']);
        }

        if( !empty($data['birthday']) ){
            if( $data['birthday']=='0000-00-00' ){
                $data['birthday'] = '';
            }
            else{
                $data['age'] = $this->fn->q('time')->age( $data['birthday'] );
            }
        }

        if( empty($data['is_unlimit']) ){
            $data['expired'] = $this->getExpired( $data['id'] );
        }

        // if( !empty($data['image_id']) ){
        //     $image = $this->query('media')->get($data['image_id']);

        //     if( !empty($image) ){
        //         $data['image_arr'] = $image;
        //         $data['image_url'] = $image['quad_url'];
        //     }
        // }

        // print_r($data['options']); die;
        $data['permit']['del'] = true;

        $view_stype = !empty($options['view_stype']) ? $options['view_stype']:'convert';
        if( !in_array($view_stype, array('bucketed', 'convert')) ) $view_stype = 'convert';

        return $view_stype == 'bucketed' 
               ? $this->bucketed( $data )
               : $data;
    }
    
    public function bucketed($data) {

        $text = $data['fullname'];

        if( !empty($data['level']['name']) ){
            $category = $data['level']['name'];
        }

        $fdata = array(
            'id'=> $data['id'],
            'created' => $data['created'],
            'text'=> isset($text)?$text:"",
            "category"=>isset($category)?$category:"",
            "subtext"=>isset($subtext)?$subtext:"",
            "type"=>"customers",

            'discount_value' => $data['level']['discount'],
            'discount_type' => 'percent',
            'level_id' => $data['level']['id'],

            // "image_url"=>isset($image_url)?$image_url:"",
            // 'status' => isset($status)?$status:"",
            // 'data' => $data,
        );


        if( !empty($data['code']) ){
            $fdata['text'] = "{$data['code']} {$fdata['text']}";
        }


        return $fdata;
    }

    public function setAddress($str) {
        
        // $arr = explode(' ', $str);

        return array();
    }

    public function lists_status()
    {
        $a[] = array('id'=>1, 'name'=>'');
        return $a; 
    }

    public function lists_sex()
    {
        $a[] = array('id'=>'m', 'name'=>'ชาย');
        $a[] = array('id'=>'f', 'name'=>'หญิง');
    }

    /**/
    /* Check */
    /**/
    public function is_name( $first_name=null , $last_name=null ){
        return $this->db->count('customers', "cus_first_name=':first_name' AND cus_last_name=':last_name'", array(':first_name'=>$first_name , ':last_name'=>$last_name) );
    }

    /**/
    /* Level */
    /**/

    private $select_level = "
          level_id as id
        , level_name as name
        , level_discount as discount
    ";
    public function level() {
        return $this->db->select("SELECT {$this->select_level} FROM customers_level ORDER BY level_sequence ASC");
    }
    public function get_level($id){
        $sth = $this->db->prepare("
            SELECT {$this->select_level}
            FROM customers_level 
            WHERE `level_id`=:id 
            LIMIT 1");
        $sth->execute( array( ':id' => $id ) );
        $data = $sth->rowCount()==1 ? $sth->fetch( PDO::FETCH_ASSOC ) : array();

        $data['permit']['del'] = true;

        $total_emp = $this->db->count('customers', "`cus_level_id`={$data['id']}");
        if( $total_emp > 0 ) $data['permit']['del'] = false;

        return $data;
    }
    public function insert_level(&$data) {
        $this->db->insert( 'customers_level', $data );
        $data['level_id'] = $this->db->lastInsertId();
    }
    public function update_level($id, $data){
        $this->db->update( 'customers_level', $data, "`level_id`={$id}" );
    }
    public function delete_level($id){
        $this->db->delete( 'customers_level', "`level_id`={$id}" );
    }

    public function summary( $options=array() ){

        $select = "COUNT(cus_id) AS total";
        $form = "customers";
        $where_str = 'cus_status=:status';

        // expired //
        $where_arr[':status'] = 'expired';
        $data_expired = $this->db->select("SELECT {$select} FROM {$form} WHERE {$where_str}", $where_arr);

        // RUN //
        $where_arr[':status'] = 'run';
        $data_run = $this->db->select("SELECT {$select} FROM {$form} WHERE {$where_str}", $where_arr);

        $data['total_expired'] = $data_expired[0]['total'];
        $data['total_run'] = $data_run[0]['total'];

        return $data;
    }

}