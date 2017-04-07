<?php

class Rooms extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index(){
		$this->error();
	}

	public function add() {
		if( empty($this->me) || $this->format!='json' ) $this->error();


		$this->view->setData('level', $this->model->level() );
		$this->view->setData('dealer', $this->model->query('dealer')->lists());

        $this->view->setPage('path','Themes/manage/forms/rooms');
        $this->view->render("add");
	}

	public function save(){

		if( empty($this->me) || empty($_POST) ) $this->error();

		$id = isset($_POST['id']) ? $_POST['id'] : null;
		if( !empty($id) ){
			$item = $this->model->get($id);
		}

		try{
			$form = new Form();
			$form 	->post('room_floor')->val('is_empty')
					->post('room_level')
					->post('room_number')->val('is_empty')
					->post('room_price_type')
					->post('room_bed');

			$form->submit();
			$postData = $form->fetch();

			if( !empty($_POST['room_person']) ){
				$postData['room_person'] = $_POST['room_person'];
			}
			if( !empty($_POST['room_timer']) ){
				$postData['room_timer'] = $_POST['room_timer'];
			}
			if( !empty($_POST['room_price']) ){
				$postData['room_price'] = $_POST['room_price'];
			}

			$has_room = true;
			if( !empty($item) ){
				if( $postData['room_number'] == $item['number'] && $postData['room_floor'] == $item['floor'] ){
					$has_room = false;
				}
			}

			if( $this->model->is_room( $postData['room_floor'] , $postData['room_number'] ) && $has_room == true ){
				$arr['error']['room_floor'] = 'มีหมายเลขห้อง '.$postData['room_number'].' อยู่ในชั้นดังกล่าวแล้ว';
			}

			if( $postData['room_floor'] < 1 ){
				$arr['error']['room_floor'] = 'กรุณาเลือกข้อมูลเป็นตัวเลข';
			}

			$total_bed = 0;

			if( !empty($postData['room_bed']) ){
				if( !is_numeric($postData['room_bed']) OR $postData['room_bed'] < 1 ){
					$arr['error']['room_bed'] = 'กรุณากรอกข้อมูลเป็นตัวเลข';
				}
				$total_bed = $postData['room_bed'];
			}

			if( empty($arr['error']) ){

				if( !empty($item) ){
					$this->model->update( $id , $postData );
				}
				else{
					$postData['room_status'] = 'on';
					$this->model->insert( $postData );
					$id = $postData['id'];
				}

				for( $i=0; $i<$total_bed; $i++ ){

					$code = $this->model->AutoBedCode( $id );

					$bed = array(
						'bed_code'=>$code,
						'bed_status'=>'on',
						'bed_room_id'=>$id
					);

					$this->model->setBed( $bed );
				}

				$arr['message'] = 'บันทึกข้อมูลเรียบร้อย';
				$arr['url'] = 'refresh';
			}

		} catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }

        echo json_encode($arr);
	}
}