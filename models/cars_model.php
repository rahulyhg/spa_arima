<?php

class Cars_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objType = "cars";
    private $_table = "
        cars car
        LEFT JOIN (customers cus 
                LEFT JOIN city ON cus.cus_city_id=city.city_id) 
            ON car.car_cus_id=cus.cus_id

        LEFT JOIN (products p
            LEFT JOIN products_items s ON p.pro_id=s.item_id LEFT JOIN(
                products_models model 
                    LEFT JOIN dealer ON model_dealer_id=dealer_id
                    LEFT JOIN products_brands ON model_brand_id=brand_id)
            ON p.pro_model_id=model_id )
        ON car.car_pro_id=p.pro_id
        
        LEFT JOIN (employees emp 
            LEFT JOIN emp_department dep ON emp.emp_dep_id=dep.dep_id 
            LEFT JOIN emp_position pos ON emp.emp_pos_id=pos.pos_id
            LEFT JOIN city c ON emp.emp_city_id=c.city_id)

        ON emp.emp_id=car.car_emp_id


            ";
    private $_field = "
        car.*

        , model_id, model_name
        , brand_id, brand_name
        , dealer_id, dealer_name
        , pro_id, pro_name

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
        , city.city_name as cus_city_name

        , emp.emp_id
        , emp.emp_prefix_name
        , emp.emp_first_name
        , emp.emp_last_name
        , emp.emp_nickname
        , emp.emp_username
        , emp.emp_phone_number
        , emp.emp_display
        , emp.emp_updated
        , emp.emp_email
        , emp.emp_line_id
        , emp.emp_mode
        , emp.emp_address
        , emp.emp_zip
        , emp.emp_city_id
        , emp.emp_image_id
        , emp.emp_birthday
        , c.city_name as emp_city_name
    ";
    private $_cutNamefield = "car_";

    public function insert(&$data, $is_convert=true){

    	$data["{$this->_cutNamefield}created"] = date('c');
    	$data["{$this->_cutNamefield}updated"] = date('c');

    	$this->db->insert($this->_objType, $data);
    	$data["{$this->_cutNamefield}id"] = $this->db->lastInsertId();

        if( $is_convert == true ){
           $data = $this->convert($data);
       }
    }
    public function update($id, $data) {
        $this->db->update($this->_objType, $data, "{$this->_cutNamefield}id={$id}");
    }
    public function delete($id) {
        $this->db->delete($this->_objType, "{$this->_cutNamefield}id={$id}");
    }

    // select
    public function lists($options=array()) {

    	$options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,

            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'updated',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',

            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:null,
            'more' => true
        ), $options);

        if( isset($_REQUEST['view_stype']) ){
            $options['view_stype'] = $_REQUEST['view_stype'];
        }

        $date = date('Y-m-d H:i:s', $options['time']);

        $where_str = "";
        $where_arr = array();

        if( !empty($options['q']) ){

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "(
                car_VIN LIKE :q OR car_vin=:qfull
                OR car_engine LIKE :q OR car_engine=:qfull
                OR car_plate LIKE :q OR car_plate=:qfull
                OR car_red_plate LIKE :q OR car_red_plate=:qfull
                OR cus_first_name LIKE :qfirst OR cus_first_name=:qfull
                OR cus_phone=:qfull
                OR cus_email=:qfull
                OR cus_lineID=:qfull
            )";
            $where_arr[':q'] = "%{$options['q']}%";
            $where_arr[':qfirst'] = "{$options['q']}%";
            // $where_arr[':qlast'] = "%{$options['q']}";
            $where_arr[':qfull'] = $options['q'];
        }

        if( !empty($options['customer']) ){

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "car_cus_id = :customer";
            $where_arr[':customer'] = $options['customer'];
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

    public function get($id) {
        
        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} WHERE {$this->_cutNamefield}id=:id LIMIT 1");
        $sth->execute( array(
            ':id' => $id
        ) );

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ) )
            : array();
    }

    public function bucketed($data) {
        
        $prefix = '';
        $data = $this->convert( $data );

        $text = $data['pro']['name'];
        $subtext = '';
        $category = $data['cus']['fullname'];

        if( !empty($data['plate']) ){
            $subtext .= !empty($subtext) ? ' · ':'';
            $subtext .= 'ทะเบียน: '.$data['plate'];
        }

        if( !empty($data['red_plate']) ){
            $subtext .= !empty($subtext) ? ' · ':'';
            $subtext .= 'ป้ายแดง: '.$data['red_plate'];
        }

        if( !empty($data['color']['text']) ){
            $subtext .= !empty($subtext) ? ' · ':'';
            $subtext .= 'สี: '.$data['color']['text'];
        }

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

    public function convert($data) {

        $data =$this->cut($this->_cutNamefield, $data);
        if( empty($data['is_convert']) ){
            $data = $this->_convert( $data );
        }

        $data['permit']['del'] = true;
        return $data;
    }

    // 
    public function is_name($text) {
    	return $this->db->count($this->_objType, "{$this->_cutNamefield}name=:text", array(':text'=>$text));
    }
    
    public function lists_status() {
        $a[] = array('id'=>1, 'name'=>'');
        return $a; 
    }

    public function prefixName() {

        $a[] = array('id'=>'', 'name'=> '-');
        $a[] = array('id'=>'Mr.', 'name'=> 'นาย');
        $a[] = array('id'=>'Mrs.', 'name'=> 'นาง');
        $a[] = array('id'=>'Ms.', 'name'=> 'น.ส.');

        return $a;
    }


}