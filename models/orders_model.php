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


		if( isset($_REQUEST['date']) ){
			$options['date'] = date('Y-m-d',strtotime($_REQUEST['date']));
		}

		if( isset($_REQUEST['period_start']) && isset($_REQUEST['period_end']) ){
			$options['period_start'] = $_REQUEST['period_start'];
			$options['period_end'] = $_REQUEST['period_end'];
		}

		$where_str = "";
		$where_arr = array();

		if( !empty($options['status']) ){
			$where_str .= !empty( $where_str ) ? " AND ":'';
			$where_str .= "order_status=:status";
			$where_arr[':status'] = $options['status'];
		}

		if( !empty($options['period_start']) && !empty($options['period_end']) ){
			$where_str .= !empty( $where_str ) ? " AND ":'';
			$where_str .= "(order_start_date BETWEEN :startDate AND :endDate)";
            $where_arr[':startDate'] = $options['period_start'];
            $where_arr[':endDate'] = $options['period_end'];
		}

		if( !empty($options['date']) ){
			$where_str .= !empty( $where_str ) ? " AND ":'';
			$where_str .= "`order_date`=:d";
            $where_arr[':d'] = $options['date'];
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
	public function insertOrder(&$data) {

		if( empty($data['order_created']) ){
			$data['order_created'] = date('c');
		}
		$data['order_updated'] = date('c');

		if( empty($data['order_start_date']) ){
			$data['order_start_date'] = date('c');
		}

		if( empty($data['order_date']) ){
			$data['order_date'] = date('Y-m-d');
		}

		$this->db->insert('orders', $data);
		$data['id'] = $this->db->lastInsertId();

		$data = $this->cut('order_', $data);
	}
	public function updateOrder($id, $data) {
		
		$data['order_updated'] = date('c');

		$this->db->update('orders', $data, "order_id={$id}");
	}

	public function insertDetail(&$data) {
		
		if( empty($data['item_created']) ){
			$data['item_created'] = date('c');
		}
		$data['item_updated'] = date('c');

		if( empty($data['item_start_date']) ){
			$data['item_start_date'] = date('c');
		}

		$this->db->insert('orders_items', $data);
		$data['id'] = $this->db->lastInsertId();
	}

	/*public function update($id, $data) {
		$this->db->update($this->_objType, $data, "{$this->_cutNamefield}id={$id}");
	}*/
	public function delete($id) {
		$this->db->delete($this->_objType, "{$this->_cutNamefield}id={$id}");
	}

	public function lastNumber() {


		$date = isset($_REQUEST['date']) ? date('Y-m-d', strtotime($_REQUEST['date'])): date('Y-m-d');
		// $date = $this->query('system')->working_time( $date );

		$sth = $this->db->prepare("SELECT order_number FROM {$this->_table} WHERE (`order_date`=:d) ORDER BY order_number DESC LIMIT 1");
		$sth->execute( array( ':d' => $date ) );

		if( $sth->rowCount()==1 ){
			$fdata = $sth->fetch( PDO::FETCH_ASSOC );

			return $fdata['order_number']+1;
		}
		else{
			return 1;
		}
	}

	/* GET ORDER MASSEUSE */
	public function get_masseuse_item( $id ){

		$select_item = "item_id as id
						, item_pack_id as pack_id
						, item_price as price
						, item_masseuse as masseuse
						, item_start_date as start_date
						, item_end_date as end_date
						, item_room_id as room_id
						, item_bed_id as bed_id
						, item_room_price as room_price
						, item_discount as discount

						, p.pack_code
						, p.pack_name

						, r.room_id
						, r.room_name
						, r.room_floor
						, r.room_price
						, r.room_level

						, b.bed_id
						, b.bed_code
						, b.bed_name";

		$form_item = "orders_items i 
				 LEFT JOIN package p on i.item_pack_id=p.pack_id
				 LEFT JOIN rooms r on i.item_room_id=r.room_id
				 LEFT JOIN rooms_bed b on i.item_bed_id=b.bed_id";

		return $this->db->select("SELECT {$select_item} FROM {$form_item} WHERE item_masseuse=:id", array(':id'=>$id));
	}

	public function get_customer_item( $id, $options=array() ){

		$select_item = "o.order_id AS id
						, o.order_number AS number
						, o.order_total_price AS total_price
						, o.order_status AS status

						, i.item_id
						, i.item_pack_id
						, i.item_price
						, i.item_masseuse
						, i.item_start_date AS start_date
						, i.item_end_date AS end_date
						, i.item_room_id
						, i.item_bed_id
						, i.item_room_price
						, i.item_discount

						, p.pack_code
						, p.pack_name

						, r.room_id
						, r.room_name
						, r.room_floor
						, r.room_price
						, r.room_level

						, b.bed_id
						, b.bed_code
						, b.bed_name

						, e.emp_id
						, e.emp_prefix_name AS prefix_name
						, e.emp_first_name AS first_name
						, e.emp_last_name AS last_name
						, e.emp_nickname AS nickname";

		$form_item = "orders o
				 LEFT JOIN orders_items i on o.order_id=i.item_order_id
				 LEFT JOIN package p on i.item_pack_id=p.pack_id
				 LEFT JOIN rooms r on i.item_room_id=r.room_id
				 LEFT JOIN rooms_bed b on i.item_bed_id=b.bed_id
				 LEFT JOIN employees e on i.item_masseuse=e.emp_id";

		$where_str = "order_cus_id=:id";

		$where_arr = array();
		$where_arr[':id'] = $id;

		if( !empty($options['status']) ){

			$where_str .= !empty($where_str) ? " AND " : "";
			$where_str .= "o.order_status=:status";
			$where_arr[':status'] = $options['status'];
		}

		return $this->db->select("SELECT {$select_item} FROM {$form_item} WHERE {$where_str}", $where_arr);
	}

	/**/
	public function summary( $options=array() ){

		$select = "SUM(order_total) AS sum_price, SUM(order_discount) AS sum_discount, SUM(order_balance) AS sum_balance, SUM(order_drink) AS sum_drink";
		$form = "orders";

		$where_str = '(order_start_date BETWEEN :startDate AND :endDate)';
		$where_arr[':startDate'] = $options['period_start'];
		$where_arr[':endDate'] = $options['period_end'];

		if( $options['type'] == 'revenue' ){

			$where_str .= ' AND order_status=:status';
			$where_arr[':status'] = 'finish';

			$data = $this->db->select("SELECT {$select} FROM {$form} WHERE {$where_str}", $where_arr);
		}
		elseif( $options['type'] == 'service' ){

			$select = "COUNT(order_cus_id) AS total_customer";
			$where_str .= ' AND order_status!=:status';
			$where_arr[':status'] = 'booking';

			$data = $this->db->select("SELECT {$select} FROM {$form} WHERE {$where_str}", $where_arr);
		}
		elseif( $options['type'] == 'room' ){

			$select = "SUM(item_room_price) AS total_room_price";
			$form = "orders_items";
			$where_str = '(item_start_date BETWEEN :startDate AND :endDate)';

			$data = $this->db->select("SELECT {$select} FROM {$form} WHERE {$where_str}", $where_arr);
		}
		else{
			$data = array();
		}

		return $data[0];
	}
}