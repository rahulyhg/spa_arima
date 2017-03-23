<?php

class Products_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objType = "products";
    private $_table = "products p LEFT JOIN products_models m ON p.pro_model_id=m.model_id";
    private $_field = "p.*,m.model_name";
    private $_cutNamefield = "pro_";

    public function insert(&$data){

    	/*$data["{$this->_cutNamefield}created"] = date('c');
    	$data["{$this->_cutNamefield}updated"] = date('c');
    	$data["{$this->_cutNamefield}display"] = true;
    	$data["{$this->_cutNamefield}status"] = true;*/

        $data["{$this->_cutNamefield}created"] = date('c');
        $data["{$this->_cutNamefield}updated"] = date('c');

        $this->db->insert($this->_objType, $data);
        $data["{$this->_cutNamefield}id"] = $this->db->lastInsertId();
        $data = $this->convert($data);
    }

    public function update($id, $data) {
        $data["{$this->_cutNamefield}updated"] = date('c');
        $this->db->update($this->_objType, $data, "`{$this->_cutNamefield}id`={$id}");
    }
    public function delete($id) {
        $this->db->delete($this->_objType, "`{$this->_cutNamefield}id`={$id}");
        $this->db->delete('products_activity', '`act_pro_id`={$id}', $this->db->count('products_activity', "`act_pro_id`=:id", array(':id'=>$id)) );
        $this->db->delete('products_items', '`item_pro_id`={$id}', $this->db->count('products_items', "`item_pro_id`=:id", array(':id'=>$id)) );
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

        $date = date('Y-m-d H:i:s', $options['time']);

        $where_str = "";
        $where_arr = array();

        if( !empty($options['q']) ){
            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "(pro_name LIKE :q OR pro_name=:qfull)";
            $where_arr[':q'] = "%{$options['q']}%";
            // $where_arr[':qfirst'] = "{$options['q']}%";
            // $where_arr[':qlast'] = "%{$options['q']}";
            $where_arr[':qfull'] = $options['q'];
        }


        if( !empty($_REQUEST['model']) ){
            $options['model'] = $_REQUEST['model'];

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "pro_model_id=:model";
            $where_arr[':model'] = $options['model'];
        }

        $arr['total'] = $this->db->count($this->_table, $where_str, $where_arr);

        /* sum */
        if( isset($options['sum']) ){
            
            $sum_booking = $this->db->select('SELECT sum(pro_booking) AS sum_booking FROM products');

            $sum_balance = $this->db->select('SELECT sum(pro_balance) AS sum_balance FROM products');

            $sum_order = $this->db->select('SELECT sum(pro_order_total) AS sum_ordertotal FROM products');

            $sum_subtotal = $this->db->select('SELECT sum(pro_subtotal) AS sum_subtotal FROM products');

            $arr['sum_booking'] = $sum_booking[0]['sum_booking'];
            $arr['sum_balance'] = $sum_balance[0]['sum_balance'];
            $arr['sum_ordertotal'] = $sum_order[0]['sum_ordertotal'];
            $arr['sum_subtotal'] = $sum_subtotal[0]['sum_subtotal'];
        }


        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $orderby = $this->orderby( $this->_cutNamefield.$options['sort'], $options['dir'] );
        $limit = !empty($options['unlimit']) ? '': $this->limited( $options['limit'], $options['pager'] );

        $arr['lists'] = $this->buildFrag( $this->db->select("SELECT {$this->_field} FROM {$this->_table} {$where_str} {$orderby} {$limit}", $where_arr ), $options );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        return $arr;
    }
    public function buildFrag($results, $options=array()) {
    	$data = array();
    	foreach ($results as $key => $value) {
    		if( empty($value) ) continue;
    		$data[] = $this->convert( $value, $options );
    	}

    	return $data;
    }
    public function get($id, $options=array()){

        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} WHERE `{$this->_cutNamefield}id`=:id LIMIT 1");
        $sth->execute( array( ':id' => $id ) );

        return $sth->rowCount()==1
        ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ),$options )
        : array();
    }
    public function convert($data, $options=array()){
    	
    	$data['is_del'] = true;
        $data['permit']['del'] = true;
        $data['permit']['edit'] = true;

        if( !empty($options['items']) ){


            $data['items'] = $this->get_item($data['pro_id']);
            $data['total'] = $this->db->count('products_items', '`item_pro_id`=:pro_id', array(':pro_id'=>$data['pro_id']));

        }

        $data['items_total'] = $data['total'] = $this->db->count('products_items', '`item_pro_id`=:pro_id', array(':pro_id'=>$data['pro_id']));

        $data['cars_total'] = $this->db->count('cars', '`car_pro_id`=:pro_id', array(':pro_id'=>$data['pro_id']));

        if( $data['items_total'] > 0 or $data['cars_total'] > 0 ){
            $data['permit']['del'] = false;
        }

        return $this->cut($this->_cutNamefield, $data);
    }


    /* */
    public function models(){
        return $this->db->select("SELECT model_id as id, model_name as name FROM products_models");
    }

    public function brands(){
        return $this->db->select("SELECT brand_id as id, brand_name as name FROM products_brands");
    }

    public function color_model($id){
        return $this->db->select("SELECT color_id as id, color_name as name, color_primary as color FROM products_models_colors WHERE `color_model_id`=:id", array(':id'=> $id));
    }
    public function productcolor($id) {
        return $this->db->select("SELECT color_id as id, color_name as name, color_primary as color FROM products_items LEFT JOIN products_models_colors ON item_color=color_id  WHERE `item_pro_id`=:id GROUP BY color_id", array(':id'=> $id));
    }

    public function getActivity($id) {
        $data =  $this->db->select("SELECT act_id as id, act_cost as cost, act_qty as qty FROM products_activity WHERE `act_pro_id`=:id ORDER BY id DESC LIMIT 1", array(':id'=>$id));

        if( !empty($data) ){
            $data = $data[0];
        }

        return $data;
    }

    public function get_act($act_id){
        $data =  $this->db->select("SELECT act_id as id, act_cost as cost, act_qty as qty , act_emp_id AS emp_id FROM products_activity WHERE `act_id`=:id ORDER BY act_id DESC LIMIT 1", array(':id'=>$act_id));

        if( !empty($data) ){
            $data = $data[0];
        }

        return $data;
    }

    public function updateActivity($id, $data)
    {
        $data['act_updated'] = date('c');
        $this->db->update('products_activity', $data, "act_id={$id}");
    }

    public function insertActivity(&$data)
    {
        $data['act_updated'] = date('c');
        $this->db->insert('products_activity', $data);
        $data['act_id'] = $this->db->lastInsertId();
    }

    public function set_item($data){

        $post = array(
            'item_pro_id' => $data['pro_id'],
            'item_act_id' => $data['act_id'],
            'item_vin' => $data['vin'],
            'item_color' => $data['color'],
            'item_engine' => $data['engine'],
            'item_status' => $data['status'],
            'item_updated' => date('c'),
            );

        if( empty($data['id']) ){
            //insert
            $this->db->insert('products_items', $post);
        }
        else{
            // update 
            $this->db->update('products_items', $post, "`item_id`={$data['id']}");
        }
    }


    /**/
    /* product items */
    /**/
    public function items($id, $options=array() ){
        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,

            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'updated',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',

            'parent_id' => $id,
            'status' => isset($_REQUEST['status'])? $_REQUEST['status']: '',

            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:null,
            'more' => true
            ), $options);

        $date = date('Y-m-d H:i:s', $options['time']);

        $where_str = "";
        $where_arr = array();


        if( !empty($options['parent_id']) ){
            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "item_pro_id=:parent";
            $where_arr[':parent'] = $options['parent_id'];
        }

        if( !empty($options['status']) ){
            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "item_status=:status";
            $where_arr[':status'] = $options['status'];
        }

        if( !empty($options['q']) ){
            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "(item_engine LIKE :q OR item_engine=:qfull OR item_vin LIKE :q OR item_vin=:qfull)";
            $where_arr[':q'] = "%{$options['q']}%";
            $where_arr[':qfull'] = $options['q'];
        }

        $_selece = 'item_id, item_vin, item_engine, item_updated,item_status, item_act_id ,item_pro_id, color_name, color_primary';
        $_table = 'products_items LEFT JOIN products_models_colors ON item_color=color_id';

        $arr['total'] = $this->db->count($_table, $where_str, $where_arr);

        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $orderby = $this->orderby( 'item_'.$options['sort'], $options['dir'] );
        $limit = !empty($options['unlimit']) ? '': $this->limited( $options['limit'], $options['pager'] );

        $arr['lists'] = $this->items_buildFrag( $this->db->select("SELECT {$_selece} FROM {$_table} {$where_str} {$orderby} {$limit}", $where_arr ), $options );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        return $arr;
    }
    public function items_buildFrag($results, $options=array()) {
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->items_convert( $value, $options );
        }

        return $data;
    }
    public function items_convert($data, $options=array()){
        
        $data = $this->cut('item_', $data);

        if( $data['status']=='' ) $data['status'] = 'repay';

        foreach ($this->items_status() as $key => $value) {
            if ($value['id'] == $data['status']){
                $data['status_arr'] = $value;
            }
        }

        $data['act'] = $this->get_act($data['act_id']);

        return $data;
    }
    public function items_status() {
        $a = array();

        $a[] = array('id'=>'standby','name'=>'ว่าง', 'color'=>'#ea8006');
        $a[] = array('id'=>'booking','name'=>'จอง', 'color'=>'#1a8aca');
        $a[] = array('id'=>'sold','name'=>'ขายแล้ว', 'color'=>'#bb2244');
        $a[] = array('id'=>'repay','name'=>'ชำรุด', 'color'=>'#cccccc');
        return $a;
    }
    public function items_count_status() {
        
    }


    public function get_item($id=null) {

        $data = $this->db->select("SELECT * FROM products_items WHERE item_pro_id=:id", 
            array(
                ':id' => $id
                )
            );

        $results = array();

        foreach ($data as $key => $value) {
            $color = $this->get_colorItem($value['item_color']);
            $results[] = array(
                'id' => $value['item_id'],
                'pro_id'=> $value['item_pro_id'],
                'act_id'=> $value['item_act_id'],
                'vin' => $value['item_vin'],
                'color' => $value['item_color'],
                'color_name' => $color[0]['name'],
                'color_primary' => $color[0]['color'],
                'engine' => $value['item_engine'],
                'updated' => $value['item_updated']
                );
        }

        return $results;
    }

    public function get_colorItem($id)
    {
        return $this->db->select("SELECT color_id as id, color_name as name, color_primary as color FROM products_models_colors WHERE `color_id`=:id", array(':id'=> $id));
    }

    public function getItem($id)
    {
        $data = $this->db->select("SELECT i.*, p.pro_model_id, p.pro_name FROM products_items i LEFT JOIN products p ON i.item_pro_id=p.pro_id WHERE `item_id`=:id", array(':id'=>$id));

        $data = $data[0];

        $results = array();

        $color = $this->get_colorItem($data['item_color']);

        $results = array(
            'id' => $data['item_id'],
            'act_id'=>$data['item_act_id'],
            'pro_id'=> $data['item_pro_id'],
            'model_id'=> $data['pro_model_id'],
            'pro_name'=> $data['pro_name'],
            'vin' => $data['item_vin'],
            'color' => $data['item_color'],
            'color_name' => $color[0]['name'],
            'color_primary' => $color[0]['color'],
            'engine' => $data['item_engine']
            );

        return $results;
    }

    public function delItem($id, $pro_id)
    {
        /* Update Balance */
        $item = $this->getItem($id);
        $products = $this->get($pro_id);
        $activity = $this->get_act($item['act_id']);

        if( !empty($products['balance']) ){

            $pro['pro_balance'] = $products['balance'] - 1;
            $pro['pro_subtotal'] = $products['subtotal'] - 1;
            $pro['pro_total'] = $products['total'] - 1;
            $this->update($pro_id, $pro);
        }

        if( !empty($activity['qty']) ){
            $act['act_qty'] = $activity['qty'] - 1;
            $this->updateActivity($activity['id'], $act);
        }
        /**/
        
        $this->db->delete('products_items', '`item_id`='.$id);
    }
    
}