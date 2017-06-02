<?php

class Pos2 extends Controller{
	
	function __construct(){
		parent::__construct();
	}

	public function index() {

		$this->view->setPage('theme', 'POs2');
        $this->view->setPage('theme_options', array(
            'has_topbar' => true,
            // 'has_menu' => true,
        ));

        $this->view->setData('package', $this->model->query('package')->lists());
        $this->view->setData('promotions', $this->model->query('promotions')->lists());

		$this->view->setPage('on', 'orders');
		$this->view->render("orders/display"); 
	}

}