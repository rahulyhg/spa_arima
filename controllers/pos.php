<?php

class Pos extends Controller{
	
	function __construct(){
		parent::__construct();
	}

    public function init($type='') {
        
    }

	public function index() {

        $theme_options = array(
        	'has_topbar' => true,
        	'has_menu' => true,
        	'has_footer' => true,
        );

        if( count($this->me['access']) == 1 ){
            $theme_options['has_menu'] = false;
        }

        
        $this->view->setPage('theme', 'pos');
        $this->view->setPage('theme_options', $theme_options);

        if( $theme_options['has_menu'] ){
	        Session::init();                          
	        Session::set('isPushedLeft', 0);
	        $this->view->elem('body')->addClass('has_menu');
        }

        $this->view->setPage('image_url', !empty( $this->system['image_url'] ) ? $this->system['image_url']: IMAGES.'logo/logo1.gif' );
        $this->view->setPage('name', !empty( $this->system['name'] ) ? $this->system['name']: 'POS' );

        $this->view->elem('body')->addClass('off');

        $this->view->elem('body')->attr('data-options', $this->fn->stringify( array(
        	'lang' => $this->lang->getCode()
        )));

        $this->view->elem('body')->attr('data-plugins', 'pos');
        $this->view->js('jquery/jquery-ui.min');
        $this->view->js('jquery/jquery.sortable');


        //set Data
        // print_r($this->model->query('package')->lists()); die;
        $this->view->setData('package', $this->model->query('package')->lists());
        $this->view->setData('prefixName', $this->model->query('system')->_prefixName());
        $this->view->setData('city', $this->model->query('system')->city());


        // cus Profile
        $this->view->setData('level', $this->model->query('customers')->level() );

        $this->view->setPage('on', 'orders');
		$this->view->render("index");
        
	}
}