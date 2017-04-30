<?php

class Rooms_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objType = "rooms";
    private $_table = "rooms";
    private $_field = "*";
    private $_cutNamefield = "room_";


    public function insert(&$data) {
        
        //$data["created"] = date('c'); // new create time
        $this->db->insert($this->_objType, $data);
        $data[$this->_cutNamefield.'id'] = $this->db->lastInsertId();
        $data = $this->convert($data);
    }
    public function update($id, $data) {
        $this->db->update($this->_objType, $data , "{$this->_cutNamefield}id={$id}");
    }
    public function delete($id) {
        $this->db->delete($this->_objType, "{$this->_cutNamefield}id={$id}");
        $this->deleteAllBed($id);
    }
    public function deleteAllBed($id){
        $this->db->delete('room_bed', "bed_room_id={$id}");
    }
    public function deleteBed($id){
        $this->db->delete('room_bed', "bed_id={$id}");
    }

    /*public function lists( $options=array() ) {
        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,
            'more' => true,

            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'number',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'ASC',
            
            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:null,

        ), $options);

        $date = date('Y-m-d H:i:s', $options['time']);

        $where_str = "";
        $where_arr = array();




        if( !empty($_REQUEST['status']) ){
        	$options['status'] = $_REQUEST['status'];
        }

        if( !empty($_REQUEST['level']) ){
        	$options['level'] = $_REQUEST['level'];
        }

        if( !empty($_REQUEST['floor']) ){
        	$options['floor'] = $_REQUEST['floor'];
        }

        if( !empty($options['status']) ){

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "room_status=:status";
            $where_arr[':status'] = $options['status'];
        }

        if( !empty($options['level']) ){

        	$where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "room_level=:level";
            $where_arr[':level'] = $options['level'];

        }

        if( !empty($options['floor']) ){

        	$where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "room_floor=:floor";
            $where_arr[':floor'] = $options['floor'];

        }

        $arr['total'] = $this->db->count($this->_table, $where_str, $where_arr);
        $arr['max_floor'] = $this->maxFloor();

        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $orderby = $this->orderby( $this->_cutNamefield.$options['sort'], $options['dir'] );
        $limit = !empty($options['unlimit']) ? '' : $this->limited( $options['limit'], $options['pager'] );
        $arr['lists'] = $this->buildFrag( $this->db->select("SELECT {$this->_field} FROM {$this->_table} {$where_str} {$orderby} {$limit}", $where_arr ) );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        return $arr;
    }*/
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

        $data = $this->_convert( $data );

        $data['status'] = $this->getStatus( $data['status'] );
        $data['bed'] = $this->listBed( $data['id'] );
        $data['bed_total'] = $this->db->count('room_bed', 'bed_room_id='.$data['id']);
        $data['permit']['del'] = true;

        return $data;
    }

    /* Status & Level */
    public function status(){

    	$a = array();
    	$a[] = array('id'=>'on', 'name'=>'ว่าง', 'color'=>'#42c947');
    	$a[] = array('id'=>'off', 'name'=>'ไม่ว่าง', 'color'=>'#f44336');
    	$a[] = array('id'=>'cleaning', 'name'=>'ทำความสะอาด', 'color'=>'#cc0099');
    	$a[] = array('id'=>'booking', 'name'=>'จอง', 'color'=>'#ff9801');
    	$a[] = array('id'=>'renovate', 'name'=>'ปิดปรับปรุง', 'color'=>'#333333');
    	return $a;
    }

    public function getStatus( $id=null ){

        $data = array();
        foreach ($this->status() as $key => $value) {
            if( $value['id'] == $id ){
                $data = $value; break;
            }
        }

        return $data;
    }

    public function level(){

    	$a = array();
    	$a[] = array('id'=>'basic','name'=>'ห้องปกติ');
    	$a[] = array('id'=>'baths','name'=>'ห้องอาบน้ำ');
    	$a[] = array('id'=>'vip','name'=>'ห้องวีไอพี');

    	return $a;
    }

    /**/
    /* Check */
    /**/
    function is_room( $floor , $number ){
        return $this->db->count('rooms', "room_floor={$floor} AND room_number={$number}");
    }

    /**/
    /* Auto Code */
    /**/
    function AutoBedCode( $id=null ){

        $room = $this->get( $id );
        $bed_number = $this->db->count( 'room_bed', "bed_room_id={$id}" );
        if( empty($bed_number) ){
            $bed_number = 1;
        }
        else{
            $bed_number = $bed_number + 1;
        }

        $number = sprintf("%0d", $room['number']);
        return "{$room['floor']}{$room['number']}{$bed_number}";
    }

    /**/
    /* Bed */
    /**/
    function setBed( $data ){
        $this->db->insert('room_bed' ,$data);
    }

    function listBed( $id=null ){

        $data = $this->db->select("SELECT bed_id AS id , bed_code AS code , bed_status AS status , bed_room_id AS room_id FROM room_bed WHERE bed_room_id={$id}");

        return $data;
    }

    /**/
    /* Floor */
    /**/
    function maxFloor(){

        $data = $this->db->select("SELECT room_floor AS floor FROM {$this->_table} ORDER BY room_floor DESC LIMIT 1");
        return !empty($data[0]['floor']) ? $data[0]['floor'] : array();
    }

    public function floors(){

        $where_str = '';
        $where_arr = array();
        if( isset($_REQUEST['dealer']) ){

            Session::init();
            Session::set('dealer_id', $_REQUEST['dealer']);

            $where_str .= !empty($where_str) ? ' AND ': '';
            $where_str .= "`floor_dealer_id`=:dealer";
            $where_arr[':dealer'] = $_REQUEST['dealer'];
        }

        $where = !empty($where_str) ? "WHERE {$where_str}" : '';

        // echo "SELECT floor_id as id, floor_name as name FROM rooms_floors {$where}"; die;
        return $this->buildFragFloor( $this->db->select("SELECT floor_id as id, floor_name as name FROM rooms_floors {$where}", $where_arr) );

    }
    public function insertFloor(&$data){
        $this->db->insert('rooms_floors', $data);
        $data['floor_id'] = $this->db->lastInsertId();

        $data = $this->convertFloor($data);
    }
    public function buildFragFloor($results) {
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convertFloor( $value );
        }

        return $data;
    }
    public function convertFloor($data){

        $data = $this->cut('floor_', $data);

        if( is_numeric($data['name'])  ){
            $data['name'] = 'Floor '.$data['name'];
        }

        return $data;
    }

    public function lists() {
        $where_str = '';
        $where_arr = array();
        if( isset($_REQUEST['floor']) ){

            $where_str .= !empty($where_str) ? ' AND ': '';
            $where_str .= "`room_floor`=:floor";
            $where_arr[':floor'] = $_REQUEST['floor'];
        }

        $where = !empty($where_str) ? "WHERE {$where_str}" : '';

        // echo "SELECT floor_id as id, floor_name as name FROM rooms_floors {$where}"; die;
        return $this->buildFragRoom( $this->db->select("SELECT room_id as id, room_name as name FROM rooms {$where}", $where_arr) );
    }
    public function buildFragRoom($results) {
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convertRoom( $value );
        }

        return $data;
    }
    public function insertRoom(&$data) {

        $this->db->insert('rooms', $data);
        $data['room_id'] = $this->db->lastInsertId();

        $data = $this->convertRoom($data);
    }
    public function convertRoom($data) {
        $data = $this->cut('room_', $data);

        if( is_numeric($data['name'])  ){
            $data['name'] = 'Room '.$data['name'];
        }

        return $data;
    }

    /**/
    /* Bed */
    /**/
    public function insertBed(&$data) {
        $this->db->insert('rooms_bed', $data);
        $data['bed_id'] = $this->db->lastInsertId();

        $data = $this->convertBed($data);
    }
    public function convertBed($data) {
        $data = $this->cut('bed_', $data);

        if( is_numeric($data['name'])  ){
            $data['name'] = 'Bed '.$data['name'];
        }

        return $data;
    }
    public function beds() {
        $where_str = '';
        $where_arr = array();
        if( isset($_REQUEST['room']) ){

            $where_str .= !empty($where_str) ? ' AND ': '';
            $where_str .= "`bed_room_id`=:room";
            $where_arr[':room'] = $_REQUEST['room'];
        }

        $where = !empty($where_str) ? "WHERE {$where_str}" : '';

        return $this->buildFragBed( $this->db->select("SELECT bed_id as id, bed_name as name FROM rooms_bed {$where}", $where_arr) );
    }
    public function buildFragBed($results) {
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convertBed( $value );
        }

        return $data;
    }
}
