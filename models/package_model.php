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
			
			'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'sequence',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'ASC',
			
			'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
			
			'more' => true
			), $options);

		if( isset($_REQUEST['q']) ){
			$options['q'] = $_REQUEST['q'];
		}

		$date = date('Y-m-d H:i:s', $options['time']);

		$where_str = "";
		$where_arr = array();

		if( isset($_REQUEST['view_stype']) ){
            $options['view_stype'] = $_REQUEST['view_stype'];
        }

        if( isset($_REQUEST['period_start']) && isset($_REQUEST['period_end']) ){

        	$options['period_start'] = $_REQUEST['period_start'];
        	$options['period_end'] = $_REQUEST['period_end'];
        }

		if( !empty($options['q']) ){

            $arrQ = explode(' ', $options['q']);
            $wq = '';
            foreach ($arrQ as $key => $value) {
                $wq .= !empty( $wq ) ? " OR ":'';
                $wq .= "pack_name LIKE :q{$key} OR pack_name=:f{$key}";
                $where_arr[":q{$key}"] = "%{$value}%";
                // $where_arr[":s{$key}"] = "{$value}%";
                $where_arr[":f{$key}"] = $value;
            }

            if( !empty($wq) ){
                $where_str .= !empty( $where_str ) ? " AND ":'';
                $where_str .= "($wq)";
            }
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

		$data = $this->_convert($data);

		$data = $this->cut($this->_cutNamefield, $data);

		$data['name'] = $this->lang->translate('package', $data['name']);
		if( !empty($options['dashboard']) ){

			/* SUM PACKAGE */
			$where_total = '`item_pack_id`=:pack_id';
			$where_total_arr = array(
				':pack_id'=>$data['id'],
			);

			if( (!empty($options['period_start']) && !empty($options['period_end'])) || (!empty($_REQUEST['period_start']) && !empty($_REQUEST['period_end'])) ){

				$period_start = !empty($options['period_start']) ? $options['period_start'] : $_REQUEST['period_start'];
				$period_end = !empty($options['period_end']) ? $options['period_end'] : $_REQUEST['period_end'];

				$where_total .= ' AND (`item_created` BETWEEN :startDate AND :endDate)';
				$where_total_arr[':startDate'] = $period_start;
				$where_total_arr[':endDate'] = $period_end;
			}

			$select = "SUM(item_qty) AS total_qty, 
					   SUM(item_discount) AS total_discount";

			$results = $this->db->select("SELECT {$select} FROM orders_items WHERE {$where_total}", $where_total_arr);

			$data['total_qty'] = $results[0]['total_qty'];
			$data['total_discount'] = $results[0]['total_discount'];
			/**/

			/* COUNT CUSTOMER */
			$form = 'orders o LEFT JOIN orders_items oi ON o.order_id = oi.item_order_id';
			$data['total_customer'] = $this->db->count($form, 'oi.item_pack_id=:pack_id GROUP BY order_cus_id', array(':pack_id'=>$data['id']));
			/**/
		}

		$data['skill'] = $this->listSkill( $data['id'] );

		$data['permit']['del'] = true;



		// 
		$view_stype = !empty($options['view_stype']) ? $options['view_stype']:'convert';
        if( !in_array($view_stype, array('bucketed', 'convert')) ) $view_stype = 'convert';

        return $view_stype == 'bucketed' 
               ? $this->bucketed( $data )
               : $data;
	}
	public function bucketed($data) {

        // $text = $data['fullname'];

        return array(
            'id'=> $data['id'],
            // 'created' => $data['created'],
            'text'=> $data['name'],
            "category"=> 'Price: '. number_format($data['price'], 0).'฿',
            // "subtext"=>isset($subtext)?$subtext:"",
            "type"=>"package",
            'icon' => 'cube',
            'price' => $data['price'],
            // 'qty' => $data['qty'],
            // "image_url"=>isset($image_url)?$image_url:"",
            // 'status' => isset($status)?$status:"",
            // 'data' => $data,
        );
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

		$this->db->delete( 'packet_skill', "`skill_id`={$id}" , $this->db->count('emp_skill_permit', "`skill_id`={$id}") );

		$this->db->delete($this->_objType, "{$this->_cutNamefield}id={$id}");
	}
	public function is_name($text) {
		return $this->db->count($this->_objType, "`pack_name`=:text", array(':text'=>$text));
	}

	/**/
	/* Skill */
	/**/
	public function listSkill( $id ){

        $data = $this->db->select("SELECT s.skill_id AS id , s.skill_name AS name 
            FROM emp_skill s
                LEFT JOIN package_skill p ON s.skill_id = p.skill_id
            WHERE p.pack_id = :id
        ORDER By p.skill_id ASC", array(':id'=>$id));

        return $data;
    }

    public function setSkill( $data ){
        $this->db->insert('package_skill', $data);
    }

    public function unsetSkill( $id ){
    	$this->db->delete('package_skill', "{$this->_cutNamefield}id={$id}", $this->db->count('packet_skill', "{$this->_cutNamefield}id={$id}") );
    }



    public function unit() {
    	
    	$a = array();
		$a[] = array('id'=>'minute','name'=>'MINUTE');
		$a[] = array('id'=>'hour','name'=>'HOUR');
		$a[] = array('id'=>'time','name'=>'TIME');

		return $a;
    }

    public function status() {

    	$a = array();
		$a[] = array('id'=>'run','name'=>'Run');
		$a[] = array('id'=>'cancel','name'=>'Cancel');

		return $a;
    }
}