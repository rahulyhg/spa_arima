<?php

class Package_Model extends Model {
	public function __construct() {
		parent::__construct();
	}

	private $_objType = "package";
	private $_table = "package p LEFT JOIN employees e ON p.pack_emp_id = e.emp_id";
	private $_field = "p.*,
					   e.emp_id,
					   e.emp_prefix_name,
					   e.emp_first_name,
					   e.emp_last_name,
					   e.emp_image_id";
	private $_cutNamefield = "pack_";

	public function lists( $options=array() ) {

		$options = array_merge(array(
			'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
			'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,
			
			'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'id',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',
			
			'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
			'q' => isset($_REQUEST['q'])? $_REQUEST['q']:null,
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

		$data = $this->_convert($data);

		$data = $this->cut($this->_cutNamefield, $data);

		$data['permit']['del'] = true;

		return $data;
	}

	/* check */
	/**/
	public function is_name($name) {
		return $this->db->count($this->_objType, "pack_name=:name", array(':name'=>$name) );
	}

	/*Process*/
	/**/
	public function insert(&$data) {

		$data['pack_created'] = date('c');
		$data['pack_updated'] = date('c');

		$this->db->insert($this->_objType, $data);
		$data['id'] = $this->db->lastInsertId();

		$data = $this->cut($this->_cutNamefield, $data);
	}
	public function update($id, $data) {

		$data['pack_updated'] = date('c');
		$this->db->update($this->_objType, $data, "{$this->_cutNamefield}id={$id}");
	}
	public function delete($id) {
		$this->db->delete($this->_objType, "{$this->_cutNamefield}id={$id}");
	}
}