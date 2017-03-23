<?php

class Dealer extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index(){
		$this->error();
	}

	public function add() {
		if( empty($this->me) || $this->format!='json' ) $this->error();

        $this->view->setPage('path','Themes/manage/forms/dealer');
        $this->view->render("add");
	}

	public function edit($id=null) {

		if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

		$item = $this->model->get($id);
		if( empty($item) ) $this->error();

		$this->view->setData('item', $item);
		
        $this->view->setPage('path','Themes/manage/forms/dealer');
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
            $form   ->post('name')->val('is_empty')
                    ->post('license')
            		->post('address')
            		->post('tel')
                    ->post('mobile_phone')
            		->post('fax')
            		->post('email');

            $form->submit();
            $postData = $form->fetch();

            if( empty($arr['error']) ){

            	if( !empty($item) ){
            		$this->model->update( $id, $postData );
            	}
            	else{
                    $postData['emp_id'] = $this->me['id'];
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


        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ( !empty($item['permit']['del']) ) {
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
            
            $this->view->setPage('path','Themes/manage/forms/dealer');
            $this->view->render("del");
        }
	}
}