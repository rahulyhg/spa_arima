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
		$this->view->setData('status', $this->model->status() );
		$this->view->setData('dealer', $this->model->query('dealer')->lists());

        $this->view->setPage('path','Themes/manage/forms/rooms');
        $this->view->render("add");
	}

	public function edit($id=null){

		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
		if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

		$item = $this->model->query('rooms')->get($id);
		if( empty($item) ) $this->error();
 
		$this->view->setData('level', $this->model->level() );
		$this->view->setData('status', $this->model->status() );
		$this->view->setData('dealer', $this->model->query('dealer')->lists());

		$this->view->setData('item', $item);

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
			$form 	->post('room_dealer_id')
					->post('room_floor')->val('is_empty')
					->post('room_level')
					->post('room_number')->val('is_empty')
					->post('room_price_type')
					->post('room_status');

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
			if( isset($_POST['room_bed']) ){
				$postData['room_bed'] = $_POST['room_bed'];
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

			if( isset($postData['room_bed']) ){
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
					$this->model->insert( $postData );
					$id = $postData['id'];
				}

				if( empty($item) ){
					for( $i=0; $i<$total_bed; $i++ ){

						$code = $this->model->AutoBedCode( $id );

						$bed = array(
							'bed_code'=>$code,
							'bed_status'=>'on',
							'bed_room_id'=>$id
						);

						$this->model->setBed( $bed );
					}
				}

				$arr['message'] = 'บันทึกข้อมูลเรียบร้อย';
				$arr['url'] = 'refresh';
			}

		} catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }

        echo json_encode($arr);
	}

	public function del($id=null){

		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
		if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

		$item = $this->model->get($id);
		if( empty($item) ) $this->error();

		if( !empty($_POST) ){

			$this->model->delete($id);
			$arr['message'] = 'ลบข้อมูลเรียบร้อย';
			$arr['url'] = 'refresh';
			echo json_encode($arr);
		}
		else{

			$this->view->setData('item', $item);
			$this->view->setPage('path', 'Themes/manage/forms/rooms');
			$this->view->render('del');
		}
	}

	/* floor */
	public function floors() {
		echo json_encode($this->model->floors());
	}
	public function get_floor($value='') {
		# code...
	}
	public function set_floor(){

		$data = array(
			'floor_dealer_id' => $_POST['dealer_id'],
			'floor_name' => $_POST['name'],
		);

		$this->model->insertFloor( $data );
		echo json_encode($data);
	}

	/* room */
	public function lists(){

		echo json_encode($this->model->lists());
	}
	public function set_room(){
		
		$data = array(
			'room_floor' => $_POST['floor_id'],
			'room_name' => $_POST['name'],
		);

		$this->model->insertRoom( $data );
		echo json_encode($data);
	}

	/* bed */
	public function beds() {
		echo json_encode($this->model->beds());
	}
	public function set_bed(){
		
		$data = array(
			'bed_room_id' => $_POST['room_id'],
			'bed_name' => $_POST['name'],
		);

		$this->model->insertBed( $data );
		echo json_encode($data);
	}

}