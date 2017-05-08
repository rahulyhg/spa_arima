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
        
        $this->view->setData('package', $this->model->query('package')->lists());
        
        $this->view->setPage('on', 'orders');
        $this->view->render("orders/display");
    }

    public function queue() {
        
        $this->view->js('jquery/jquery-ui.min');
        $this->view->js('jquery/jquery.sortable');

        if( !empty($_POST) ){

            $item = $this->model->query('employees')->getCode( $_POST['code'] );
            if( empty($item) ) $arr['message'] = 'ไม่พบข้อมูล';

            $start = date('Y-m-01 00:00:00');
            $end = date('Y-m-j 23:59:59');
            $job = $this->model->query('employees')->getJob( $item['id'], $start, $end );
            if( !empty($job) ) $arr['message'] = 'ไม่สามารถ CheckIn ซ้ำได้';

            if( empty($job) ){
                $this->model->query('employees')->setJob( $item['id'] );
            }
        }


        // $this->view->setData('lists', $this->model->query('masseuse')->lists() );
        $start = date('Y-m-01 00:00:00');
        $end = date('Y-m-j 23:59:59');

        $this->view->setData('lists', $this->model->query('employees')->listJob($start, $end));
        $this->view->setPage('on', 'queue');
        $this->view->render("queue/display");
    }
}