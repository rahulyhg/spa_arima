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

    public function add(){

        $this->view->setData('dealer', $this->model->query('dealer')->lists());
        $this->view->setData('dep_id', 5);
        $this->view->setData('position', $this->model->query('employees')->position(5));
        $this->view->setData('prefixName', $this->model->query('system')->_prefixName());
        $this->view->setData('city', $this->model->query('system')->city());
        $this->view->setPage('path', 'Forms/masseuse');
        $this->view->render('add');
    }

    public function save(){
        if( empty($_POST) ) $this->error();

        $id = isset($_POST['id']) ? $_POST['id']: null;
        if( !empty($id) ){
            $item = $this->model->get($id);
            if( empty($item) ) $this->error();
        }

        try {
            $form = new Form();
            $form   ->post('emp_dealer_id')->val('is_empty')
                    ->post('emp_code')
                    ->post('emp_pos_id')->val('is_empty')
                    ->post('emp_dep_id')
                    ->post('emp_prefix_name')
                    ->post('emp_first_name')->val('is_empty')
                    ->post('emp_last_name')
                    ->post('emp_nickname')
                    ->post('emp_phone_number')
                    ->post('emp_email')
                    ->post('emp_line_id')
                    ->post('emp_notes');

            $form->submit();
            $postData = $form->fetch();

            $has_name = true;
            $has_code = true;
            if( !empty($id) ){
                if( $postData['emp_first_name'] == $item['first_name'] && $postData['emp_last_name'] == $item['last_name'] ){
                    $has_name = false;
                }

                if( $postData['emp_code'] == $item['code'] ){
                    $has_code = false;
                }
            }

            if( $this->model->is_name( $postData['emp_first_name'] , $postData['emp_last_name'] ) && $has_name == true ){
                $arr['error']['emp_name'] = "มีชื่อ-นามสกุลนี้ ในระบบแล้ว";
            }

            if( !empty($postData['emp_code']) ){
                if( $this->model->is_code( $postData['emp_code'] ) && $has_name == true ){
                    $arr['error']['emp_code'] = "มีหมายเลขนี้อยู่ในระบบแล้ว";
                }
            }

            /**/
            /* SET Address */
            /**/
            // foreach ($_POST['address'] as $key => $value) {

            //     if( empty($value) && $key != 'village' && $key !='street' && $key != 'alley'){
            //         $arr['error']['emp_address'] = 'กรอกข้อมูลที่อยู่ให้ครบถ้วน';
            //     }

            //     if( $key == 'zip' ){
            //         if( strlen($value) != '5' ){
            //             $arr['error']['emp_address'] = 'กรอกข้อมูลที่อยู่ให้ครบถ้วน';
            //         }
            //     }
            // }

            $futureDate = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " -6 year"));
            $birthday = date("{$_POST['birthday']['year']}-{$_POST['birthday']['month']}-{$_POST['birthday']['date']}");
            if( strtotime($birthday) > strtotime($futureDate) ){
                $arr['error']['birthday'] = 'วันเกิดไม่ถูกต้อง';
            }

            $postData['emp_first_name'] = trim($postData['emp_first_name']);
            $postData['emp_last_name'] = trim($postData['emp_last_name']);
            $postData['emp_address'] = json_encode($_POST['address']);
            $postData['emp_city_id'] = $_POST['address']['city'];
            $postData['emp_zip'] = $_POST['address']['zip'];
            $postData['emp_birthday'] = $birthday;

            if( empty($arr['error']) ){

                if( !empty($item) ){
                    $this->model->query('employees')->update( $id, $postData );
                }
                else{
                    $this->model->query('employees')->insert( $postData );
                    $id = $postData['id'];
                }

                if( !empty($_FILES['file1']) ){

                    $userfile = $_FILES['file1'];

                    if( !empty($item['image_id']) ){
                        $this->model->query('media')->del($item['image_id']);
                        $this->model->query('employees')->update( $id, array('emp_image_id'=>0 ) );
                    }

                    $album = array('album_id'=>1);
                    
                    if( empty($structure) ){
                        $structure = WWW_UPLOADS . $album['album_id'];
                        if( !is_dir( $structure ) ){
                            mkdir($structure, 0777, true);
                        }
                    }

                    /**/
                    /* get Data Album */
                    /**/
                    $options = array(
                        'album_obj_type' => isset( $_REQUEST['obj_type'] ) ? $_REQUEST['obj_type']: 'public',
                        'album_obj_id' => isset( $_REQUEST['obj_id'] ) ? $_REQUEST['obj_id']: 1,
                        );

                    if( isset( $_REQUEST['album_name'] ) ){
                        $options['album_name'] = $_REQUEST['album_name'];
                    }
                    $album = $this->model->query('media')->searchAlbum( $options );

                    if( empty($album) ){
                        $this->model->query('media')->setAlbum( $options );
                        $album = $options;
                    }

                    // set Media Data
                    $media = array(
                        'media_album_id' => $album['album_id'],
                        'media_type' => isset($_REQUEST['media_type']) ? $_REQUEST['media_type']: strtolower(substr(strrchr($userfile['name'],"."),1))
                        );

                    $options = array(
                        'folder' => $album['album_id'],
                        'has_quad' => true,
                        );

                    if( !isset($media['media_emp_id']) ){
                        $media['media_emp_id'] = $this->me['id'];
                    }

                    $this->model->query('media')->set( $userfile, $media, $options );

                    if( empty($media['error']) ){
                        $media = $this->model->query('media')->convert($media);
                    }
                    $item['image_id'] = $media['id'];
                    $this->model->query('employees')->update( $id, array('emp_image_id'=>$item['image_id'] ) );
                    
                }

                // resize 
                if( !empty($_POST['cropimage']) && !empty($item['image_id']) ){
                    $this->model->query('media')->resize($item['image_id'], $_POST['cropimage']);
                }

                $arr['message'] = 'บันทึกเรียบร้อย';
                $arr['url'] = 'refresh';
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());

            if( !empty($arr['error']['emp_first_name']) ){
                $arr['error']['name'] = $arr['error']['emp_first_name'];
            } else if( !empty($arr['error']['emp_last_name']) ){
                $arr['error']['name'] = $arr['error']['emp_last_name'];
            }
        }

        echo json_encode($arr);
    }

    public function get($id=null) {

        $options = array('view_stype'=>'bucketed');
        if( isset($_REQUEST['has_job']) && isset($_REQUEST['date']) ){
            $options['has_job'] = $_REQUEST['has_job'];
            $options['date'] = $_REQUEST['date'];
        }
        $item = $this->model->get( $id, $options );
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
        
        $options = array('view_stype'=>'vInvite', 'limit' => 20);
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
            $this->view->setData('position', $this->model->query('employees')->position(5));
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

        $options['status'] = 'on';
        if( isset($_REQUEST['date']) ){
            $options['date'] = $_REQUEST['date'];
            $this->view->setData('date', $options['date']);
        }

        $job = $this->model->getJob( $id, $options);
        if( empty($job) ) $this->error();

        $time = $this->model->getTime( $id, $options );

        $this->view->setData('skill', $this->model->query('employees')->skill());
        $this->view->setData('item', $item);
        $this->view->setData('job', $job);
        $this->view->setData('time', $time);
        $this->view->render('masseuse/forms/skill');
    }

    public function cancel( $id=null ){

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($id) ) $this->error();

        $item = $this->model->get( $id );
        if( empty($item) ) $this->error();

        $options['status'] = 'on';
        if( isset($_REQUEST['date']) ){
            $options['date'] = $_REQUEST['date'];
            $this->view->setData('date', $options['date']);
        }

        $job = $this->model->getJob( $id, $options);
        if( empty($job) ) $this->error();

        if( !empty($_POST) ){

            // $postData['job_status'] = 'cancel';
            // $this->model->updateJob( $job['job_id'], $postData );

            $this->model->deleteJob( $job['job_id'] );

            $count_job = $this->model->countJob( $id, $options );
            if( empty($count_job) ){

                $time = $this->model->getTime( $id, $options );
                if( !empty($time) ){
                    $this->model->deleteTime( $time['clock_id'] );
                }
            }

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

    public function monitor() {
        
        $this->view->setPage('theme', 'monitor');
        $this->view->setPage('theme_options', array(
            'has_footer' => false,
            'has_topbar' => false,
            'has_menu' => false,
            
        ));  
        $date = isset($_REQUEST['date']) ? $_REQUEST['date']: date('Y-m-d'); 

        $this->view->setData('date', $date );
        $this->view->setData('lists', $this->model->query('masseuse')->listJob( array('date'=>$date, 'unlimit'=>1, 'status'=>'on' ) ) );
        $this->view->setData('run', $this->model->query('masseuse')->listJob( array('date'=>$date, 'unlimit'=>1, 'status'=>'run' ) ) );
        $this->view->setData('clock', $this->model->query('masseuse')->lists( array('clock_date'=>$date, 'unlimit'=>1) ) );
        $this->view->render('masseuse/display');   
    }

    public function edit_time( $id=null ){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($id) || empty($this->me) ) $this->error();

        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date("Y-m-d");

        $item = $this->model->get_time( $id );
        if( empty($item) ) $this->error();

        if( !empty($_POST) ){

            $start_date = date("{$_POST['start_date']} {$_POST['start_time_hour']}:{$_POST['start_time_minute']}:s");
            $end_date = date("{$_POST['end_date']} {$_POST['end_time_hour']}:{$_POST['end_time_minute']}:s");

            $postData = array(
                'id'=>$id,
                'start_date'=>$start_date,
                'end_date'=>$end_date
            );

            $this->model->setTime( $postData );
            $arr['message'] = 'บันทึกเรียบร้อย';
            $arr['url'] = 'refresh';

            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->setData('date', $date);
            $this->view->render('masseuse/forms/edit_job_time');
        }
    }

    public function cancelAll(){

        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date("Y-m-d");

        if( !empty($_POST) ){

            $listJob = $this->model->query('masseuse')->listJob( array('date'=>$date, 'unlimit'=>1, 'status'=>'on' ) );

            foreach ($listJob['lists'] as $key => $value) {

                $count_job = $this->model->countJob( $value['id'], array('date'=>$date) );
                
                if( $count_job == 1 ){
                    $time = $this->model->getTime( $value['id'], array('date'=>$date) );
                    if( !empty($time) ){
                        $this->model->deleteTime( $time['clock_id'] );
                    }
                }
                $this->model->deleteJob( $value['job_id'] );
            }

            $arr['message'] = 'ยกเลิกคิวทั้งหมด เรียบร้อย!';
            $arr['url'] = 'refresh';

            echo json_encode($arr);
        }
        else{

            $this->view->setData('date', $date);
            $this->view->render('masseuse/forms/job_all_cancel');
        }
    }
}