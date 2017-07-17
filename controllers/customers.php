<?php

class Customers extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index( $id=null, $section='services' ) {
    	$this->view->setPage('on', 'customers' );
           
        if( !empty($id) ){

            $options = array();

            $options['options'] = 1;

            $item = $this->model->query('customers')->get( $id, $options );
            if( empty($item) ) $this->error();

            /* ประวัติการรับบริการ */
            $services = $this->model->query('orders')->get_customer_item( $id );
            $this->view->setData('services', $services);

            /* ประวัติการจอง */
            $booking = $this->model->query('orders')->get_customer_item( $id, array('status'=>'booking') );
            $this->view->setData('booking', $booking);

            $this->view->setData('id', $id );
            $this->view->setData('item', $item );
            $this->view->setData('tab', $section); 
            $this->view->render("customers/profile/display");
        }
        else{

            // print_r($this->model->query('customers')->lists()); die;
            
            if( $this->format=='json' )
            {
                $this->view->setData('results', $this->model->query('customers')->lists() );
                $render = "customers/lists/json";
            }
            else{

                $this->view->setData('level', $this->model->level() );
                $this->view->setData('status', $this->model->query('customers')->lists_status() );

                $render = "customers/lists/display";
            }

            $this->view->render($render);
        }
    }

    public function search(){
        if( empty($this->me) || $this->format!='json' ) $this->error();

        echo json_encode( $this->model->lists() );
    }

    public function get($id=null){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id']:$id;
        if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

        $item = $this->model->get($id, array('options' => 1));
        if( empty($item) ) $this->error();

        echo json_encode($item);


        /*if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

        $item = $this->model->get($id, array('options' => 1));
        if( empty($item) ) $this->error();

        $this->view->setData('prefixName', $this->model->prefixName());
        $this->view->setData('customer', $item );
        $this->view->render("customers/forms/profile");*/
    }

    /*public function _get($id) {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id']:$id;
        if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

        $item = $this->model->get($id, array('options' => 1));
        if( empty($item) ) $this->error();

        echo json_encode($item);
    }*/

    public function add() {
    	if( empty($this->me) ) $this->error();

        $this->view->setData('prefixName', $this->model->query('system')->_prefixNameCustomer());
        $this->view->setData('sex', $this->model->lists_sex());
        $this->view->setData('city', $this->model->query('system')->city() );
        $this->view->setData('level', $this->model->level() );

        $this->view->render("customers/forms/add_or_edit_dialog");
    }

    public function edit( $id=null ){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id']: $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();

        $item = $this->model->get( $id, array('options'=>true) );
        if( empty($item) ) $this->error();
        $this->view->setData('item', $item );

        
        $this->view->setData('prefixName', $this->model->query('system')->_prefixNameCustomer());
        $this->view->setData('sex', $this->model->lists_sex());
        $this->view->setData('city', $this->model->query('system')->city());
        $this->view->setData('level', $this->model->level() );

        $this->view->render("customers/forms/add_or_edit_dialog");
    }

    public function edit_basic($id=null){
        if( empty($this->me) || empty($id) ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        $this->view->setData('prefixName', $this->model->query('system')->_prefixNameCustomer());
        $this->view->setData('sex', $this->model->lists_sex());
        $this->view->setData('level', $this->model->level() );
        
        $this->view->setData('item', $item);
        $this->view->render('customers/forms/edit_basic');
    }
    public function edit_contact($id=null){
        if( empty($this->me) || empty($id) ) $this->error();

        $item = $this->model->get($id, array('options'=>true));
        if( empty($item) ) $this->error();

        $this->view->setData('city', $this->model->query('system')->city());
        $this->view->setData('item', $item);
        $this->view->render('customers/forms/edit_contact');
    }
    public function edit_cus_level($id=null){
        if( empty($this->me) || empty($id) ) $this->error();

        $item = $this->model->get($id, array('options'=>true));
        if( empty($item) ) $this->error();

        $this->view->setData('level', $this->model->level());
        $this->view->setData('item', $item);
        $this->view->render('customers/forms/edit_cus_level');
    }

    public function save() {
    	if( empty($this->me) ||empty($_POST) ) $this->error();

        $id = isset($_POST['id']) ? $_POST['id']: null;
        if( !empty($id) ){
            $item = $this->model->get($id, array('options'=> true));
            if( empty($item) ) $this->error();
        }


        try {
            $form = new Form();
            $form   ->post('cus_prefix_name')
                    ->post('cus_code')
                    ->post('cus_level_id')->val('is_empty')
                    ->post('cus_first_name')->val('is_empty')
                    ->post('cus_last_name')
                    ->post('cus_nickname')
                    ->post('cus_card_id')
                    ->post('cus_is_unlimit');

            $form->submit();
            $postData = $form->fetch();

            $birthday = '';
            if( !empty($_POST['birthday']) ){
                $futureDate = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " -6 year"));
                $birthday = date("{$_POST['birthday']['year']}-{$_POST['birthday']['month']}-{$_POST['birthday']['date']}");

                if( $birthday != '0000-00-00' ){
                    if( strtotime($birthday) > strtotime($futureDate) ){
                        $arr['error']['birthday'] = 'วันเกิดไม่ถูกต้อง';
                    }
                }
            }

            $postData['cus_birthday'] = !empty($birthday) ? $birthday : '0000-00-00';
            $postData['cus_first_name'] = trim($postData['cus_first_name']);
            $postData['cus_last_name'] = trim($postData['cus_last_name']);

            $has_name = true;
            if( !empty($item) ){
                if( $postData['cus_first_name'] == $item['fist_name'] && $postData['cus_last_name'] == $item['last_name'] ){
                    $has_name = false;
                }
            }

            if( $this->model->is_name( $postData['cus_first_name'] , $postData['cus_last_name'] ) && $has_name == true ){
                $arr['error']['cus_name'] = 'มีชื่อนี้อยู่ในระบบแล้ว';
            }

            // set options
            $options = array();
            foreach ($_POST['options'] as $type => $values) {
                foreach ($values['name'] as $key => $value) {

                    if( empty($values['value'][$key]) ) continue;

                    $options[$type][] = array(
                        'type' => $type,
                        'label' => trim($value), 
                        'value' => trim($values['value'][$key])
                    );
                }
            }

            $postData['cus_email'] = !empty($options['email'][0]['value'])
            ? $options['email'][0]['value']
            : '';

            $postData['cus_phone'] = !empty($options['phone'][0]['value'])
            ? $options['phone'][0]['value']
            : '';

            $postData['cus_lineID'] = !empty($options['social'][0]['value'])
            ? $options['social'][0]['value']
            : '';

            // Set Expired 
            if( empty($postData['cus_is_unlimit']) ){
                if( strtotime($_POST['start_date']) >= strtotime($_POST['end_date']) ){
                    $arr['error']['ex_time'] = 'กำหนดเวลาไม่ถูกต้อง';
                }

                $ex = array(
                    'ex_start_date'=>$_POST['start_date'],
                    'ex_end_date'=>$_POST['end_date'],
                    'ex_emp_id'=>$this->me['id'],
                );
            }

            // if( strlen($_POST['address']['zip']) != 5 ){
            //     $arr['error']['cus_address'] = 'กรุณากรอกรหัสไปรษณีย์ให้ครบ 5 หลัก';
            // }

            if( empty($arr['error']) ){

                $postData['cus_city_id'] = $_POST['address']['city'];
                $postData['cus_zip'] = $_POST['address']['zip'];
                $postData['cus_address'] = json_encode($_POST['address']);

                if( !empty($item) ){
                    $this->model->update( $id, $postData );
                }
                else{

                    $postData['cus_emp_id'] = $this->me['id'];
                    $ex['ex_status'] = 'run';

                    if( $_POST['end_date'] < date("Y-m-d") ){
                        $postData['cus_status'] = 'expired';
                        $ex['ex_status'] = 'expired';
                    }
                    
                    $this->model->insert( $postData );
                    $id = $postData['cus_id'];

                    if( empty($postData['cus_is_unlimit']) ){
                        $ex['ex_cus_id'] = $id;
                        $this->model->setExpired( $ex );
                    }

                    $arr['url'] = URL.'customers/'.$postData['cus_id'];
                }


                if( !empty($options) ){
                    if( !empty($item['options']) ){

                        $_options = array();
                        foreach ($item['options'] as $types => $values) {
                            foreach ($values as $key => $value) {
                                $value['type'] = $types;
                                $_options[] = $value;
                            } 
                        }
                    }

                    $c=0;
                    foreach ($options as $key => $values) {
                        foreach ($values as $data) {

                            if( !empty($_options[$c]['id']) ){
                                $data['id'] = $_options[$c]['id'];
                                unset($_options[$c]);
                            }

                            $data['cus_id'] = $id;
                            $this->model->set_option( $data );
                            $c++;     
                        }
                    }


                    if( !empty($_options) ){
                        foreach ($_options as $key => $value) {
                            $this->model->del_option( $value['id'] );
                        }
                    }
                }

                $arr['message'] = 'บันทึกเรียบร้อย';
                $arr['url'] = 'refresh';

                if( isset( $_REQUEST['callback'] ) ){
                    $item = !empty($item) ? $item: array();
                    $postData['options'] = $options;
                    $arr['data'] = array_merge($item, $this->model->convert($postData) );
                }
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());

            if( !empty($arr['error']['cus_prefix_name']) ){
                $arr['error']['name'] = $arr['error']['cus_prefix_name'];
            } else if( !empty($arr['error']['cus_first_name']) ){
                $arr['error']['name'] = $arr['error']['cus_first_name'];
            } else if( !empty($arr['error']['cus_last_name']) ){
                $arr['error']['name'] = $arr['error']['cus_last_name'];
            }
        }

        echo json_encode($arr);
    }

    public function update_basic(){
        if( empty($this->me) ||empty($_POST) ) $this->error();

        $id = isset($_POST['id']) ? $_POST['id']: null;

        if( empty($id) ) $this->error();

        $item = $this->model->get($id);

        if( empty($item) ) $this->error();

        $birthday = '';
        if( !empty($_POST['birthday']) ){
            $futureDate = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " -6 year"));
            $birthday = date("{$_POST['birthday']['year']}-{$_POST['birthday']['month']}-{$_POST['birthday']['date']}");

            if( $birthday != '0000-00-00' ){
                if( strtotime($birthday) > strtotime($futureDate) ){
                    $arr['error']['birthday'] = 'วันเกิดไม่ถูกต้อง';
                }
            }
        }

        try {
            $form = new Form();
            $form   ->post('cus_prefix_name')
                    ->post('cus_first_name')->val('is_empty')
                    ->post('cus_last_name')
                    ->post('cus_nickname')
                    ->post('cus_card_id');


            $form->submit();
            $postData = $form->fetch();

            $postData['cus_birthday'] = $birthday;
            $postData['cus_first_name'] = trim($postData['cus_first_name']);
            $postData['cus_last_name'] = trim($postData['cus_last_name']);

            if( empty($arr['error']) ){

                $this->model->update( $id, $postData );
                
                $arr['message'] = 'บันทึกเรียบร้อย';
                $arr['url'] = 'refresh';
                
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());

            if( !empty($arr['error']['cus_prefix_name']) ){
                $arr['error']['name'] = $arr['error']['cus_prefix_name'];
            } else if( !empty($arr['error']['cus_first_name']) ){
                $arr['error']['name'] = $arr['error']['cus_first_name'];
            } else if( !empty($arr['error']['cus_last_name']) ){
                $arr['error']['name'] = $arr['error']['cus_last_name'];
            }
        }

        echo json_encode($arr);
    }

    public function update_contact(){
        if( empty($this->me) ||empty($_POST) ) $this->error();

        $id = isset($_POST['id']) ? $_POST['id']: null;

        if( empty($id) ) $this->error();

        $item = $this->model->get($id, array('options'=> true));

        if( empty($item) ) $this->error();

        try {

            // foreach ($_POST['address'] as $key => $value) {
            //     if( empty($value) && $key != 'village' && $key !='street' && $key != 'alley') {
            //         $arr['error']['cus_address'] = 'กรุณากรอกข้อมูลในช่องที่มีเครื่องหมาย * ให้ครบถ้วน';
            //     }
            // }
            
            // set options
            $options = array();
            foreach ($_POST['options'] as $type => $values) {
                foreach ($values['name'] as $key => $value) {

                    if( empty($values['value'][$key]) ) continue;

                    if( $type == 'social' && $value == 'Line ID' ){
                        $postData['cus_lineID'] = trim($values['value'][$key]);
                    }

                    $options[$type][] = array(
                        'type' => $type,
                        'label' => trim($value), 
                        'value' => trim($values['value'][$key])
                        );
                }
            }

            $postData['cus_email'] = !empty($options['email'][0]['value'])
            ? $options['email'][0]['value']
            : '';

            $postData['cus_phone'] = !empty($options['phone'][0]['value'])
            ? $options['phone'][0]['value']
            : '';

            if( empty($postData['cus_lineID']) ) $postData['cus_lineID'] = '';

            /*if( strlen($_POST['address']['zip']) != 5 ){
                $arr['error']['cus_address'] = 'กรุณากรอกรหัสไปรษณีย์ให้ครบ 5 หลัก';
            }*/

            if( empty($arr['error']) ){

                $postData['cus_city_id'] = $_POST['address']['city'];

                $postData['cus_zip'] = $_POST['address']['zip'];

                $postData['cus_address'] = json_encode($_POST['address']);

                $this->model->update( $id, $postData );

                if( !empty($options) ){
                    if( !empty($item['options']) ){

                        $_options = array();
                        foreach ($item['options'] as $types => $values) {
                            foreach ($values as $key => $value) {
                                $value['type'] = $types;
                                $_options[] = $value;
                            } 
                        }
                    }

                    $c=0;
                    foreach ($options as $key => $values) {
                        foreach ($values as $data) {

                            if( !empty($_options[$c]['id']) ){
                                $data['id'] = $_options[$c]['id'];
                                unset($_options[$c]);
                            }

                            $data['cus_id'] = $id;
                            $this->model->set_option( $data );
                            $c++;     
                        }
                    }

                    if( !empty($_options) ){
                        foreach ($_options as $key => $value) {
                            $this->model->del_option( $value['id'] );
                        }
                    }
                }

                if( !empty($_FILES['file1']) ){

                    if( !empty($item['image_id']) ){
                        $this->model->query('media')->del($item['image_id']);
                        $this->model->update( $id, array('emp_image_id'=>0 ) );
                    }

                    $album = array('album_id'=>3);
                    
                    if( empty($structure) ){
                        $structure = WWW_UPLOADS . $album['album_id'];
                        if( !is_dir( $structure ) ){
                            mkdir($structure, 0777, true);
                        }
                    }

                    /**/
                    /* set Media */
                    /**/
                    $media = array(
                        'media_album_id' => $album['album_id'],
                        'media_type' => isset($_REQUEST['media_type']) ? $_REQUEST['media_type']: strtolower(substr(strrchr($_FILES['file1']['name'],"."),1))
                        );

                    $options = array(

                        'dir' => $structure.DS,
                        'url' => UPLOADS.$album['album_id'].'/',
                        );

                    if( isset($_REQUEST['minimize']) ){
                        $options['minimize'] = explode(',', $_REQUEST['minimize']);
                    }
                    
                    $options['has_quad'] = true;

                    $this->model->query('media')->upload_picture( $_FILES['file1'], $media , $options );
                    $item['image_id'] = $media['media_id'];
                    $this->model->update( $id, array('cus_image_id'=>$item['image_id'] ) );
                    
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
        }

        echo json_encode($arr);
    }

    public function update_cus_level(){

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if( empty($this->me) || empty($id) || empty($_POST) || $this->format!='json' ) $this->error();

        try{
            $form = new Form();
            $form   ->post('cus_code')
                    ->post('cus_level_id');

            $form->submit();
            $postData = $form->fetch();

            if( empty($arr['error']) ){

                $this->model->update($id, $postData);
                $arr['message'] = 'บันทึกเรียบร้อย';
                $arr['url'] = 'refresh';
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }

        echo json_encode($arr);
    }

    public function del($id=null){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();
        
        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ($item['permit']['del']) {
                $this->model->delete($id);
                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
            } else {
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            if( isset($_REQUEST['callback']) ){
                $arr['callback'] = $_REQUEST['callback'];
            }
            
            $arr['url'] = isset($_REQUEST['next'])? $_REQUEST['next'] : URL.'customers/';
            
            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->render("customers/forms/del_dialog");
        }
    }

    public function bookmark($id=null){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        $bookmark = isset($_REQUEST['value']) ? $_REQUEST['value']: false;
        $bookmark = !empty($bookmark) ? 0: 1;

        $this->model->update( $id, array('cus_bookmark'=>$bookmark) );

        $arr['value'] = $bookmark;
        $arr['message'] = 'บันทึกเรียบร้อย';

        echo json_encode( $arr );
    }

    public function setdata($id='', $field=null)
    {
        if( empty($id) || empty($field) || empty($this->me) ) $this->error();

        $item = $this->model->get( $id );

        if( empty($item) ) $this->error();

        if( isset($_REQUEST['has_image_remove']) && !empty($item['image_id']) ){
            $this->model->query('media')->del( $item['image_id'] );
        }

        $data[$field] = isset($_REQUEST['value'])? $_REQUEST['value']:'';
        $this->model->update($id, $data);

        $arr['message'] = 'บันทึกเรียบร้อย';
        echo json_encode($arr);
    }

    /**/
    /* LEVEL */
    /**/
    public function add_level(){
        if( empty($this->me) || $this->format!='json' ) $this->error();

        $this->view->setPage('path','Themes/manage/forms/level');
        $this->view->render("add");
    }
    public function edit_level( $id=null ){
        if( empty($id) || empty($this->me)  || $this->format != 'json') $this->error();

        $item = $this->model->get_level( $id );

        $this->view->setData('item', $item);
        $this->view->setPage('path', 'Themes/manage/forms/level');
        $this->view->render("add");
    }
    public function save_level(){
        if( empty($_POST) ) $this->error();

        $id = isset($_POST['id']) ? $_POST['id']: null;
        if( !empty($id) ){
            $item = $this->model->get_level($id);
            if( empty($item) ) $this->error();
        }

        try {
            $form = new Form();
            $form   ->post('level_name')->val('is_empty')
                    ->post('level_discount')->val('is_empty');

            $form->submit();
            $postData = $form->fetch();

            if( empty($arr['error']) ){

                if( !empty($item) ){
                    $this->model->update_level( $id, $postData );
                }
                else{
                    $this->model->insert_level( $postData );
                    $id = $postData['level_id'];
                }

                $arr['message'] = 'บันทึกเรียบร้อย';
                $arr['url'] = 'refresh';
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }

        echo json_encode($arr);
    }
    public function del_level( $id=null ){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me )|| empty($id) || $this->format!='json' ) $this->error();
        
        $item = $this->model->get_level($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ($item['permit']['del']) {
                $this->model->delete_level($id);
                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
            } else {
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            if( isset($_REQUEST['callback']) ){
                $arr['callback'] = $_REQUEST['callback'];
            }
            
            $arr['url'] = isset($_REQUEST['next'])? $_REQUEST['next'] : URL.'settings/customers';
            
            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->setPage('path', 'Themes/manage/forms/level');
            $this->view->render("del");
        }
    }
    public function sort_level() {
        if( $this->format!='json' || empty($this->me) ) $this->error();
        
        if( !empty($_POST['ids']) ){

            $sequence = 0;
            foreach ($_POST['ids'] as $id) {
                $sequence++;
                $this->model->update_level( $id, array('level_sequence'=>$sequence) );
            }
        }
    }


    public function invite() {
        
        if( empty($this->me )|| $this->format!='json' ) $this->error();
        $data = $this->model->lists( array('view_stype'=>'bucketed', 'limit'=>20, 'status'=>'run', 
            'sort'=>'updated') );

        $results = array();
        $results[] = array(
            'object_type'=>'customers', 
            'object_name'=>'Customers',
            'data' => $data
        );

        echo json_encode($results); die;
    }

    public function set_extend( $id=null ){

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;

        $item = $this->model->get( $id );
        if( empty($item) ) $this->error();

        if( !empty($_POST) ){

            try {

                $arrDate1 = explode("-",$_POST['start_date']);
                $arrDate2 = explode("-",$_POST['end_date']);
                $timStmp1 = mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]);
                $timStmp2 = mktime(0,0,0,$arrDate2[1],$arrDate2[2],$arrDate2[0]);

                if( $timStmp1 >= $timStmp2 ){
                    $arr['error']['ex_time'] = 'กรุณาเลือกวันที่ให้ถูกต้อง';
                }

                if( empty($arr['error']) ){

                    $ex = array(
                        'ex_cus_id'=>$id,
                        'ex_start_date'=>$_POST['start_date'],
                        'ex_end_date'=>$_POST['end_date'],
                        'ex_emp_id'=>$this->me['id'],
                        'ex_status'=>'run',
                    );
                    $this->model->setExpired( $ex );

                    $this->model->update( $id, array('cus_status'=>'run') );

                    $arr['message'] = 'ต่ออายุเรียบร้อย';
                    $arr['url'] = URL.'customers/'.$id;
                }

            } catch (Exception $e) {
                $arr['error'] = $this->_getError($e->getMessage());
            }

            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->setPage('path', 'Themes/manage/forms/customers');
            $this->view->render('set_extend');
        }
    }
}