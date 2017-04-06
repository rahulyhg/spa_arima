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
		

        $this->view->setPage('path','Themes/manage/forms/rooms');
        $this->view->render("add");
	}
}