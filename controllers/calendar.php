<?php

class Calendar extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index(){
		$this->view->render("events/calendar");
	}

	public function events() {
		

		if( empty($this->me) || $this->format!='json' ) $this->error();

		$options = array(
			'view_stype' => 'bucketed',
			'unlimit' => true,
			'dir' => 'ASC'
		);


		$data = $this->model->query('events')->lists( 
			$options, 
			empty($this->permit['events']['view']) 
				? $this->me['id'] 
				: null
		);

		// print_r($data); die;

		echo json_encode( $data['lists'] );
	}
}