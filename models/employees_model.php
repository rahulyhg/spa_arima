<?php

class Employees_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objType = "employees";
    private $_table = "employees e 
        LEFT JOIN emp_department d ON e.emp_dep_id=d.dep_id 
        LEFT JOIN emp_position p ON e.emp_pos_id=p.pos_id
        LEFT JOIN city c ON e.emp_city_id=c.city_id";

    private $_field = "   emp_id
                        , emp_prefix_name
                        , emp_first_name
                        , emp_last_name
                        , emp_nickname
                        , emp_username
                        , emp_phone_number
                        , emp_display
                        , emp_updated
                        , emp_email
                        , emp_line_id
                        , emp_mode
                        , emp_address
                        , emp_zip
                        , emp_city_id
                        , emp_image_id
                        , emp_birthday
                        , emp_lang
                        , d.dep_id
                        , d.dep_name
                        , d.dep_is_admin
                        , d.dep_is_sale
                        , d.dep_permission
                        , p.pos_id 
                        , p.pos_name
                        , c.city_name";

    private $_cutNamefield = "emp_";


    public function lists( $options=array() ) {

        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,

            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'updated',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',

            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:null,

            'more' => true
        ), $options);

        $date = date('Y-m-d H:i:s', $options['time']);

        $where_str = "";
        $where_arr = array();

        if( isset($_REQUEST['dep']) || isset($options['dep']) ){
            if( isset($_REQUEST['dep']) ) $options['dep'] = $_REQUEST['dep'];
            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "d.dep_name=:dep";
            $where_arr[':dep'] = $options['dep'];
        }

        if( isset($_REQUEST['department']) || isset($options['department']) ){
            if( isset($_REQUEST['department']) ) $options['department'] = $_REQUEST['department'];
            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "emp_dep_id=:department";
            $where_arr[':department'] = $options['department'];
        }

        // if( isset($_REQUEST['position']) || isset($options['position']) ){
        //     if( isset($_REQUEST['position']) ) $options['position'] = $_REQUEST['position'];
        //     $where_str .= !empty( $where_str ) ? " AND ":'';
        //     $where_str .= "emp_pos_id=:position";
        //     $where_arr[':position'] = $options['position'];
        // }

        if( !empty($_REQUEST['position']) ){
            $options['position'] = $_REQUEST['position'];

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "emp_pos_id=:position";
            $where_arr[':position'] = $options['position'];
        }

        if( !empty($_REQUEST['display']) ){
            $options['display'] = $_REQUEST['display'];

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "emp_display=:display";
            $where_arr[':display'] = $options['display'];
        }

        if( !empty($options['q']) ){

            $arrQ = explode(' ', $options['q']);
            $wq = '';
            foreach ($arrQ as $key => $value) {
                $wq .= !empty( $wq ) ? " OR ":'';
                $wq .= "emp_first_name LIKE :q{$key} OR emp_last_name LIKE :q{$key} OR emp_phone_number LIKE :s{$key} OR emp_phone_number=:f{$key}";
                $where_arr[":q{$key}"] = "%{$value}%";
                $where_arr[":s{$key}"] = "{$value}%";
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

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ) )
            : array();
    }
    public function convert($data){
        $data['role'] = 'emp';

        $data = $this->cut($this->_cutNamefield, $data);

        foreach ($this->query('system')->_prefixName() as $key => $value) {
            if( $value['id']==$data['prefix_name'] ){
                
                $data['prefix_name_th'] = $value['name'];
                break;
            }
        }

        $data['fullname'] = "{$data['prefix_name_th']}{$data['first_name']} {$data['last_name']}";

        // $data['image_url'] = IMAGES.'avatar/error/user.png';
        $data['permit_on_pages'] = $this->permitOnPages();

        $data['initials'] = $this->fn->q('text')->initials( $data['first_name'] );
        
        if( !empty($data['dep_is_sale']) ){
            if( $data['dep_is_sale'] == 1 ){
                $data['total_booking'] = $this->db->count('booking', '`book_sale_id`=:emp_id', array(':emp_id'=>$data['id']));
            }
        }

        if( !empty($data['dep_permission']) ){
            $data['dep_permission'] = json_decode($data['dep_permission'], true);
        }

        if( !empty($data['image_id']) ){
            $image = $this->query('media')->get($data['image_id']);

            $data['image_arr'] = $image;
            $data['image_url'] = $image['url'];
        }

        if( !empty($data['address']) ){
            $data['address'] = json_decode($data['address'],true);
        }

        if( !empty($data['address']['city']) ){
            $data['address']['city_name'] = $this->query('system')->city_name($data['address']['city']);
        }

        $data['permit']['del'] = true;
        return $data;
    }

    /**/
    /* check User */
    /**/
    public function login($user, $pass){

        $sth = $this->db->prepare("SELECT emp_id as id FROM employees WHERE emp_username=:login AND emp_password=:pass AND emp_display='enabled'");

        $sth->execute( array(
            ':login' => $user,
            ':pass' => Hash::create('sha256', $pass, HASH_PASSWORD_KEY)
        ) );

        $fdata = $sth->fetch( PDO::FETCH_ASSOC );
        return $sth->rowCount()==1 ? $fdata['id']: false;
    }
    public function is_user($text){

        $c = $this->db->count($this->_objType, "{$this->_cutNamefield}username='{$text}'");
        if( $c==0 ){
            $c = $this->db->count("users", "emp_username='{$text}'");
        }

        return $c;
    }
    public function is_name($text) {

        $c = $this->db->count($this->_objType, "{$this->_cutNamefield}name='{$text}'");
        if( $c==0 ){
            $c = $this->db->count("users", "emp_name='{$text}'");
        }

        return $c;
    }

    public function is_checkpass($id, $old_pass) {
        return $this->db->count($this->_objType, "{$this->_cutNamefield}id='{$id}' AND {$this->_cutNamefield}password='{$old_pass}'");
    }


    /**/
    public function insert(&$data) {
        
        $data["{$this->_cutNamefield}created"] = date('c');
        $data["{$this->_cutNamefield}updated"] = date('c');
        $data["{$this->_cutNamefield}display"] = 'enabled';

        if( isset($data['emp_password']) ){
            $data['emp_password'] = Hash::create('sha256', $data['emp_password'], HASH_PASSWORD_KEY);
        }

        $this->db->insert($this->_objType, $data);
        $data['id'] = $this->db->lastInsertId();

        $data = $this->cut($this->_cutNamefield, $data);
    }
    public function update($id, $data) {
        $data["{$this->_cutNamefield}updated"] = date('c');

        $this->db->update($this->_objType, $data, "{$this->_cutNamefield}id={$id}");
    }
    public function delete($id) {
        $this->db->delete($this->_objType, "{$this->_cutNamefield}id={$id}");
    }


    /**/
    /* department */
    /**/
    private $select_department = "
          dep_id as id
        , dep_name as name
        , dep_notes as notes
        , dep_permission as permission
        , dep_is_admin as is_admin
        , dep_is_sale as is_sale
        , dep_is_tec as is_tec
        , dep_is_service as is_service
    ";
    public function department() {

        $data = $this->db->select("SELECT {$this->select_department} FROM emp_department");
        return $data;
    }
    public function get_department($id){
        $sth = $this->db->prepare("
            SELECT {$this->select_department}
            FROM emp_department 
            WHERE `dep_id`=:id 
            LIMIT 1");
        $sth->execute( array( ':id' => $id ) );
        $data = $sth->rowCount()==1 ? $sth->fetch( PDO::FETCH_ASSOC ) : array();

        if( !empty($data['permission'] )){
            $data['permission'] = json_decode($data['permission'], true);
        }

        $data['permit']['del'] = true;

        $total_emp = $this->db->count('employees', "`emp_dep_id`={$data['id']}");
        if( $total_emp > 0 ) $data['permit']['del'] = false;

        return $data;
    }
    public function insert_department(&$data) {
        $this->db->insert( 'emp_department', $data );
        $data['dep_id'] = $this->db->lastInsertId();
    }
    public function update_department($id, $data){
        $this->db->update( 'emp_department', $data, "`dep_id`={$id}" );
    }
    public function delete_department($id){
        $this->db->delete( 'emp_department', "`dep_id`={$id}" );
    }

    /**/
    /* Position */
    /**/
    public function position($dep_id=null){

        $where = '';
        if( !empty($dep_id) ){
            $where = 'WHERE pos_dep_id='.$dep_id;
        }

        return $this->db->select("SELECT pos_id as id, pos_name as name FROM emp_position {$where}");
    }
    public function get_position($id){
        $sth = $this->db->prepare("
            SELECT pos_id as id, pos_name as name, pos_dep_id as dep_id
            FROM emp_position
            WHERE `pos_id`=:id 
            LIMIT 1");
        $sth->execute( array( ':id' => $id ) );
        $data = $sth->rowCount()==1 ? $sth->fetch( PDO::FETCH_ASSOC ) : array();

        $data['permit']['del'] = true;

        $total_emp = $this->db->count('employees', "`emp_pos_id`={$data['id']}");
        if( $total_emp > 0 ) $data['permit']['del'] = false;

        return $data;
    }
    public function insert_position(&$data) {
        $this->db->insert( 'emp_position', $data );
        $data['pos_id'] = $this->db->lastInsertId();
    }
    public function update_position($id, $data){
        $this->db->update( 'emp_position', $data, "`pos_id`={$id}" );
    }
    public function delete_position($id){
        $this->db->delete( 'emp_position', "`pos_id`={$id}" );
    }


    public function prefixName() {
        $a[] = array('id'=>'', 'name'=> '-');
        $a[] = array('id'=>'Mr.', 'name'=> 'นาย');
        $a[] = array('id'=>'Mrs.', 'name'=> 'นาง');
        $a[] = array('id'=>'Ms.', 'name'=> 'น.ส.');

        return $a;
    }


    /**/
    /* Sales */
    /**/
    public function sales(){
        return $this->buildFrag( $this->db->select("SELECT {$this->_field} FROM {$this->_table} WHERE dep_is_sale=1") );
    }

    /**/
    /* Tec */
    /**/
    public function tec(){
        
        return $this->buildFrag( $this->db->select("SELECT {$this->_field} FROM {$this->_table} WHERE dep_is_tec=1") );
    }

    /**/
    /* */
    /**/
    public function display(){

        $a = array();
        $a[] = array('id' => 'enabled', 'name' => 'เปิดใช้งาน');
        $a[] = array('id' => 'disabled', 'name' => 'ปิดใช้งาน');

        return $a;
    }
}