<?php

class Events_Model extends Model{

    public function __construct() {
        parent::__construct();
    }

    private $_objType = "events";
    private $_table = "events ev INNER JOIN employees em ON ev.event_emp_id = em.emp_id";
    
    private $_field = "ev.event_id,
                       event_title, 
    				   event_text, 
    				   event_location, 
    				   event_start, 
    				   event_end,
    				   event_created,
    				   event_updated,
                       event_color_code,
                       event_has_invite,
                       event_icon_id,

                       em.emp_id,
    				   em.emp_prefix_name,
    				   em.emp_first_name,
    				   em.emp_last_name";
    private $_cutNamefield = "event_";

    public function _setDate($data){
    	$data["event_updated"] = date('c');

    	return $data;
   	}

    public function insert(&$data) {

    	$data = $this->_setDate($data);
        
        $data["event_created"] = date('c'); // new create time
        $this->db->insert($this->_objType, $data );
        $data[$this->_cutNamefield.'id'] = $this->db->lastInsertId();
    }

    public function insertJoinEvent($data){
        $this->db->insert('events_obj_permit',$data);
    }

    public function update($id, $data) {
        $this->db->update($this->_objType, $this->_setDate($data), "{$this->_cutNamefield}id={$id}");
    }
    public function delete($id) {
        $this->db->delete($this->_objType, "{$this->_cutNamefield}id={$id}");
        $this->deleteJoinEvent( $id );
    }

    public function deleteJoinEvent( $id ){
        $this->db->delete( 'events_obj_permit', "event_id={$id}" , $this->db->count('events_obj_permit' , "event_id={$id}") );
    }

    public function deleteEventObj( $obj_id , $obj_type ){
        $this->db->delete( 'events_obj_permit', "obj_id={$obj_id} AND obj_type={$obj_type}", $this->db->count('events_obj_permit', "obj_id={$obj_id} AND obj_type={$obj_type}") );
    }

    public function lists( $options=array(), $emp_id=null ) {
        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:50,
            'more' => true,

            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: 'start',
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'DESC',
            
            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:null,

        ), $options);

        $date = date('Y-m-d H:i:s', $options['time']);

        if( isset($_REQUEST['view_stype']) ){
            $options['view_stype'] = $_REQUEST['view_stype'];
        }

        if( isset($_REQUEST['upcoming']) ){
            $options['upcoming'] = $_REQUEST['upcoming'];
        }

        $where_str = "";
        $where_arr = array();

        if( !empty($_REQUEST['obj_id']) && !empty($_REQUEST['obj_type']) ){
            $options['obj_id'] = $_REQUEST['obj_id'];
            $options['obj_type'] = $_REQUEST['obj_type'];

        }


        $groupby = '';
        if( !empty($options['obj_id']) && !empty($options['obj_type']) ){

            $this->_table .= ' LEFT JOIN events_obj_permit e ON ev.event_id=e.event_id';

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "(e.obj_id=:obj_id AND e.obj_type=:obj_type)";
            $where_arr[':obj_id'] = $options['obj_id'];
            $where_arr[':obj_type'] = $options['obj_type'];

        }
        else if( !empty($emp_id) ){

            $this->_table .= ' LEFT JOIN events_obj_permit e ON ev.event_id=e.event_id';

            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "ev.event_emp_id=:empid OR (e.obj_id=:empid AND e.obj_type=:obj_type)";

            $where_arr[':empid'] = $emp_id;
            $where_arr[':obj_type'] = 'employees';

            // $groupby = 'ev.event_id';
        }

        if( isset($options['upcoming']) ){
            $where_str .= !empty( $where_str ) ? " AND ":'';
            $where_str .= "ev.event_start>=:upcoming";
            $where_arr[':upcoming'] = date('Y-m-d 00:00:00');

            $options['dir'] = 'ASC';
        }

        $arr['total'] = $this->db->count($this->_table, $where_str, $where_arr);

        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $orderby = $this->orderby( $this->_cutNamefield.$options['sort'], $options['dir'] );
        $limit = !empty($options['unlimit']) ? '' : $this->limited( $options['limit'], $options['pager'] );

        $groupby = !empty($groupby) ? "ORDER BY {$groupby}" :'';

        // echo "SELECT {$this->_field} FROM {$this->_table} {$where_str} {$groupby} {$orderby} {$limit}"; die;
        $arr['lists'] = $this->buildFrag( $this->db->select("SELECT {$this->_field} FROM {$this->_table} {$where_str} {$groupby} {$orderby} {$limit}", $where_arr ), $options );
        
        // 
        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;
        

        return $arr;
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

    public function buildFrag($results, $options=array()) {
        $data = array();

        $view_stype = !empty($options['view_stype']) ? $options['view_stype']:'convert';
        if( !in_array($view_stype, array('bucketed', 'convert')) ) $view_stype = 'convert';

        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->{$view_stype}($value);
        }
        return $data;
    }
    public function bucketed($data) {
        
        $data = $this->convert( $data );

        $subtext = '';
        if( !empty($data['location']) ){
            $subtext = '<i class="icon-map-marker"></i>'.$data['location'];
        }
        else{
            $subtext = $this->fn->q('text')->more( $data['text'], 30 );
        }

        if( $data['end']=='0000-00-00 00:00:00' ){
            $data['end'] = $data['start'];
        }

        return array(
            'id'=> $data['id'],
            "type"=>"events",
            'url' => URL.'events/'.$data['id'],
            'plugin' => 'dialog',
            'text'=> $data['title'],
            "category"=> '<i class="icon-clock-o"></i>'.$this->fn->q('time')->str_event_date($data['start'], $data['end']),
            "subtext"=> $subtext,
            'start_date' => $data['start'],
            'end_date' => $data['end'],
            'color_code' => trim($data['color_code'], '#'),
        );
    }
    
    public function convert($data){

        $data = $this->cut($this->_cutNamefield, $data);

        if( $data['end']=="0000-00-00 00:00:00" ){
            $data['end'] = $data['start'];
        }
        
        $data['permit']['del'] = true;


        /*foreach ($this->query('system')->_prefixName() as $key => $value) {
            if( $value['id']==$data['emp_prefix_name'] ){
                
                $data['prefix_name_th'] = $value['name'];
                break;
            }
        }

        if( empty($data['prefix_name_th']) ){
            $data['prefix_name_th'] = '';
        }

        $data['emp_fullname'] = "{$data['prefix_name_th']}{$data['emp_first_name']} {$data['emp_last_name']}";*/

        $data['invite'] = $this->listInvite( $data['id'] );

        return $data;
    }

    public function listInvite( $id ){

        $options = array('view_stype'=>'bucketed');

        $customers = $this->db->select("SELECT c.cus_id, c.cus_prefix_name , c.cus_first_name , c.cus_last_name , c.cus_created FROM customers c LEFT JOIN events_obj_permit p ON c.cus_id=p.obj_id WHERE p.event_id=:id AND p.obj_type='customers'" , array(':id'=>$id) );

        $employees = $this->db->select("SELECT e.emp_id, e.emp_first_name , e.emp_last_name , e.emp_prefix_name FROM employees e LEFT JOIN events_obj_permit p ON e.emp_id=p.obj_id WHERE p.event_id=:id AND p.obj_type='employees'" , array(':id'=>$id) );

        $data['customers'] = $this->query('customers')->buildFrag( $customers , $options );
        $data['employees'] = $this->query('employees')->buildFrag( $employees , $options );

        return $data;
    }

    
}
