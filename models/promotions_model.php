<?php

class promotions_model extends Model {
	public function __construct() {
		parent::__construct();
	}

	private $_objType = "promotions";

	private $_table = "promotions p LEFT JOIN employees e ON p.pro_emp_id = e.emp_id";
	private $_field = "p.*,
					   e.emp_id,
					   e.emp_prefix_name,
					   e.emp_first_name,
					   e.emp_last_name,
					   e.emp_image_id";

	private $_cutNamefield = "pro_";

	public function lists( $options=array() ) {

		$options = array_merge(array(
			'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
			'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,
			
			'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'id',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',
			
			'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
			
			'more' => true
			), $options);

		if( isset($_REQUEST['q']) ){
			$options['q'] = $_REQUEST['q'];
		}

		$date = date('Y-m-d H:i:s', $options['time']);

		$where_str = "";
		$where_arr = array();

		if( !empty($options['q']) ){

            $arrQ = explode(' ', $options['q']);
            $wq = '';
            foreach ($arrQ as $key => $value) {
                $wq .= !empty( $wq ) ? " OR ":'';
                $wq .= "model_name LIKE :q{$key} OR model_name=:f{$key}";
                $where_arr[":q{$key}"] = "%{$value}%";
                // $where_arr[":s{$key}"] = "{$value}%";
                $where_arr[":f{$key}"] = $value;
            }

            if( !empty($wq) ){
                $where_str .= !empty( $where_str ) ? " AND ":'';
                $where_str .= "($wq)";
            }
        }

        if( !empty($_REQUEST['type']) ){
            $options['type'] = $_REQUEST['type'];

            $where_str .=  !empty($where_str) ? ' AND ':'';
            $where_str .=  "`pro_type`=:type";
            $where_arr[':type'] = $options['type'];
        }

        if( !empty($_REQUEST['status']) ){
        	$options['status'] = $_REQUEST['status'];

        	$where_str .=  !empty($where_str) ? ' AND ':'';
            $where_str .=  "`pro_status`=:status";
            $where_arr[':status'] = $options['status'];
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


		/*$data = $this->cut($this->_cutNamefield, $data);

		$data['permit']['del'] = true;
		if( $data['amount_balance']>0 ){
			$data['permit']['del'] = false;
		}

		if( !empty($options['colors']) ){
            $data['colors'] = $this->getColors($data['id']);
        }
         if( !empty($data['image_cover']) ){
            $image = $this->query('media')->get($data['image_cover']);

            if(!empty($image)){
	            $data['image_arr'] = $image;
	            $data['image_url'] = $image['url'];
            }
        }*/

		$data = $this->cut($this->_cutNamefield, $data);

		if( !empty($data['is_join']) ){

			$data['invite'] = $this->listInvite( $data['id'] );
		}

		$data['status'] = $this->getStatus($data['status']);
		$data['type'] = $this->getType($data['type']);

		$data['permit']['del'] = true;

		return $data;
	}


	/*Process*/
	/**/
	public function insert(&$data) {

		$data['pro_created'] = date('c');

		$this->db->insert($this->_objType, $data);
		$data['id'] = $this->db->lastInsertId();

		$data = $this->cut($this->_cutNamefield, $data);
	}
	public function update($id, &$data) {

		$this->db->update($this->_objType, $data, "{$this->_cutNamefield}id={$id}");
		$data = $this->cut($this->_cutNamefield, $data);
	}
	public function delete($id) {

		$this->clearProduct( $id );
		$this->db->delete($this->_objType, "{$this->_cutNamefield}id={$id}");
	}

	/**/
	/* Check */
	/**/
	public function is_name( $text ){
		return $this->db->count($this->_objType, "{$this->_cutNamefield}name='{$text}'");
	}

	/**/
	/* Status & Type */
	/**/
	public function type(){

		$a = array();
		$a[] = array('id'=>'percent', 'name'=>$this->lang->translate('Discount Total/Percent'),'note'=>'ลดราคาจากผลรวมทั้งหมด คิดเป็นเปอร์เซนต์');
		$a[] = array('id'=>'amount', 'name'=>$this->lang->translate('Discount Total/Amount'),'note'=>'ลดราคาจากผลรวมทั้งหมด คิดเป็นจำนวนเงิน');
		$a[] = array('id'=>'item_percent', 'name'=>$this->lang->translate('Discount Item/Percent'),'note'=>'ลดราคาต่อชิ้น คิดเป็นเปอร์เซนต์');
		$a[] = array('id'=>'item_amount', 'name'=>$this->lang->translate('Discount Item/Amount'),'note'=>'ลดราคาต่อชิ้น คิดเป็นจำนวนเงิน');
		// $a[] = array('id'=>'total_item', 'name'=>$this->lang->translate('All Item'));
		// $a[] = array('id'=>'total_customer', 'name'=>$this->lang->translate('All Customer'));

		return $a;
	}

	public function status(){

		$a = array();
		$a[] = array('id'=>'on', 'name'=>'On');
		$a[] = array('id'=>'off', 'name'=>'Off');
		$a[] = array('id'=>'cancel', 'name'=>'Cancel');

		return $a;
	}

	public function getStatus($id) {
        $data = array();
        foreach ($this->status() as $key => $value) {
            if( $value['id'] == $id ){
                $data = $value; break;
            }
        }

        return $data;
        
    }

    public function getType($id) {
        $data = array();
        foreach ($this->type() as $key => $value) {
            if( $value['id'] == $id ){
                $data = $value; break;
            }
        }

        return $data;  
    }

    /* End Status & Type */
	/**/

    public function clearProduct($id){
    	$this->db->delete('promotions_permit', "`pro_id`={$id}", $this->db->count('promotions_permit', "`pro_id`=:id", array(':id'=>$id)) );
    }

    public function joinProduct($data){
  		$this->db->insert('promotions_permit', $data);
    }

    public function listInvite( $id ){

    	$options = array('view_stype'=>'bucketed');

    	$select_package = "pack_id AS id,
    					   pack_code AS code,
    					   pack_name AS name,
    					   pack_timer AS timer,
    					   pack_price AS price";

    	$package = $this->db->select("SELECT {$select_package} FROM package p LEFT JOIN promotions_permit pm ON p.pack_id = pm.obj_id WHERE pm.pro_id=:id AND pm.obj_type='package'" , array(':id'=>$id) );

    	$data['package'] = $this->query('package')->buildFrag( $package , $options );

        return $data;
    }
}