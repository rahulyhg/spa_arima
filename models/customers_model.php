<?php

class customers_model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    private $_objName = "customers";
    private $_table = "customers 
                       LEFT JOIN city ON customers.cus_city_id = city.city_id
                       LEFT JOIN countries ON customers.cus_country_id = countries.country_id";
    private $_field = "cus_id
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
                       , cus_country_id
                       , cus_emp_id
                       , cus_level_id

                       , city_name
                       , country_name";
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

    public function lists( $options=array() ) {

        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,


            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'created',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',

            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:'',

            'more' => true
        ), $options);

        if( isset($_REQUEST['view_stype']) ){
            $options['view_stype'] = $_REQUEST['view_stype'];
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

        if( !empty($_REQUEST['period_start']) && !empty($_REQUEST['period_end']) ){

            $options['period_start'] = date("Y-m-d 00:00:00", strtotime($_REQUEST['period_start']));
            $options['period_end'] = date("Y-m-d 23:59:59", strtotime($_REQUEST['period_end']));

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "cus_created BETWEEN :startDate AND :endDate";
            $where_arr[':startDate'] = $options['period_start'];
            $where_arr[':endDate'] = $options['period_end'];
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

        $view_stype = !empty($options['view_stype']) ? $options['view_stype']:'convert';
        if( !in_array($view_stype, array('bucketed', 'convert')) ) $view_stype = 'convert';

        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->{$view_stype}($value);
        }
        return $data;
    }
    public function bucketed($data) {
        
        $data = $this->convert( $data );

        $text = $data['fullname'];
        // $subtext = 'ทะเบียน: '.$data['plate'];
        // $category = $data['cus']['fullname'];
        //pro

        return array(
            'id'=> $data['id'],
            'created' => $data['created'],
            'text'=> isset($text)?$text:"",
            "category"=>isset($category)?$category:"",
            "subtext"=>isset($subtext)?$subtext:"",
            // "image_url"=>isset($image_url)?$image_url:"",
            // 'status' => isset($status)?$status:"",
            'data' => $data,
        );
    }
    public function convert($data, $options=array()){

        $data = $this->cut($this->_cutNamefield, $data);

        foreach ($this->query('system')->_prefixNameCustomer() as $key => $value) {
            if( $value['id']==$data['prefix_name'] ){
                
                $data['prefix_name_th'] = $value['name'];
                break;
            }
        }

        if( !empty($data['address']) ){

            $data['address'] = json_decode($data['address'], true);
        }

        if( !empty($data['address']['city']) ){
            $data['address']['city_name'] = $this->query('system')->city_name($data['address']['city']);
        }

        if( !empty($data['country_id']) ){
            $data['country_name'] = $this->query('system')->country_name( $data['country_id'] );
        }

        $data['fullname'] = "{$data['prefix_name_th']}{$data['first_name']} {$data['last_name']}";

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

        // print_r($data['options']); die;
        $data['permit']['del'] = true;
        return $data;
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

    public function notes( $options=array() ){

        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,

            'dir' => isset($_REQUEST['sort'])? $_REQUEST['sort']:'ASC',
            'sort' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'date', 

            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:'',

            'more' => true
        ), $options);


        $where_str = '';
        $where_arr = array();

        /*$where_str = "`note_date`<=:d";
        $where_arr[':d'] = date('Y-m-d H:i:s', $options['time']);*/


        if( isset($_REQUEST['cus_id']) ){
            $options['cus_id'] = $_REQUEST['cus_id'];
            
            $where_str .=  !empty($where_str) ? ' AND ':'';
            $where_str .=  "`note_cus_id`=:cus_id";
            $where_arr[':cus_id'] = $options['cus_id'];
        }


        $date = date('Y-m-d H:i:s', $options['time']);

        $arr['total'] = $this->db->count('customers_notes', $where_str, $where_arr);

        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $orderby = $this->orderby( 'note_'.$options['sort'], $options['dir'] );
        $limit = $this->limited( $options['limit'], $options['pager'] );
        
        $arr['lists'] = $this->buildFragNote( $this->db->select("SELECT note_user_id as user_id, note_id as id, note_text as text, note_date as date, u.user_name  FROM customers_notes c INNER JOIN users u ON c.note_user_id=u.user_id {$where_str} {$orderby} {$limit}", $where_arr ) );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        // print_r($arr); die;
        return $arr;
    }

    public function save_note(&$data)
    {
        $this->db->insert( 'customers_notes', $data );
        $data['note_id'] = $this->db->lastInsertId();

        $data = $this->cut('note_', $data);
    }

    public function get_note( $id )
    {

        $sth = $this->db->prepare("SELECT note_user_id as user_id, note_id as id, note_text as text, note_date as date, u.user_name FROM customers_notes c INNER JOIN users u ON c.note_user_id=u.user_id WHERE note_id=:id LIMIT 1");
        $sth->execute( array(
            ':id' => $id
        ) );

        return $sth->rowCount()==1
            ? $this->convertNote( $sth->fetch( PDO::FETCH_ASSOC ) )
            : array();
    }
    public function buildFragNote($results) {
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convertNote( $value );
        }
        return $data;
    }
    public function convertNote($data){

        $data = $this->cut('note_', $data);
        $data['permit']['del'] = true;

        if( !empty($data['user_name']) ){

            $data['poster'] = $data['user_name'];
        }

        return $data;

    }

    public function updateNote($id, $data)
    {
        $this->db->update('customers_notes', $data, "`note_id`={$id}" );
    }
    public function deleteNote($id)
    {
        $this->db->delete('customers_notes', "`note_id`={$id}" );
    }

    /**/
    /* Check */
    /**/
    public function is_name( $first_name=null , $last_name=null ){
        return $this->db->count('customers', "cus_first_name=':first_name' AND cus_last_name=':last_name'", array(':first_name'=>$first_name , ':last_name'=>$last_name) );
    }

    /**/
    /* */
    /**/
    public function level_lists()
    {
        $a = array();
        $a[] = array('id'=>'general', 'name'=>'สมาชิกทั่วไป');
        $a[] = array('id'=>'vip', 'name'=>'สมาชิกพิเศษ (VIP)');

        return $a;
    }
}