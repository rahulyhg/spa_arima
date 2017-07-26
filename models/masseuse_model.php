<?php

class Masseuse_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_dep = 5;
    private $_objType = "employees";
    private $_table = "employees e 
        LEFT JOIN emp_department d ON e.emp_dep_id=d.dep_id 
        LEFT JOIN emp_position p ON e.emp_pos_id=p.pos_id
        LEFT JOIN city c ON e.emp_city_id=c.city_id";

    private $_field = "   emp_id
                        , emp_code
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
                        , emp_permission

                        , d.dep_id
                        , d.dep_name
                        , d.dep_access as access
                        , d.dep_permission

                        , p.pos_id 
                        , p.pos_name
                        , p.pos_permission
                        , c.city_name";

    private $_cutNamefield = "emp_";

    public function lists( $options=array() ) {

        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:100,

            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'code_order',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'ASC',

            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),

            'more' => true
        ), $options);

        if( $options['sort']=='sequence' ){
            $options['sort']='code_order';
        }

        $date = date('Y-m-d H:i:s', $options['time']);

        if( isset($_REQUEST['view_stype']) ){
            $options['view_stype'] = $_REQUEST['view_stype'];
        }

        if(isset($_REQUEST['q']) ){
            $options['q'] = $_REQUEST['q'];
        }

        $where_str = "";
        $where_arr = array();
        
        $where_str .= !empty( $where_str ) ? " AND ":'';
        $where_str .= "d.dep_id=:dep";
        $where_arr[':dep'] = $this->_dep;
        
        if( isset($_REQUEST['position']) ) {
            $options['position'] = $_REQUEST['position'];
        }
        if( !empty($options['position']) ){
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
                $wq .= "emp_first_name LIKE :q{$key} OR emp_last_name LIKE :q{$key} OR emp_phone_number LIKE :s{$key} OR emp_phone_number=:f{$key} OR emp_code=:f{$key}";
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

        $arr['lists'] = $this->buildFrag( $this->db->select("SELECT {$this->_field} FROM {$this->_table} {$where_str} {$orderby} {$limit}", $where_arr ), $options  );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;
        
        return $arr;
    }

    public function buildFrag($results, $options=array()) {
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convert($value , $options);
        }
        return $data;
    }
    public function get($id, $options=array()){

        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} WHERE {$this->_cutNamefield}id=:id LIMIT 1");
        $sth->execute( array(
            ':id' => $id
        ) );

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ) , $options )
            : array();
    }
    public function convert($data , $options=array()){
        $data['role'] = 'emp';
        $data = $this->cut($this->_cutNamefield, $data);


        // name
        foreach ($this->query('system')->_prefixName() as $key => $value) {
            if( $value['id']==$data['prefix_name'] ){
                
                $data['prefix_name_str'] = $value['name'];
                break;
            }
        }
        if( empty($data['prefix_name_str']) ){
            $data['prefix_name_str'] = '';
        }
        $data['fullname'] = "{$data['prefix_name_str']}{$data['first_name']} {$data['last_name']}";
        $data['initials'] = $this->fn->q('text')->initials( $data['first_name'] );
        

        if( !empty($data['image_id']) ){
            $image = $this->query('media')->get($data['image_id']);

            if( !empty($image) ){
                $data['image_arr'] = $image;
                $data['image_url'] = $image['quad_url'];
            }
        }

        if( !empty($data['address']) ){
            $data['address'] = json_decode($data['address'],true);
        }

        if( !empty($data['address']['city']) ){
            $data['address']['city_name'] = $this->query('system')->city_name($data['address']['city']);
        }

        // access
        if( !empty($data['access']) ){
            $data['access'] = json_decode($data['access'], true);
        }

        // permission
        if( !empty($data['permission']) ){
            $data['permission'] = json_decode($data['permission'], true);
        }
        else if(!empty($data['pos_permission'])){
            $data['permission'] = json_decode($data['pos_permission'], true);
        }
        else if( !empty($data['dep_permission']) ){
            $data['permission'] = json_decode($data['dep_permission'], true);
        }

        if( isset($options['has_job']) && isset($options['date']) ){
            $job = $this->getJob($data['id'], array( 'status'=>'on', 'date'=>$_REQUEST['date'] ) );
            if( !empty($job) ){
                // print_r($job);
                $data['job_id'] = $job['job_id'];
            }
        }

        //Skill
        $data['skill'] = $this->query('employees')->listSkill( $data['id'] );

        $data['permit']['del'] = true;

        $view_stype = !empty($options['view_stype']) ? $options['view_stype']:'convert';
        if( !in_array($view_stype, array('bucketed', 'convert', 'vInvite')) ) $view_stype = 'convert';

        return $view_stype=='convert'
            ? $data
            : $this->{$view_stype}( $data );
    }
    public function bucketed($data , $options=array()) {

        $category = '';
        if( !empty($data['image_url']) ){
            $category .= 'No.'.$data['code'];
        }

        if( !empty($data['phone_number']) ){
            $category .= !empty($category) ? ", ":'';
            $category .= $data['phone_number'];
        }

        if( !empty($data['nickname']) ){
            $data['fullname'] .= " ({$data['nickname']})";
        }

        $fdata = array(
            'id'=> $data['id'],
            // 'created' => $data['created'],
            'text'=> $data['nickname'],
            "category"=> $category,
            "subtext"=> '', //!empty($data['phone_number']) ? $data['phone_number']:"",
            "image_url"=>!empty($data['image_url']) ? $data['image_url']:"",
            "type"=> !empty($data['job_type']) ? $data['job_type'] : "massager",

            "image_url"=>!empty($data['image_url']) ? $data['image_url']:"",
            'icon_text' => $data['code'],
            'code' => $data['code'],
            'skill' => $data['skill'],
        );

        if( !empty( $data['job_id'] ) ){
            $fdata['job_id'] = $data['job_id'];
        }

        if( !empty( $data['job_sequence']) ){
            $fdata['job_sequence'] = $data['job_sequence'];
        }

        return $fdata;
    }
    public function vInvite($data , $options=array()) {
        $category = '';

        // $category .= $data['fullname'];

        if( !empty($data['phone_number']) ){
            $category .= !empty($category) ? ", ":'';
            $category .= $data['phone_number'];
        }

        $fullname = "No.{$data['code']}";
        
        if( !empty($data['nickname']) ){
            $fullname .= " ({$data['nickname']})";
        }

        $fdata = array(
            'id'=> $data['id'],
            'text'=> $fullname,
            "category"=> $category,
            "image_url"=>!empty($data['image_url']) ? $data['image_url']:"",
            "type"=>"employees",

            'icon_text' => $data['code'],
            'skill' => $data['skill']
        );

        if( !empty( $data['job_id'] ) ){
            $fdata['job_id'] = $data['job_id'];
        }

        return $fdata;
    }

    public function getCode($code, $options=array()){

        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} WHERE emp_code=:code AND d.dep_id=:dep AND emp_code!='' AND `emp_display`='enabled' LIMIT 1");
        $sth->execute( array(
            ':code' => $code,
            ':dep' => $this->_dep
        ) );

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ) , $options )
            : array();
    }

    public function firstMasseuse() {

        $sth = $this->db->prepare("SELECT {$this->_field} FROM job_queue q 
            INNER JOIN ($this->_table) ON q.emp_id=e.emp_id 
            WHERE q.status=:status AND d.dep_id=:dep 
            ORDER BY sequence ASC LIMIT 1");
        $sth->execute(array(':status'=>'on', ':dep'=>$this->_dep));

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ) )
            : array();
    }
    

    /**/
    /* JOB */
    /**/
    public function listJob( $options=array() ){

        $options = array_merge(array(
            
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:100,

            'sort' => 'sequence',
            'dir' => 'ASC',
            'more' => true,

            'status' => isset($_REQUEST['status'])? $_REQUEST['status']: 'on',

            'date'=> isset($_REQUEST['date'])? date('Y-m-d',strtotime($_REQUEST['date'])):date('Y-m-d'),

        ), $options);

        if( isset($_REQUEST['view_stype']) ){
            $options['view_stype'] = $_REQUEST['view_stype'];
        }

        if( isset($_REQUEST['q']) ){
            $options['q'] = $_REQUEST['q'];
        }

        $where_str = "";
        $where_arr = array();

        $where_str .= !empty($where_str) ? " AND ": '';
        $where_str .= "d.dep_id=:dep";
        $where_arr[':dep'] = $this->_dep;

        if( !empty($options['date']) ){

            $where_str .= !empty($where_str) ? " AND ": '';
            $where_str .= "`job_date`=:d";
            $where_arr[':d'] = $options['date'];
        }

        if( isset($options['status']) ){
            
            $where_str .= !empty($where_str) ? " AND ": '';
            $where_str .= "`job_status`=:status";
            $where_arr[':status'] = $options['status'];
        }

        if( isset($options['q']) ){
            
            $arrQ = explode(' ', $options['q']);
            $wq = '';
            foreach ($arrQ as $key => $value) {
                $wq .= !empty( $wq ) ? " OR ":'';
                $wq .= "emp_first_name LIKE :q{$key} OR emp_last_name LIKE :q{$key} OR emp_phone_number LIKE :s{$key} OR emp_phone_number=:f{$key} OR emp_code=:f{$key}";
                $where_arr[":q{$key}"] = "%{$value}%";
                $where_arr[":s{$key}"] = "{$value}%";
                $where_arr[":f{$key}"] = $value;
            }

            if( !empty($wq) ){
                $where_str .= !empty( $where_str ) ? " AND ":'';
                $where_str .= "($wq)";
            }
        }

        $_table = "emp_job_queue j INNER JOIN ({$this->_table}) ON j.job_emp_id=e.emp_id";

        $arr['total'] = $this->db->count($_table, $where_str, $where_arr);

        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $orderby = $this->orderby( 'job_'.$options['sort'], $options['dir'] );
        $limit = !empty($options['unlimit']) ?'': $this->limited( $options['limit'], $options['pager'] );

        $arr['lists'] = $this->buildFrag( $this->db->select("SELECT 
              j.job_id
            , j.job_sequence
            , j.job_date
            , j.job_time
            , j.job_status
            , j.job_type
            , {$this->_field} FROM {$_table} {$where_str} {$orderby} {$limit}", $where_arr ), $options  );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        return $arr;
    }
    public function getJob( $id, $options=array() ){

        $options = array_merge(array(
            'date'=> isset($_REQUEST['date'])? date('Y-m-d',strtotime($_REQUEST['date'])):date('Y-m-d'),
        ), $options);


        $where_str = "e.emp_id=:id";
        $where_arr = array(":id" => $id);

        if( !empty($options['date']) ){

            $where_str .= !empty($where_str) ? " AND ": '';
            $where_str .= "`job_date`=:d";
            $where_arr[':d'] = $options['date'];
        }

        if( !empty($options['status']) ){

            $where_str .= !empty($where_str) ? " AND ": '';
            $where_str .= "`job_status`=:status";

            $where_arr[':status'] = $options['status'];
        }


        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $sth = $this->db->prepare("SELECT 
              j.job_id
            , j.job_sequence
            , j.job_date
            , j.job_time
            , j.job_status
            , j.job_type
            , {$this->_field} FROM emp_job_queue j INNER JOIN ($this->_table) ON j.job_emp_id=e.emp_id {$where_str} LIMIT 1");
        $sth->execute( $where_arr );

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ), array('view_stype'=>'bucketed') )
            : array();
    }
    public function setJob( $id, $options = array() ){

        $options = array_merge(array(
            'date'=> isset($_REQUEST['date'])? date('Y-m-d',strtotime($_REQUEST['date'])):date('Y-m-d'),
            'type' => isset($_REQUEST['type']) ? $_REQUEST['type']: 'massager',
        ), $options);


        // last Sequence
        $sequence = $this->nextJobSequence( $options );
        

        $theDate = new DateTime();
        $theTime = strtotime($options['date']);
        $theDate->setDate( date('Y', $theTime), date('n', $theTime), date('j', $theTime));

        $job = array(
            'job_type' => $options['type'],
            'job_emp_id' => $id,
            'job_sequence' => $sequence,
            'job_date' => $options['date'],
            'job_time' => isset($options['time']) ? date('H:s:i', strtotime($options['time']) ): date('H:s:i', time() ),
            'job_status' =>'on'
        );

        $this->db->insert("emp_job_queue", $job);
    }
    public function nextJobSequence( $options=array() ) {

        $where_str = "`job_date`=:d";
        $where_arr[':d'] = $options['date'];

        if( isset($options['type']) ){
            $where_str .= !empty($where_str) ? " AND ": '';
            $where_str .= "`job_type`=:type";
            $where_arr[':type'] = $options['type'];
        }

        if( !empty($options['status']) ){

            if( is_array($options['status']) ){

                $w = '';
                foreach ($options['status'] as $key => $value) {
                    $w .=  !empty($w) ? " OR ": '';
                    $w .= "`job_status`='{$value}'";
                }

                $where_str .= !empty($where_str) ? " AND ": '';
                $where_str .= "({$w})";
            }
            else{
                $where_str .= !empty($where_str) ? " AND ": '';
                $where_str .= "`job_status`=:status";
                $where_arr[':status'] = $options['status'];
            }

        }

        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        
        $sth = $this->db->prepare("SELECT job_sequence as q FROM emp_job_queue j {$where_str} ORDER BY job_sequence DESC LIMIT 1");
        $sth->execute( $where_arr );

        if( $sth->rowCount()==1 ){
            $fdata = $sth->fetch( PDO::FETCH_ASSOC );
            $sequence = $fdata['q'] + 1;
        }
        else{
            $sequence = 1;
        }

        return $sequence;
    }

    public function updateJob($id, $data) {
        $this->db->update("emp_job_queue", $data, "`job_id`={$id}");
    }

    public function deleteJob($id){
        $this->db->delete("emp_job_queue", "`job_id`={$id}");
    }
    
    public function lastSequence($options=array()) {
        
        $options = array_merge(array(
            'date'=> isset($_REQUEST['date'])? date('Y-m-d',strtotime($_REQUEST['date'])):date('Y-m-d'),
        ), $options);

        // $sequence = $this->model->lastSequence();

        $sth = $this->db->prepare("SELECT job_sequence as q FROM emp_job_queue WHERE (job_status=:status1 OR job_status=:status2) AND job_date=:d LIMIT 1 ORDER BY DESC");
        $sth->execute( array(
            ':status1' => 'run',
            ':status2' => 'done',
            ':d' => $options['date']
        ) );

        if( $sth->rowCount()==1 ){
            $fdata = $sth->fetch( PDO::FETCH_ASSOC );
            $sequence = $fdata['q'] + 1;
        }
        else{
            $sequence = 1;
        }

        return $sequence;
    }

    public function requireMasseuse($skill=array()){
        
        $masseuse = $this->listJob( array('date'=>$_GET['date'], 'unlimit'=>1, 'status'=>'on', 'view_stype'=>'bucketed'));

        $fdata = array();

        foreach ($masseuse['lists'] as $emp) { 
            foreach ($emp['skill'] as $val) {
                
                foreach ($skill as $data) {
                    if( $data['id']==$val['id'] ){
                        $fdata  = $emp;
                        break;
                    }
                }

                if( !empty( $fdata ) ) break;
            }

            if( !empty( $fdata ) ) break;
        }

        return $fdata;     
    }

    public function countJob( $id, $options=array() ){

        $options = array_merge(array(

            'date'=> isset($_REQUEST['date'])? date('Y-m-d',strtotime($_REQUEST['date'])):date('Y-m-d'),

        ), $options);


        $where_str = "`job_emp_id`=:id";
        $where_arr = array(":id" => $id);

        if( !empty($options['date']) ){

            $where_str .= !empty($where_str) ? " AND ": '';
            $where_str .= "`job_date`=:d";
            $where_arr[':d'] = $options['date'];
        }

        if( !empty($options['status']) ){

            $where_str .= !empty($where_str) ? " AND ": '';
            $where_str .= "`job_status`=:status";
            $where_arr[':status'] = $options['status'];
        }

        return $this->db->count("`emp_job_queue`", $where_str, $where_arr);
    }

    public function setTime( $data ){

        $data['end_date'] = !empty($data['end_date']) ? $data['end_date'] : '0000-00-00 00:00:00';

        $cutNamefield = 'clock_';
        $input = array();

        foreach ($data as $key => $value) {
            if( $key == 'id' ) continue;
            $input[$cutNamefield.$key] = $value;
        }

        if( !empty($data['id']) ){
            $this->db->update( 'emp_clocking', $input, "`clock_id`={$data['id']}");
        }
        else{
            $this->db->insert( 'emp_clocking', $input );
        }
    }

    public function get_time( $id ){

        $sth = $this->db->prepare("SELECT 
              j.clock_id
            , j.clock_start_date
            , j.clock_end_date
            , j.clock_date
            , {$this->_field} FROM emp_clocking j INNER JOIN ($this->_table) ON j.clock_emp_id=e.emp_id WHERE j.clock_id=:id LIMIT 1");
        $sth->execute( array(':id'=>$id) );

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ) )
            : array();
    }

    public function getTime( $id, $options=array() ){

        $options = array_merge(array(

            'date'=> isset($_REQUEST['date'])? date('Y-m-d',strtotime($_REQUEST['date'])):date('Y-m-d'),

        ), $options);


        $where_str = "e.emp_id=:id";
        $where_arr = array(":id" => $id);

        if( !empty($options['date']) ){

            $where_str .= !empty($where_str) ? " AND ": '';
            $where_str .= "`clock_date`=:d";
            $where_arr[':d'] = $options['date'];
        }

        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';

        $sth = $this->db->prepare("SELECT 
              j.clock_id
            , j.clock_start_date
            , j.clock_end_date
            , j.clock_date
            , {$this->_field} FROM emp_clocking j INNER JOIN ($this->_table) ON j.clock_emp_id=e.emp_id {$where_str} LIMIT 1");
        $sth->execute( $where_arr );

        return $sth->rowCount()==1
            ? $this->convert( $sth->fetch( PDO::FETCH_ASSOC ) )
            : array();
    }

    public function deleteTime( $id ){
        $this->db->delete("`emp_clocking`", "`clock_id`={$id}");
    }

    public function sortAll($did, $pid) {

        $data = $this->db->select( "SELECT emp_id as id, emp_code as code FROM employees WHERE `emp_dep_id`={$did} AND`emp_pos_id`={$pid}" );
        // $select = "p.pack_id, p.pack_name, p.pack_wage_price, oi.item_start_date, oi.item_end_date";
        // $from = "orders_items_masseuse oim 
        //           LEFT JOIN orders_items oi ON oim.item_id=oi.item_id
        //           LEFT JOIN package p ON oi.item_pack_id=p.pack_id";
        // $where_str = "oim.job_id=:id";
        // $where_arr[":id"] = $id;
        foreach ($data as $key => $value) {
            
            preg_match('/[^0-9]*([0-9]+)[^0-9]*/', $value['code'], $regs);
            $n = intval($regs[1]);

            $this->db->update( "employees", array('emp_code_order'=>$n), "`emp_id`={$value['id']}" );
        }
    }
}