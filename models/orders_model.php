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
	public function get($id, $options=array() ){

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


		if( $id=='number' ){
			$where = "order_date=:d AND order_number=:number";
			$arr[':d'] = $options['date'];
			$arr[':number'] = $options['number'];

		}
		else{
			$where = "{$this->_cutNamefield}id=:id";
			$arr[':id'] = $id;
		}

		$sth = $this->db->prepare("SELECT {$select} FROM {$this->_table} WHERE {$where} LIMIT 1");
		$sth->execute( $arr );

		return  $sth->rowCount()==1
		? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ), $options )
		: array();
	}
	public function convert($data, $options=array()){

		$data = $this->cut($this->_cutNamefield, $data);

		$data['number_str'] = sprintf("%03d",$data['number']);

		if( $data['start_date']!='0000-00-00 00:00:00' ){
			$data['start_time'] = date('H:i', strtotime($data['start_date']));
		}

		if( $data['end_date']!='0000-00-00 00:00:00' ){
			$data['end_time'] = date('H:i', strtotime($data['end_date']));
		}

		if( !empty($options['has_item']) ){
			$data['items'] = $this->getItems( $data['id'] );
		}

		return $data;
	}

	public function getItems($id) {
		
		$data = $this->db->select("SELECT 
			  item_id
			, item_created
			, item_updated
			, item_emp_id
	
			, item_room_id
			, item_bed_id
			, item_room_price

			, item_start_date
			, item_end_date

			, item_status

			, item_price
			, item_qty
			, item_total
			, item_discount
			, item_balance
			, item_job_id

			, pack_id
			, pack_qty as pack_time
			, pack_code
			, pack_unit
			, pack_name
			, pack_has_masseuse
			
		  FROM orders_items item 
		  	INNER JOIN package pack ON pack.pack_id=item.item_pack_id
		  	WHERE item.item_order_id=:id ORDER BY item.item_start_date ASC", array(':id'=>$id));


		foreach ($data as $i => $value) {
			
			$value['masseuse'] = $this->query('masseuse')->buildFrag( $this->db->select("SELECT 
				  item.job_id
				, mae.emp_id as id
				, mae.emp_code as code
	            , mae.emp_prefix_name as prefix_name
	            , mae.emp_first_name as first_name
	            , mae.emp_last_name as last_name
	            , mae.emp_nickname as nickname
	            , mae.emp_image_id as image_id

			 FROM orders_items_masseuse item LEFT JOIN employees mae ON item.masseuse_id=mae.emp_id WHERE item_id=:id", array(':id'=>$value['item_id'])), array('view_stype'=>'bucketed'));

			// if( !empty($value['item_room_id']) ){
			// 	$value['rooms'] = $this->query('system')->getRooms($value['item_room_id']);
			// }

			$data[$i] = $this->cut('item_', $value);

	
			foreach ($value as $key => $val) {

				$ex = explode('_', $key, 2);

				if( in_array($ex[0], array('masseuse', 'pack') ) && count($ex)==2 ){
					unset( $data[$i][$key] );

					$data[$i][$ex[0]][$ex[1]] = $val;
				}
			}

		}

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
		$this->db->update('orders', $data, "`order_id`={$id}");
	}
	public function delOrder($id) {
		$this->db->delete('orders', "`order_id`={$id}");
	}

	/**/
	/* Detail */
	/**/
	public function getDetail($id) {
		
		$sth = $this->db->prepare("SELECT 
			  item_id
			, item_created
			, item_updated
			, item_emp_id
	
			, item_room_id
			, item_bed_id
			, item_room_price

			, item_start_date
			, item_end_date

			, item_status
			, item_note

			, item_price
			, item_qty
			, item_total
			, item_discount
			, item_balance
			, item_job_id

			, pack_id
			, pack_qty as pack_time
			, pack_code
			, pack_unit
			, pack_name
			, pack_has_masseuse
			
		  FROM orders_items item 
		  	INNER JOIN package pack ON pack.pack_id=item.item_pack_id
		  	WHERE item.item_id=:id LIMIT 1");


		$sth->execute( array( ':id' => $id ) );
		$data = $sth->fetch( PDO::FETCH_ASSOC );

		if( !empty($data) ){
			$data['masseuse'] = $this->query('masseuse')->buildFrag( $this->db->select("SELECT 
				  item.job_id
				, mae.emp_id as id
				, mae.emp_code as code
	            , mae.emp_prefix_name as prefix_name
	            , mae.emp_first_name as first_name
	            , mae.emp_last_name as last_name
	            , mae.emp_nickname as nickname
	            , mae.emp_image_id as image_id

			 FROM orders_items_masseuse item LEFT JOIN employees mae ON item.masseuse_id=mae.emp_id WHERE item_id=:id", array(':id'=>$data['item_id'])), array('view_stype'=>'bucketed'));
		}

		return $data;
	}
	public function getDetailID( $oid, $pid ) {
		
		$sth = $this->db->prepare("SELECT item_id as id FROM orders_items WHERE `item_order_id`=:id AND `item_pack_id`=:pid LIMIT 1");

		$sth->execute( array(
			':id' => $oid,
			':pid' => $pid
		) );

		if( $sth->rowCount()==1 ){
			$fdata = $sth->fetch( PDO::FETCH_ASSOC );
			return $fdata['id'];
		}
		else{
			return '';
		}
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
	public function updateDetail($id, $data) {
		if( empty($data['item_updated']) ){
			$data['item_updated'] = date('c');
		}

		$this->db->update('orders_items', $data, "`item_id`={$id}");
	}
	public function delDetail($id) {
		
		$this->db->delete('orders_items', "`item_id`={$id}");
	}
	public function removeDetail($id) {
		
		$items = $this->db->select("SELECT item_id as id FROM orders_items WHERE `item_order_id`={$id}");
		foreach ($items as $key => $value) {
			$this->db->delete('orders_items_masseuse', "`item_id`={$id}", $this->db->count('orders_items_masseuse', "`item_id`=:id", array(':id'=>$value['id'])));
		}

		$this->db->delete('orders_items', "`item_order_id`={$id}", count($items));
	}

	/**/
	/* JobMasseuse */
	/**/
	public function itemJobMasseuse($data){
		$this->db->insert('orders_items_masseuse', $data);

		// update queue
		$this->db->update('emp_job_queue', array('job_status'=>'run'), "`job_id`={$data['job_id']} AND `job_date`='{$data['date']}' AND `job_emp_id`={$data['masseuse_id']}");
	}
	public function delItemJobMasseuse($id) {
		// update queue
		$masseuse = $this->db->select("SELECT * FROM orders_items_masseuse WHERE `item_id`=:id", array(':id'=>$id));
		foreach ($masseuse as $mas) {
			
			$this->db->update('emp_job_queue', array('job_status'=>'on'), "`job_id`={$mas['job_id']} AND `job_date`='{$mas['date']}' AND `job_emp_id`={$mas['masseuse_id']}");
			
		}

		$this->db->delete('orders_items_masseuse', "`item_id`={$id}", count($masseuse));
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
	public function get_masseuse_item( $id, $options=array() ){

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

		$where_str = "item_masseuse=:id";
		$where_arr[":id"] = $id;

		if( !empty($options["period_start"]) && !empty($options['period_end']) ){
			$where_str .= !empty($where_str) ? " AND ": '';
			$where_str .= "(item_start_date BETWEEN :s AND :e)";
			$where_arr[":s"] = $options["period_start"];
			$where_arr[":e"] = $options["period_end"];
		}

		if( !empty($options['package']) ){
			$where_str .= !empty($where_str) ? " AND ": '';
			$where_str .= "item_pack_id=:package";
			$where_arr[":package"] = $options['package'];
		}

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

	public function get_times_masseuse($id=null,$options=array()){

		if( !empty($id) ){
			$where_str = "oim.masseuse_id=:id";
			$where_arr[":id"] = $id;
			$select = "oim.date,item_qty,item_start_date";
		}
		else{
			$select = "oim.date,SUM(item_qty) AS qty";
			$where_str = "(oim.masseuse_id is Null OR oim.masseuse_id = 0)";
		}

		$table ="orders_items oi LEFT JOIN orders_items_masseuse oim ON oi.item_id=oim.item_id";

		if( !empty($options["package"]) ){
			$where_str .= !empty($where_str) ? " AND " : '';
			$where_str .= "oi.item_pack_id=:package";
			$where_arr[":package"] = $options["package"];
		}

		if( !empty($options["start_date"]) && !empty($options["end_date"]) ){
			$where_str .= !empty($where_str) ? " AND " : '';
			$where_str .= "(oi.item_start_date BETWEEN :s AND :e)";
			$where_arr[":s"] = $options["start_date"];
			$where_arr[":e"] = $options["end_date"];
		}

		return $this->db->select("SELECT {$select} FROM {$table} WHERE {$where_str}", $where_arr);
	}

	/**/
	public function summary( $options=array() ){

		$select = "SUM(order_total) AS sum_price, SUM(order_discount) AS sum_discount, SUM(order_balance) AS sum_balance, SUM(order_drink) AS sum_drink, SUM(order_room_price) AS sum_room_price";
		$form = "orders";

		$where_str = '';
		$where_arr = array();

		if( !empty($options['period_start']) && !empty($options['period_end']) ){

			$where_str .= !empty($where_str) ? " AND " : '';
 			$where_str .= '(order_start_date BETWEEN :startDate AND :endDate)';
			$where_arr[':startDate'] = $options['period_start'];
			$where_arr[':endDate'] = $options['period_end'];
		}
		else if( !empty($options['date']) ){
			$where_str .= !empty($where_str) ? " AND " : '';
			$where_str .= 'order_date=:d';
			$where_arr[':d'] = $options['date'];
		}

		if( $options['type'] == 'revenue' ){

			/*$where_str .= ' AND order_status=:status';
			$where_arr[':status'] = 'finish';*/

			$where_str = !empty($where_str)? "WHERE {$where_str}":'';

			$sth = $this->db->prepare("SELECT {$select} FROM {$form} {$where_str}");
			$sth->execute( $where_arr );
			$data = $sth->fetch( PDO::FETCH_ASSOC );
		}
		elseif( $options['type'] == 'service' ){

			$select .= ",COUNT(order_cus_id) AS total_customer";
			// $where_str .= ' AND order_status!=:status';
			// $where_arr[':status'] = 'booking';

			$data = $this->db->select("SELECT {$select} FROM {$form} WHERE {$where_str}", $where_arr);
		}
		elseif( $options['type'] == 'room' ){

			// $select = "SUM(item_room_price) AS total_room_price";
			// $form = "orders_items";
			// $where_str = '(item_start_date BETWEEN :startDate AND :endDate)';

			$data = $this->db->select("SELECT {$select} FROM {$form} WHERE {$where_str}", $where_arr);
		}
		else{
			$data = array();
		}

		return $data;
	}

	public function sumOrder( $options=array() ){
		
		$where_str = '';
		$where_arr = array();

		if( !empty($options['date']) ){
			$where_str = 'order_date=:d';
			$where_arr[':d'] = $options['date'];
		}

		$where_str = !empty($where_str)? "WHERE {$where_str}":'';

		$sth = $this->db->prepare("SELECT 
			  SUM(order_total) AS total
			, SUM(order_discount) AS discount
			, SUM(order_balance) AS balance
			, SUM(order_drink) AS drink
			, SUM(order_room_price) AS room_price 
			, SUM(order_tip) AS tip 
		FROM orders {$where_str}");
		$sth->execute( $where_arr );
		return $sth->fetch( PDO::FETCH_ASSOC );
	}

	public function listsDetail( $options=array() ) {
		
		$where_str = '';
		$where_arr = array();

		if( !empty($options['date']) ){
			$where_str = 'o.order_date=:d';
			$where_arr[':d'] = $options['date'];
		}

		$where_str = !empty($where_str)? "WHERE {$where_str}":'';
		$data = $this->db->select("SELECT item_pack_id,item_status,item_total,item_balance,item_discount,pack_name FROM orders_items i LEFT JOIN orders o ON item_order_id=order_id LEFT JOIN package p ON item_pack_id=pack_id {$where_str} ORDER BY p.pack_sequence ASC", $where_arr);
		
		return $data;
	}

	public function package() {
		return $this->db->select("SELECT pack_id as id, pack_name as name FROM package ORDER BY pack_sequence ASC");
	}

}