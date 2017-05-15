<?php 
class Notes_Model extends Model {
	public function __construct() {
		parent::__construct();
	}

    private $_objType = "system_notes";
    private $_table = "system_notes c INNER JOIN employees u ON c.note_emp_id=u.emp_id";
    private $_field = "note_emp_id as emp_id, 
                       note_id as id, 
                       note_text as text, 
                       note_date as date, 
                       u.emp_first_name , 
                       u.emp_last_name, 
                       u.emp_prefix_name";
    private $_cutNamefield = "note_";

	public function notes( $options=array() ){

        $options = array_merge(array(
            'pager' => isset($_REQUEST['pager'])? $_REQUEST['pager']:1,
            'limit' => isset($_REQUEST['limit'])? $_REQUEST['limit']:8,

            'dir' => isset($_REQUEST['sort'])? $_REQUEST['sort']:'DESC',
            'sort' => isset($_REQUEST['dir'])? $_REQUEST['dir']: 'date', 

            'time'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
            'q' => isset($_REQUEST['q'])? $_REQUEST['q']:'',

            'more' => true
        ), $options);


        $where_str = '';
        $where_arr = array();

        /*$where_str = "`note_date`<=:d";
        $where_arr[':d'] = date('Y-m-d H:i:s', $options['time']);*/


        if( isset($_REQUEST['obj_id']) ){
            $options['obj_id'] = $_REQUEST['obj_id'];
            
            $where_str .=  !empty($where_str) ? ' AND ':'';
            $where_str .=  "`note_obj_id`=:obj_id";
            $where_arr[':obj_id'] = $options['obj_id'];
        }

        if( isset($_REQUEST['obj_type']) ){
            $options['obj_type'] = $_REQUEST['obj_type'];

            $where_str .=  !empty($where_str) ? ' AND ':'';
            $where_str .=  "`note_obj_type`=:obj_type";
            $where_arr[':obj_type'] = $options['obj_type'];
        }


        $date = date('Y-m-d H:i:s', $options['time']);

        $arr['total'] = $this->db->count('notes', $where_str, $where_arr);

        $where_str = !empty($where_str) ? "WHERE {$where_str}":'';
        $orderby = $this->orderby( 'note_'.$options['sort'], $options['dir'] );
        $limit = $this->limited( $options['limit'], $options['pager'] );
        
        $arr['lists'] = $this->buildFragNote( $this->db->select("SELECT {$this->_field} FROM {$this->_table} {$where_str} {$orderby} {$limit}", $where_arr ) );

        if( ($options['pager']*$options['limit']) >= $arr['total'] ) $options['more'] = false;
        $arr['options'] = $options;

        // print_r($arr); die;
        return $arr;
    }

    public function save_note(&$data)
    {
        $this->db->insert( $this->_objType, $data );
        $data['note_id'] = $this->db->lastInsertId();

        $data = $this->cut('note_', $data);
    }

    public function get_note( $id )
    {
        $sth = $this->db->prepare("SELECT {$this->_field} FROM {$this->_table} WHERE note_id=:id LIMIT 1");

        $sth->execute( array(
            ':id' => $id
        ) );

        return $sth->rowCount()==1
            ? $this->convertNote( $sth->fetch( PDO::FETCH_ASSOC ) )
            : array();
    }
    public function buildFragNote($results) {
        $data = array();
        foreach ($results as $key => $value) {
            if( empty($value) ) continue;
            $data[] = $this->convertNote( $value );
        }
        return $data;
    }
    public function convertNote($data){

        $data = $this->cut('note_', $data);
        $data['permit']['del'] = true;

        if( !empty($data['emp_first_name']) && !empty($data['emp_last_name']) ){

            foreach ($this->query('system')->_prefixName() as $key => $value) {
                if( $value['id']==$data['emp_prefix_name'] ){

                    $data['prefix_name_th'] = $value['name'];
                    break;
                }
            }

            $data['poster'] = "{$data['prefix_name_th']}{$data['emp_first_name']} {$data['emp_last_name']}";
        }

        return $data;

    }

    public function updateNote($id, $data)
    {
        $this->db->update($this->_objType, $data, "`note_id`={$id}" );
    }
    public function deleteNote($id)
    {
        $this->db->delete($this->_objType, "`note_id`={$id}" );
    }
    public function deleteNoteObj( $obj_id , $obj_type ){
        $this->db->delete($this->_objType, "`note_obj_id`={$obj_id} AND `note_obj_type`='{$obj_type}'", $this->db->count('notes', "`note_obj_id`=:obj_id AND `note_obj_type`=':obj_type'" , array(':obj_id'=>$obj_id , ':obj_type'=>$obj_type) ) );
    }
}