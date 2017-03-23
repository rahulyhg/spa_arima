<?php

class Tasks_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objType = "tasks";
    private $_table = "tasks task LEFT JOIN tasks_types type ON task.task_type_id=type.type_id";
    private $_field = "task.*,type.type_name";
    private $_cutNamefield = "task_";

    public function insert(&$data){


        if( !isset($data["created"]) ){
            $data["created"] = date('c');
        }

        if( !isset($data["updated"]) ){
            $data["updated"] = date('c');
        }
        
        $this->db->insert($this->_objType, $this->_setFieldFirstName( $this->_cutNamefield, $data ) );
        $data["id"] = $this->db->lastInsertId();
        $data = $this->convert($data);
    }

    public function update($id, $data) {
        $data["{$this->_cutNamefield}updated"] = date('c');
        $this->db->update($this->_objType, $data, "`{$this->_cutNamefield}id`={$id}");
    }
    public function delete($id) {
        /*$this->db->delete($this->_objType, "`{$this->_cutNamefield}id`={$id}");
        $this->db->delete('products_activity', '`act_pro_id`={$id}', $this->db->count('products_activity', "`act_pro_id`=:id", array(':id'=>$id)) );
        $this->db->delete('products_items', '`item_pro_id`={$id}', $this->db->count('products_items', "`item_pro_id`=:id", array(':id'=>$id)) );*/
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


        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $orderby = $this->orderby( $this->_cutNamefield.$options['sort'], $options['dir'] );
        $limit = !empty($options['unlimit']) ? '': $this->limited( $options['limit'], $options['pager'] );

        $arr['lists'] = $this->buildFrag( $this->db->select("SELECT {$this->_field} FROM {$this->_table} {$where_str} {$orderby} {$limit}", $where_arr ), $options );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        return $arr;
    }
    public function get($id, $options=array()){

        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} WHERE `{$this->_cutNamefield}id`=:id LIMIT 1");
        $sth->execute( array( ':id' => $id ) );

        return $sth->rowCount()==1
        ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ),$options )
        : array();
    }
    public function buildFrag($results, $options=array()) {
    	$data = array();
    	foreach ($results as $key => $value) {
    		if( empty($value) ) continue;
    		$data[] = $this->convert( $value, $options );
    	}

    	return $data;
    }
    public function convert($data, $options=array()){
    	
        $this->cut($this->_cutNamefield, $data);

        $data['permit']['del'] = true;
        $data['permit']['edit'] = true;

        return $data;
    }

    /* status */
    public function status() {

        $a[] = array('id'=>'new','name'=>'New');
        $a[] = array('id'=>'accept','name'=>'Accept');
        $a[] = array('id'=>'done','name'=>'Done');
        // $a[] = array('id'=>'reject','name'=>'Reject');
        $a[] = array('id'=>'fail','name'=>'Fail');
        $a[] = array('id'=>'cancel','name'=>'Cancel');
        return $a;
    }

}