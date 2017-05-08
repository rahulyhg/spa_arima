<?php

class Orders_Model extends Model {
	public function __construct() {
		parent::__construct();
	}

	private $_objType = "orders";
	private $_table = "orders";
	private $_field = "*";
	private $_cutNamefield = "order_";

	public function lists( $options=array() ) {

		$options = array_merge(array(
			'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
			'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,
			
			'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'created',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',
			
			'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
			'more' => true
			), $options);

		$date = date('Y-m-d H:i:s', $options['time']);

		$where_str = "";
		$where_arr = array();


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
		foreach ($results as $key => $value) {
			if( empty($value) ) continue;
			$data[] = $this->convert( $value, $options );
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
		? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ), $options )
		: array();
	}
	public function convert($data, $options=array()){

		$data = $this->cut($this->_cutNamefield, $data);

		return $data;
	}

	/* check */
	/**/
	public function is_name($brand,$text) {
		return $this->db->count($this->_objType, "model_brand_id=:brand AND model_name=:name", array(':brand'=>$brand,':name'=>$text) );
	}

	/**/
	public function insert(&$data) {

		$this->db->insert($this->_objType, $data);
		$data['id'] = $this->db->lastInsertId();

		$data = $this->cut($this->_cutNamefield, $data);
	}
	public function update($id, $data) {
		$this->db->update($this->_objType, $data, "{$this->_cutNamefield}id={$id}");
	}
	public function delete($id) {
		$this->db->delete($this->_objType, "{$this->_cutNamefield}id={$id}");
	}

	public function lastNumber() {

		$sth = $this->db->prepare("SELECT order_number FROM {$this->_table} ORDER BY order_number DESC LIMIT 1");
		$sth->execute();

		if( $sth->rowCount()==1 ){
			$fdata = $sth->fetch( PDO::FETCH_ASSOC );

			return $fdata['order_number']+1;
		}
		else{
			return 1;
		}
	}
}