<?php

class Stores_Model extends Model {
	public function __construct() {
		parent::__construct();
	}

	private $_objType = "accessory_stores";
	private $_table = "accessory_stores";
	private $_field = "*";
	private $_cutNamefield = "store_";

	public function lists( $options=array() ) {

		$options = array_merge(array(
			'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
			'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,
			'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']:'DESC',
			'sort_field' => isset($_REQUEST['sort_field'])? $_REQUEST['sort_field']:'store_id',
			'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
			'q' => isset($_REQUEST['q'])? $_REQUEST['q']:null,
			'more' => true
			), $options);

		$date = date('Y-m-d H:i:s', $options['time']);

		$where_str = "";
		$where_arr = array();

		$arr['total'] = $this->db->count($this->_table, $where_str, $where_arr);

		$limit = $this->limited( $options['limit'], $options['pager'] );
		$orderby = $this->orderby( $options['sort_field'], $options['sort'] );
		$where_str = !empty($where_str) ? "WHERE {$where_str}":'';
		$arr['lists'] = $this->buildFrag( $this->db->select("SELECT {$this->_field} FROM {$this->_table} {$where_str} {$orderby} {$limit}", $where_arr ) );

		if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
		$arr['options'] = $options;

		return $arr;
	}

	public function buildFrag($results) {
		$data = array();
		foreach ($results as $key => $value) {
			if( empty($value) ) continue;
			$data[] = $this->convert( $value );
		}

		return $data;
	}
	public function get($id, $options=array()){

		$select = $this->_field;
		if( !empty($options['select']) ){

			if(!is_array($options['select'])){
				$options['select'] = explode(',', $options['select']);
			}

			$select = '';
			foreach ($options['select'] as $value) {
				$select.= !empty($select) ? ', ':'';
				$select.= $this->_cutNamefield.$value;
			}
		}

		$sth = $this->db->prepare("SELECT {$select} FROM {$this->_table} WHERE {$this->_cutNamefield}id=:id LIMIT 1");
		$sth->execute( array(
			':id' => $id
			) );

		return  $sth->rowCount()==1
		? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ) )
		: array();
	}
	public function convert($data){

        // $data['obj_type'] = $this->_objType;
        // $data['is_del'] = true;
		$data['permit']['del'] = true;

		$data['total_item'] = $this->db->count('accessory', "`acc_store_id`=:id", array(':id'=>$data['store_id']));

		if( $data['total_item']>0 ){
			$data['permit']['del'] = false;
		}

		return $this->cut($this->_cutNamefield, $data);
	}


	/* check */
	/**/
	public function is_name($text) {
		return $this->db->count($this->_table, "{$this->_cutNamefield}name=:name", array(':name'=>$text) );
	}


	/**/
	public function insert(&$data) {

		$data['store_created'] = date('c');
		$data['store_updated'] = date('c');

		$this->db->insert($this->_objType, $data);
		$data['id'] = $this->db->lastInsertId();

		$data = $this->cut($this->_cutNamefield, $data);
	}
	public function update($id, $data) {
		$data['store_updated'] = date('c');
		$this->db->update($this->_objType, $data, "{$this->_cutNamefield}id={$id}");
	}
	public function delete($id) {
		$this->db->delete($this->_objType, "{$this->_cutNamefield}id={$id}");
	}
}