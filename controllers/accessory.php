<?php

class Accessory extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index(){
		$this->error();
	}

	public function add() {
		if( empty($this->me) || $this->format!='json' ) $this->error();

		$this->view->setData('model', $this->model->query('models')->lists());
		$this->view->setData('store', $this->model->query('stores')->lists());

        $this->view->setPage('path', 'Themes/manage/forms/accessories');
        $this->view->render("add");
	}

	public function edit($id=null) {
		if( empty($this->me) || $this->format!='json' ) $this->error();

		$item = $this->model->get($id);
		if( empty($item) ) $this->error();

		$this->view->setData('model', $this->model->query('models')->lists());
        $this->view->setData('store', $this->model->query('stores')->lists());

		$this->view->item = $item;
		$this->view->setPage('path', 'Themes/manage/forms/accessories');
        $this->view->render("add");
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
            $form   ->post('acc_name')->val('is_empty')
            		->post('acc_model_id')->val('is_empty')
            		->post('acc_price')->val('is_empty')
            		->post('acc_cost')->val('is_empty')
            		->post('acc_store_id');

            $form->submit();
            $postData = $form->fetch();

            $postData['acc_user_id'] = $this->me['id'];

            $has_name = true;
            if( !empty($id) ){
            	if( ($postData['acc_name'] == $item['name']) && ($postData['acc_model_id'] == $item['model_id'] )  ){
            		$has_name = false;
            	}
            }

            if( $this->model->is_name($postData['acc_model_id'],$postData['acc_name']) && $has_name == true ){
            	$arr['error']['acc_name'] = "มีชื่อนี้อยู่ในระบบแล้ว";
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

	public function del($id=null)
	{
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
            $this->view->setPage('path', 'Themes/manage/forms/accessories');
            $this->view->render("del");
        }
	}
}