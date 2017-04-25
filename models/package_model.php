<?php

class Package_Model extends Model {
	public function __construct() {
		parent::__construct();
	}

	private $_objType = "package";
	private $_table = "";
	private $_field = "*";
	private $_cutNamefield = "pack_";

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
        }

		return $data;
	}


	/* Actions */
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
}