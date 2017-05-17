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

            $order = $this->model->query('orders')->get_masseuse_item( $id );
            // --- SET ORDER --- //

            $this->view->setData('id', $id );
            $this->view->setData('item', $item );
            $this->view->setData('order', $order);
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

    public function update( $id=null , $section=null ){

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        $section = isset($_REQUEST['section']) ? $_REQUEST['section'] : $section;
        if( empty($id) || empty($section) ||  empty($this->me) ) $this->error();

        $item = $this->model->query('masseuse')->get( $id );

        if( !empty($_POST) ){

            $postData = array();

            if( $section == 'basic' ){
                try{

                    $form = new Form();
                    $form   ->post('emp_prefix_name')
                            ->post('emp_first_name')->val('is_empty')
                            ->post('emp_last_name')
                            ->post('emp_nickname');

                    $form->submit();
                    $postData = $form->fetch();

                    $futureDate = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " -6 year"));
                    $birthday = date("{$_POST['birthday']['year']}-{$_POST['birthday']['month']}-{$_POST['birthday']['date']}");

                    if( $birthday != '0000-00-00' ){
                        if( strtotime($birthday) > strtotime($futureDate) ){
                            $arr['error']['birthday'] = 'วันเกิดไม่ถูกต้อง';
                        }
                    }

                    $postData['emp_first_name'] = trim($postData['emp_first_name']);
                    $postData['emp_last_name'] = trim($postData['emp_last_name']);
                    $postData['emp_birthday'] = $birthday;

                }catch (Exception $e) {
                    $arr['error'] = $this->_getError($e->getMessage());
                }
            }
            elseif( $section == 'contact' ){

                try{

                    $form = new Form();
                    $form   ->post('emp_phone_number')
                            ->post('emp_email')
                            ->post('emp_line_id')
                            ->post('emp_notes');

                    $form->submit();
                    $postData = $form->fetch();

                    // foreach ($_POST['address'] as $key => $value) {
                    //     if( empty($value) && $key != 'village' && $key !='street' && $key != 'alley') {
                    //         $arr['error']['emp_address'] = 'กรุณากรอกข้อมูลในช่องที่มีเครื่องหมาย * ให้ครบถ้วน';
                    //     }
                    // }

                    // if( !empty($_POST['address']['zip']) && strlen($_POST['address']['zip']) != 5 ){
                    //     $arr['error']['emp_address'] = 'กรุณากรอกรหัสไปรษณีย์ให้ครบ 5 หลัก';
                    // }

                    $postData['emp_address'] = json_encode($_POST['address']);
                    $postData['emp_city_id'] = $_POST['address']['city'];
                    $postData['emp_zip'] = $_POST['address']['zip'];

                }catch (Exception $e) {
                    $arr['error'] = $this->_getError($e->getMessage());
                }
            }
            else{
                $this->error();
            }

            if( empty($arr['error']) ){

                $this->model->query('employees')->update( $id, $postData );
                $arr['message'] = 'บันทึกเรียบร้อย';
                $arr['url'] = 'refresh';
            }

            echo json_encode($arr);
        }
        else{

            $this->view->setData('city', $this->model->query('system')->city());
            $this->view->setData('prefixName', $this->model->query('system')->_prefixName());
            $this->view->setData('item', $item);
            $this->view->render('masseuse/forms/edit_'.$section);
        }

    }

    public function skill( $id=null ){

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($id) ) $this->error();

        $item = $this->model->get( $id );
        if( empty($item) ) $this->error();

        $this->view->setData('skill', $this->model->query('employees')->skill());
        $this->view->setData('item', $item);
        $this->view->render('masseuse/forms/skill');
    }

    public function cancel( $id=null ){

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($id) ) $this->error();

        $item = $this->model->get( $id );
        if( empty($item) ) $this->error();

        $job = $this->model->getJob( $id );
        if( empty($job) ) $this->error();

        if( !empty($_POST) ){

            $postData['job_status'] = 'cancel';
            $this->model->updateJob( $job['job_id'], $postData );

            $arr['message'] = 'ยกเลิกคิวบริการเรียบร้อย';
            $arr['url'] = 'refresh';

            echo json_encode($arr);
        }
        else{

            $this->view->setData('item', $item);
            $this->view->setData('job', $job);
            $this->view->render('masseuse/forms/job_cancel');
        }
    }

    public function sort_job() {
        
        $sequence = $this->model->lastSequence();
        foreach ($_POST['items'] as $id) {
            $this->model->updateJob( $id, array('job_sequence'=>$sequence) );
            $sequence++;
        }
    }
}