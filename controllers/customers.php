<?php

class Customers extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index( $id=null, $section='car' ) {
    	$this->view->setPage('on', 'customers' );

        if( !empty($id) ){

            $options = array();
            $options['options'] = 1;

            $item = $this->model->query('customers')->get( $id, $options );
            if( empty($item) ) $this->error();

            $this->view->setData('id', $id );
            $this->view->setData('item', $item );
            $this->view->setData('tab', $section); 
            $this->view->render("customers/profile/display");
        }
        else{

            if( $this->format=='json' )
            {
                $this->view->setData('results', $this->model->query('customers')->lists() );
                $render = "customers/lists/json";
            }
            else{

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

        $this->view->setData('prefixName', $this->model->prefixName());
        $this->view->setData('customer', $item );
        $this->view->render("customers/forms/profile");
    }
    public function _get($id) {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id']:$id;
        if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

        $item = $this->model->get($id, array('options' => 1));
        if( empty($item) ) $this->error();

        echo json_encode($item);
    }

    public function add() {
    	if( empty($this->me) ) $this->error();

        $this->view->setData('prefixName', $this->model->query('system')->_prefixNameCustomer());
        $this->view->setData('sex', $this->model->lists_sex());
        $this->view->setData('city', $this->model->query('system')->city() );
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

        $this->view->render("customers/forms/add_or_edit_dialog");
    }

    public function edit_basic($id=null){
        if( empty($this->me) || empty($id) ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        $this->view->setData('prefixName', $this->model->query('system')->_prefixNameCustomer());
        $this->view->setData('sex', $this->model->lists_sex());
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

    public function save() {
    	if( empty($this->me) ||empty($_POST) ) $this->error();

        $id = isset($_POST['id']) ? $_POST['id']: null;
        if( !empty($id) ){
            $item = $this->model->get($id, array('options'=> true));
            if( empty($item) ) $this->error();
        }

        $futureDate = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " -6 year")); // 2554 // 2011
        $birthday = date("{$_POST['birthday']['year']}-{$_POST['birthday']['month']}-{$_POST['birthday']['date']}");
        if( strtotime($birthday) > strtotime($futureDate) ){
            $arr['error']['birthday'] = 'วันเกิดไม่ถูกต้อง';
        }

        foreach ($_POST['address'] as $key => $value) {
            if( empty($value) && $key != 'village' && $key !='street' && $key != 'alley') {
                $arr['error']['cus_address'] = 'กรุณากรอกข้อมูลในช่องที่มีเครื่องหมาย * ให้ครบถ้วน';
            }
        }

        try {
            $form = new Form();
            $form   ->post('cus_prefix_name')
                    ->post('cus_first_name')->val('is_empty')
                    ->post('cus_last_name')->val('is_empty')
                    ->post('cus_nickname')
                    ->post('cus_card_id');

            $form->submit();
            $postData = $form->fetch();

            $postData['cus_birthday'] = $birthday;
            $postData['cus_first_name'] = trim($postData['cus_first_name']);
            $postData['cus_last_name'] = trim($postData['cus_last_name']);

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

            if( strlen($_POST['address']['zip']) != 5 ){
                $arr['error']['cus_address'] = 'กรุณากรอกรหัสไปรษณีย์ให้ครบ 5 หลัก';
            }

            if( empty($arr['error']) ){

                $postData['cus_city_id'] = $_POST['address']['city'];
                $postData['cus_zip'] = $_POST['address']['zip'];
                $postData['cus_address'] = json_encode($_POST['address']);

                if( !empty($item) ){
                    $this->model->update( $id, $postData );
                }
                else{
                    $postData['cus_emp_id'] = $this->me['id'];
                    $this->model->insert( $postData );
                    $id = $postData['cus_id'];
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

        $futureDate = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " -6 year")); // 2554 // 2011
        $birthday = date("{$_POST['birthday']['year']}-{$_POST['birthday']['month']}-{$_POST['birthday']['date']}");
        if( strtotime($birthday) > strtotime($futureDate) ){
            $arr['error']['birthday'] = 'วันเกิดไม่ถูกต้อง';
        }

        try {
            $form = new Form();
            $form   ->post('cus_prefix_name')
            ->post('cus_first_name')->val('is_empty')
            ->post('cus_last_name')->val('is_empty')
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

            foreach ($_POST['address'] as $key => $value) {
                if( empty($value) && $key != 'village' && $key !='street' && $key != 'alley') {
                    $arr['error']['cus_address'] = 'กรุณากรอกข้อมูลในช่องที่มีเครื่องหมาย * ให้ครบถ้วน';
                }
            }
            
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

            if( strlen($_POST['address']['zip']) != 5 ){
                $arr['error']['cus_address'] = 'กรุณากรอกรหัสไปรษณีย์ให้ครบ 5 หลัก';
            }

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

    public function notes(){
        if( empty($this->me) || $this->format!='json') $this->error();
        echo json_encode($this->model->notes());
    }

    public function save_note(){
        if( empty($this->me) || empty($_POST) || $this->format!='json') $this->error();


        if( empty($_POST['text']) || empty($_POST['cus_id']) ){

            $arr['message'] = array('text'=>'กรุณากรอกข้อมูลให้ครบ!', 'bg'=>'red', 'auto'=>1, 'load'=>1) ;
            $arr['error'] = 1;
        }
        else{
            $data = array(
                'note_text' => $_POST['text'],
                'note_date' => date('Y-m-d H:s:i'),
                'note_user_id' => $this->me['id'],
                'note_cus_id' => $_POST['cus_id']
                );
            $this->model->save_note( $data );

            $arr['data'] = $data;

            $arr['message'] = 'บันทึกเรียบร้อย';
            $arr['url'] = 'refresh';

        }

        echo json_encode( $arr );
    }

    public function del_note($id=null) {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();
        
        $item = $this->model->get_note($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ($item['permit']['del']) {
                $this->model->deleteNote($id);
                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
            } else {
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            if( isset($_REQUEST['callback']) ){
                $arr['callback'] = $_REQUEST['callback'];
            }
            $arr['url'] = 'refresh';
            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->render("customers/forms/del_note");
        }
    }

    public function edit_note(){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();

        $item = $this->model->get_note($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            try {
                $form = new Form();
                $form   ->post('note_text')->val('is_empty');

                $form->submit();
                $postData = $form->fetch();  
                
                if( empty($arr['error']) ){

                    $this->model->updateNote($id, $postData );
                    
                    $arr['message'] = 'บันทึกเรียบร้อย';

                    $arr['url'] = 'refresh';
                    $arr['text'] = $postData['note_text'];
                }

            } catch (Exception $e) {
                $arr['error'] = $this->_getError($e->getMessage());
            }

            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->render("customers/forms/get_note");
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
}