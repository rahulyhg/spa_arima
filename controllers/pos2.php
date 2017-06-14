<?php

class Pos2 extends Controller{
	
	function __construct(){
		parent::__construct();
	}

	public function index() {

		$options = array(
            'has_topbar' => true,
            'has_menu' => true,
        );

		$this->view->setPage('theme', 'POs2');
        $this->view->setPage('theme_options', $options);

        if( !empty($options['has_menu']) ){
            Session::init();                          
            Session::set('isPushedLeft', 0);
            $this->view->elem('body')->addClass('has_menu');
        }

        $this->view->setData('package', $this->model->query('package')->lists());
        $this->view->setData('promotions', $this->model->query('promotions')->lists());



        $this->view->js( VIEW . 'Themes/POs2/assets/js/orderlists.js', true);

		$this->view->setPage('on', 'orders');
		$this->view->render("orders/display"); 
	}

	public function orders() {
		

		$this->view->setPage('path','Themes/POs2/pages/orders/lists');
		$this->view->render("display"); 
	}


	public function queue() {
		
		$this->view->setPage('path','Themes/POs2/pages/queue');
		$this->view->render("display"); 

	}


	public function members() {
		
		$this->view->setPage('path','Themes/POs2/pages/members');
		$this->view->render("display"); 

	}

}