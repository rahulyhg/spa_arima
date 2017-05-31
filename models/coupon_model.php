<?php

class Coupon_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objType = "coupon";
    private $_table = "coupon";
    private $_field = "*";
    private $_cutNamefield = "cou_";


    private function _modifyData($data){

        $data["updated"] = date('c'); // last update time

        $_data = array();
        foreach ($data as $key => $value) {
            $_data[ $this->_cutNamefield.$key ] = trim($value);
        }
        
        return $_data;
    }
    public function insert(&$data) {
        
        $data["created"] = date('c'); // new create time
        $this->db->insert($this->_objType, $this->_modifyData( $data ) );
        $data[$this->_cutNamefield.'id'] = $this->db->lastInsertId();
        $data = $this->convert($data);
    }
    public function update($id, $data) {
        $this->db->update($this->_objType, $this->_modifyData($data), "{$this->_cutNamefield}id={$id}");
    }
    public function delete($id) {
        $this->db->delete($this->_objType, "{$this->_cutNamefield}id={$id}");
    }

    public function lists( $options=array() ) {
        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,
            'more' => true,

            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'created',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',
            
            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:null,

        ), $options);

        $date = date('Y-m-d H:i:s', $options['time']);

        $where_str = "";
        $where_arr = array();

        if( !empty($options['q']) ){

            $arrQ = explode(' ', $options['q']);
            $wq = '';
            foreach ($arrQ as $key => $value) {
                $wq .= !empty( $wq ) ? " OR ":'';
                $wq .= "cou_code=:f{$key}";
                // $where_arr[":q{$key}"] = "%{$value}%";
                // $where_arr[":s{$key}"] = "{$value}%";
                $where_arr[":f{$key}"] = $value;
            }

            if( !empty($wq) ){
                $where_str .= !empty( $where_str ) ? " AND ":'';
                $where_str .= "($wq)";
            }
        }

        if( !empty($_REQUEST['period_start']) && !empty($_REQUEST['period_end']) ){
        	$options['period_start'] = $_REQUEST['period_start'];
        	$options['period_end'] = $_REQUEST['period_end'];
        }

        if( !empty($options['period_start']) && !empty($options['period_end']) ){
			$where_str .= !empty( $where_str ) ? " AND ":'';
			$where_str .= "(cou_start_date BETWEEN :startDate AND :endDate)";
            $where_arr[':startDate'] = $options['period_start'];
            $where_arr[':endDate'] = $options['period_end'];
		}

		if( !empty($_REQUEST['status']) ){
			$options['status'] = $_REQUEST['status'];
		}

		if( !empty($options['status']) ){

			$where_str .= !empty( $where_str ) ? " AND ":'';
			$where_str .= "cou_status=:status";
			$where_arr[':status'] = $options['status'];
		}

        $arr['total'] = $this->db->count($this->_table, $where_str, $where_arr);

        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $orderby = $this->orderby( $this->_cutNamefield.$options['sort'], $options['dir'] );
        $limit = !empty($options['unlimit']) ? '' : $this->limited( $options['limit'], $options['pager'] );
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
    public function get($id){
        
        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} WHERE {$this->_cutNamefield}id=:id LIMIT 1");
        $sth->execute( array(
            ':id' => $id
        ) );

        if( $sth->rowCount()==1 ){
            return $this->convert( $sth->fetch( PDO::FETCH_ASSOC ) );
        } return array();
    }
    public function convert($data){

        $data = $this->cut($this->_cutNamefield, $data);

        $data['package'] = $this->getPackage( $data['id'] );

        $data['status'] = $this->getStatus( $data['status'] );

        $data['permit']['del'] = true;

        if( !empty($data['balance']) ){
        	$data['permit']['del'] = false;
        }

        return $data;
    }

    /* PACKAGE */
    public function getPackage( $id ){

    	$select = "p.pack_id AS id
    			  ,p.pack_name AS name
    			  ,p.pack_qty AS qty 
    			  ,p.pack_unit AS unit
    			  ,p.pack_price AS price
    			  ,c.time as time";

    	$data = $this->db->select("SELECT {$select} 
    		FROM coupon_package c 
    			LEFT JOIN package p ON c.pack_id=p.pack_id
    		WHERE cou_id=:id", array(':id'=>$id)
    	);

    	return $data;
    }

    public function setPackage( $data ){
    	$this->db->insert('coupon_package', $data);
    }

    public function unsetPackage( $id ){
    	$this->db->delete('coupon_package', "cou_id={$id}", $this->db->count('coupon_package', "cou_id={$id}"));
    }
    /*--- End ---*/

    /* STATUS */
    public function status(){

    	$a[] = array('id'=>'run', 'name'=>'Run');
    	$a[] = array('id'=>'cancel', 'name'=>'Cancel');
    	$a[] = array('id'=>'expired', 'name'=>'Expired');

    	return $a;
    }

    public function getStatus( $id ){

    	$data = array();
    	foreach ($this->status() as $key => $value) {
    		if( $value['id'] == $id ){
    			$data = $value;
    			break;
    		}
    	}

    	return $data;
    }
    /*--- End ---*/
}
