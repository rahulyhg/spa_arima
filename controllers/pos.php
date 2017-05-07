<?php

class Pos extends Controller{
	
	function __construct(){
		parent::__construct();
	}

    public function init($type='') {
        
    }

	public function index() {

        header('Location: '. URL.'pos/orders' );
        /*
        $this->view->elem('body')->attr('data-plugins', 'pos');
        $this->view->js('jquery/jquery-ui.min');
        $this->view->js('jquery/jquery.sortable');*/


        //set Data
        // print_r($this->model->query('package')->lists()); die;
        /*$this->view->setData('package', $this->model->query('package')->lists());
        $this->view->setData('prefixName', $this->model->query('system')->_prefixName());
        $this->view->setData('city', $this->model->query('system')->city());*/


        // cus Profile
        /*$this->view->setData('level', $this->model->query('customers')->level() );

        $this->view->setPage('on', 'orders');
		$this->view->render("index");*/
        

	}

    public function orders(){
        
        $this->view->setPage('on', 'orders');
        $this->view->render("orders/display");
    }
}