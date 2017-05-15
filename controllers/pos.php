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

            $item = $this->model->query('masseuse')->getCode( $_POST['code'] );
            if( !empty($item) ){
                

                $job = $this->model->query('masseuse')->getJob( $item['id'], array('status'=>'on') );
                
                if( !empty($job) ){
                    $arr['message'] = 'ไม่สามารถ CheckIn ซ้ำได้';
                } else{
                    $this->model->query('masseuse')->setJob( $item['id'] );
                }
            }
            else{
                $arr['message'] = 'ไม่พบข้อมูล';
            }
        }

        // $this->view->setData('lists', $this->model->query('masseuse')->lists() );

        $this->view->setData('lists', $this->model->query('masseuse')->listJob() );
        $this->view->setPage('on', 'queue');
        $this->view->render("queue/display");
    }

    
}