<?php

class Promotions extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        
        $data = $this->model->lists();
        // print_r($data);die;
        $this->view->setData('data', $data);
        $this->view->render('promotions/lists/display');
    }

    public function add() {

        if( empty($this->me) || $this->format!='json' ) $this->error();

        $this->view->setData('status', $this->model->status());
        $this->view->setData('type', $this->model->type());

        $this->view->setPage('path','Themes/manage/forms/promotions');
        $this->view->render("add");
    }

    public function edit($id=null) {
        if( empty($this->me) || $this->format!='json' ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        $this->view->setData('status', $this->model->status());
        $this->view->setData('type', $this->model->type());

        $this->view->setData('item', $item);

        $this->view->setPage('path','Themes/manage/forms/promotions');
        $this->view->render("add");
    }

    public function save() {
        if( empty($_POST) ) $this->error();

        $id = isset($_POST['id']) ? $_POST['id']: null;
        if( !empty($id) ){
            $item = $this->model->get($id);
            if( empty($item) ) $this->error();
        }

        try {
            $form = new Form();
            $form   ->post('pro_type')
                    ->post('pro_name')->val('is_empty')
                    ->post('pro_discount')
                    ->post('pro_qty');

            $form->submit();
            $postData = $form->fetch();

            $has_name = true;
            if( !empty($id) ){
                if( $postData['pro_name'] == $item['name']){
                    $has_name = false;
                }
            }

            if( $this->model->is_name($postData['pro_name']) && $has_name == true ){
                $arr['error']['pro_name'] = "มีชื่อนี้อยู่ในระบบแล้ว";
            }

            if( !empty($_POST['start_date']) ){
            	$postData['pro_start_date'] = $_POST['start_date'];
            }

            if( !empty($_POST['end_date']) ){
            	$postData['pro_end_date'] = $_POST['end_date'];
            }

            if( empty($arr['error']) ){

                $postData['pro_emp_id'] = $this->me['id'];

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

    public function del($id=null) {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) ) $this->error();

        // $this->_getCompany();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ($item['permit']['del']) {
                $this->model->delete($id);
                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
            } else {
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            $arr['url'] = 'refresh';
            echo json_encode($arr);
        }
        else{
            $this->view->item = $item;
            $this->view->render("promotions/forms/del");
        }
    }


    public function invite() {
        if( empty($this->me) || $this->format!='json' ) $this->error();

        $objects['package'] = array('name'=> $this->lang->translate('Package') );
        $options = array(
            'limit'=> isset($_REQUEST['limit']) ? $_REQUEST['limit']: 20
        );

        $results = $this->model->query('search')->results( $objects, $options );
        echo json_encode($results);
    }
}