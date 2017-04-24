<?php

class Package extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index(){
		
		$data = $this->model->lists();
		// print_r($data);die;
		$this->view->setData('data', $data);
		$this->view->render('package/lists/display');
	}

	public function add() {

		if( empty($this->me) || $this->format!='json' ) $this->error();

		$this->view->setData('skill', $this->model->query('employees')->skill() );
		$this->view->render("package/forms/add");
	}

	public function edit($id=null) {
		if( empty($this->me) || $this->format!='json' ) $this->error();

		$item = $this->model->get($id);
		if( empty($item) ) $this->error();

		$this->view->setData('item', $item);
		$this->view->setData('skill', $this->model->query('employees')->skill() );

        $this->view->render("package/forms/add");
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
            $form   ->post('pack_code')
                    ->post('pack_name')->val('is_empty')
                    ->post('pack_timer')
                    ->post('pack_is_time')
                    ->post('pack_price');

            $form->submit();
            $postData = $form->fetch();

            $has_name = true;
            if( !empty($id) ){
            	if( $postData['pack_name'] == $item['name']){
            		$has_name = false;
            	}
            }

            if( $this->model->is_name($postData['pack_name']) && $has_name == true ){
            	$arr['error']['pack_name'] = "มีชื่อนี้อยู่ในระบบแล้ว";
            }

            if( empty($arr['error']) ){

            	// 0 = ตามเวลา(Ontime) , 1 ครั้ง(Pertime)
            	$postData['pack_is_time'] = $postData['pack_is_time'] == 'pertime' ? 1 : 0;
            	$postData['pack_emp_id'] = $this->me['id'];

            	if( !empty($item) ){

            		if( !empty($item['skill']) ){
            			$this->model->unsetSkill( $id );
            		}
            		
            		$this->model->update( $id, $postData );
            	}
            	else{
                	$this->model->insert( $postData );
                    $id = $postData['id'];
            	}

            	if( !empty($_POST['skill']) ){

            		foreach ($_POST['skill'] as $key => $value) {

            			$skill = array(
            				'skill_id'=>$value,
            				'pack_id'=>$id,
            			);

            			$this->model->setSkill( $skill );
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
			$this->view->render("package/forms/del");
		}
	}

}