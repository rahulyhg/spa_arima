<?php

class Masseuse extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index($id='', $section='services'){
		$this->view->setPage('on', 'masseuse' );

        // $data = $this->model->db->select( "SELECT emp_id, emp_code, emp_code_order FROM employees WHERE `emp_dep_id`=5 AND`emp_pos_id`=3" );
        // 

        // $n = 0;
        // foreach ($data as $key => $value) {
            // $n++;

            // preg_match('/[^0-9]*([0-9]+)[^0-9]*/', $value['emp_code'], $regs);
            // $n = intval($regs[1]);

            // $code = 'P'. sprintf("%03d",$n);

            // $n = $value['emp_code']; //substr($value['emp_code'],1);

            // $data[$key]['emp_code_order'] = sprintf("%02d",$n);

            // $this->model->db->update( "employees", array('emp_code_order'=>sprintf("%04d",$n) ), "`emp_id`={$value['emp_id']}" );
        // }

        // echo count($data); die;
        // print_r($data); die;
           
        if( !empty($id) ){

            $options = array();

            $options['options'] = 1;

            $item = $this->model->query('employees')->get( $id, $options );
            if( empty($item) ) $this->error();
            // print_r($item); die;

            $this->view->setData('id', $id );
            $this->view->setData('item', $item );
            $this->view->setData('tab', $section); 
            $this->view->render("masseuse/profile/display");
        }
        else{

            // print_r( $this->model->query('employees')->skill()); die;
            $this->view->setData('skill', $this->model->query('employees')->skill() );

            if( $this->format=='json' ) {
                $this->view->setData('results', $this->model->query('masseuse')->lists() );
                $render = "masseuse/lists/json";
            }
            else{

                // $this->view->elem('body')->addClass();
                $this->view->setData('position', $this->model->query('employees')->position(5) );
                $render = "masseuse/lists/display";
            }

            $this->view->render($render);
        }
	}

    public function get($id=null) {

        $item = $this->model->get( $id, array('view_stype'=>'bucketed') );
        if( empty($item) ) $this->error();
        // print_r($item); die;


        // $options[''] = $_REQUEST['view_stype'];

        echo json_encode($item);
    }

    public function set($id='', $name=''){
        
        $id = isset($_REQUEST['id']) ? $_REQUEST['id']: $id;
        $name = isset($_REQUEST['name']) ? $_REQUEST['name']: $name;
        $value = isset($_REQUEST['value']) ? $_REQUEST['value']: $value;

        $item = $this->model->query('employees')->get($id);
        if( empty($item) ) $this->error();

        if( $name=='skill' ){
            $this->model->query('employees')->unsetSkill( $id );

            foreach ($value as $val) {
                $this->model->query('employees')->setSkill( array(
                    'skill_id'=>$val,
                    'emp_id'=>$id,
                ) );
            }

        }else if( is_array($value) ){

        }
        else{

        }

        echo json_encode($item);
    }

    public function invite() {
        
        $options = array('view_stype'=>'bucketed', 'limit' => 20);
        if( isset($_REQUEST['position']) ){
            if( $_REQUEST['position']=='queue' ){

                $data = $this->model->listJob( $options );

            }
            else{

                $data = $this->model->lists( $options );
            }
        }

        
        $results = array();
        $results[] = array(
            'object_type'=>'employees', 
            'object_name'=>'Employee',
            'data' => $data
        );

        echo json_encode($results); die;
        print_r($results); die;
    }

}