<?php

class Package extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index( $id=null, $tab='booking' ) {

        $this->view->setPage('on', 'package' );

        $this->view->setData('lists', $this->model->query('package')->lists());
        $render = "package/lists/display";
        $this->view->render($render);
       
    }

    public function lists(){
        if( empty($this->me) ) $this->error();

        echo json_encode($this->model->query('employees')->lists( array(
            'dep'=>'Sales'
            ) ) ) ;
    }

    public function get($id=null){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id']:$id;
        if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

        $item = $this->model->get($id, array('options' => 1));
        if( empty($item) ) $this->error();

        $this->view->setData('prefixName', $this->model->query('system')->_prefixName());
        $this->view->setData('customer', $item );
        $this->view->render("customers/forms/profile");
    }

    public function add() {
    	if( empty($this->me) ) $this->error();

        $this->view->setData('prefixName', $this->model->query('system')->_prefixName());
        $this->view->setData('dealer', $this->model->query('dealer')->lists() );
        $this->view->setData('city', $this->model->query('system')->city());
        //$this->view->setData('department', $this->model->query('employees')->department() );
        $this->view->setData('position', $this->model->query('employees')->position(2));
        //$this->view->setData('position', $this->model->query('position')->lists());

        $this->view->render("sales/forms/add_or_edit_dialog");
    }

    public function edit($id=null) {
        if( empty($this->me) || empty($id) ) $this->error();

        $item = $this->model->query('employees')->get($id);
        if( empty($item) ) $this->error();

        $this->view->setData('item',$item);
        $this->view->setData('prefixName', $this->model->query('system')->_prefixName());
        //$this->view->setData('department', $this->model->query('employees')->department());
        $this->view->setData('dealer', $this->model->query('dealer')->lists() );
        $this->view->setData('city', $this->model->query('system')->city());
        $this->view->setData('position', $this->model->query('employees')->position(2));

        $this->view->render("sales/forms/add_or_edit_dialog");
    }

    public function save()
    {
        if( empty($_POST) ) $this->error();

        $id = isset($_POST['id']) ? $_POST['id']: null;
        if( !empty($id) ){
            $item = $this->model->get($id);
            if( empty($item) ) $this->error();
        }

        try {
            $form = new Form();
            $form   ->post('emp_username')->val('is_empty')
                    ->post('emp_pos_id')->val('is_empty')
                    ->post('emp_prefix_name')
                    ->post('emp_first_name')->val('is_empty')
                    ->post('emp_last_name')
                    ->post('emp_phone_number')
                    ->post('emp_notes');

            $form->submit();
            $postData = $form->fetch();

            $postData['emp_first_name'] = trim($postData['emp_first_name']);
            $postData['emp_last_name'] = trim($postData['emp_last_name']);
            $postData['emp_dep_id'] = 2;

            if( empty($item) ){
                $postData['emp_password'] = $_POST['emp_password'];
                if( empty($postData['emp_password']) ){
                    $arr['error']['emp_password'] = 'กรุณากรอกรหัสผ่าน';
                }else if( strlen($postData['emp_password']) < 6 ){
                    $arr['error']['emp_password'] = 'รหัสผ่านของคุณมีจำนวนต่ำกว่า 6 ตัวอักษร';
                }
            }

            $has_name = true;
            $has_user = true;
            if( !empty($id) ){
                if( $postData['emp_first_name'] == $item['first_name'] && $postData['emp_last_name'] == $item['last_name'] ){
                    $has_name = false;
                }

                if( $postData['emp_username'] == $item['username'] ){
                    $has_user = false;
                }
            }

            if( $this->model->query('employees')->is_user($postData['emp_username']) && $has_user == true ){
                $arr['error']['emp_username'] = "มี Username นี้อยู่ในระบบแล้ว";
            }

            if( $this->model->query('employees')->is_name( $postData['emp_first_name'] , $postData['emp_last_name'] ) && $has_name == true ){
                $arr['error']['emp_name'] = "มีชื่อ-นามสกุลนี้ในระบบแล้ว";
            }

            if( empty($arr['error']) ){

                if( !empty($item) ){
                    $this->model->update( $id, $postData );
                }
                else{
                    $this->model->insert( $postData );
                    $id = $postData['id'];
                }

                $arr['message'] = 'บันทึกเรียบร้อย';
                $arr['url'] = 'refresh';
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }

        echo json_encode($arr);
    }

    public function change_password($id='')
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id']: $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();

        $item = $this->model->query('employees')->get($id);
        if( empty($item) ) $this->error();

        if( !empty($_POST) ){
            try {
                $form = new Form();
                $form   ->post('password_new')->val('password')
                ->post('password_confirm')->val('password');

                $form->submit();
                $dataPost = $form->fetch();

                if( $dataPost['password_new']!=$dataPost['password_confirm'] ){
                    $arr['error']['password_confirm'] = 'รหัสผ่านไม่ตรงกัน';
                }

                if( empty($arr['error']) ){

                    // update
                    $this->model->query('employees')->update($item['id'], array(
                        'emp_password' => Hash::create('sha256', $dataPost['password_new'], HASH_PASSWORD_KEY )
                        ));

                    $arr['message'] = "แก้ไขข้อมูลเรียบร้อย";
                }

            } catch (Exception $e) {
                $arr['error'] = $this->_getError($e->getMessage());
            }

            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item );
            $this->view->render("sales/forms/change_password_dialog");
        }
    }

    public function del($id=null){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();
        
        $item = $this->model->query('employees')->get($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ($item['permit']['del']) {
                $this->model->query('employees')->delete($id);
                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
            } else {
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            if( isset($_REQUEST['callback']) ){
                $arr['callback'] = $_REQUEST['callback'];
            }
            
            $arr['url'] = isset($_REQUEST['next'])? $_REQUEST['next'] : URL.'sales/';
            
            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->render("sales/forms/del_dialog");
        }
    }
}