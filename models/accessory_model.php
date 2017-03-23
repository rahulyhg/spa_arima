<?php

class Accessory_Model extends Model {
	public function __construct() {
		parent::__construct();
	}

	private $_objType = "accessory";
	private $_table = "accessory a LEFT JOIN products_models m ON a.acc_model_id=m.model_id LEFT JOIN accessory_stores s ON a.acc_store_id=s.store_id";
	private $_field = "a.*,m.model_name,s.store_name";
	private $_cutNamefield = "acc_";

	public function lists( $options=array() ) {

		$options = array_merge(array(
			'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
			'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,
			'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']:'DESC',
			'sort_field' => isset($_REQUEST['sort_field'])? $_REQUEST['sort_field']:'acc_price',
			'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
			'q' => isset($_REQUEST['q'])? $_REQUEST['q']:null,
			'more' => true
			), $options);

		$date = date('Y-m-d H:i:s', $options['time']);

		$where_str = "";
		$where_arr = array();

		if( isset($_REQUEST['model']) ){
			$options['model'] = $_REQUEST['model'];
			
			$where_str .= !empty( $where_str ) ? " AND ":'';
			$where_str .= "acc_model_id=:model";
			$where_arr[':model'] = $options['model'];
		}

		if( isset($_REQUEST['store']) ){
			$options['store'] = $_REQUEST['store'];
			
			$where_str .= !empty( $where_str ) ? " AND ":'';
			$where_str .= "acc_store_id=:store";
			$where_arr[':store'] = $options['store'];
		}
		
		if( !empty($options['q']) ){

			$arrQ = explode(' ', $options['q']);
			$wq = '';
			foreach ($arrQ as $key => $value) {
				$wq .= !empty( $wq ) ? " OR ":'';
				$wq .= "acc_name LIKE :q{$key} OR acc_name LIKE :q{$key}";
				$where_arr[":q{$key}"] = "%{$value}%";
				
			}

			if( !empty($wq) ){
				$where_str .= !empty( $where_str ) ? " AND ":'';
				$where_str .= "($wq)";
			}
		}

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

		$data['permit']['del'] = true;

		//$data['total_item'] = $this->db->count('employees', "`emp_dep_id`=:id", array(':id'=>$data['dep_id']));

		// if( $data['total_item']>0 ){
		// 	$data['permit']['del'] = false;
		// }

		return $this->cut($this->_cutNamefield, $data);
	}


	/* check */
	/**/
	public function is_name($model,$text) {
		return $this->db->count($this->_objType, "acc_model_id=:model AND acc_name=:text", 
			array(
				':model' => $model,
				':text' => $text
				)
			);
	}

	/**/
	public function insert(&$data) {

		$data['acc_created'] = date('c');
		$data['acc_updated'] = date('c');

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

	public function model()
	{
		return $this->db->select("SELECT model_id AS id, model_name AS name FROM products_models");
	}

	public function store()
	{
		return $this->db->select("SELECT store_id AS id, store_name AS name FROM accessory_stores");
	}
}