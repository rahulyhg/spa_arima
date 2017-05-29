<?php

class Pos extends Controller{
	
	function __construct(){
		parent::__construct();
	}

	public function index() {
        header('Location: '. URL.'pos/orders' );
	}

    public function orders2() {

        // print_r($this->model->query('orders')->lists(array('has_item'=>1))); die;

        if( $this->format=='json' ) {
            $this->view->setData('results', $this->model->query('orders')->lists(array('has_item'=>1)) );
            $this->view->render("orders2/json");
        }
        else{
            $this->view->setPage('on', 'orders');
            $this->view->render("orders2/display");
        }
    }

    public function orders(){
        
        Session::init();
        if( isset($_REQUEST['style']) ){
            Session::set('pos_style', $_REQUEST['style']);
        }

        $style = Session::get('pos_style');

        if( $style==2 ){
            $this->orders2();
        }
        else{
            $this->view->setData('package', $this->model->query('package')->lists());
            $this->view->setData('promotions', $this->model->query('promotions')->lists());
            
            $this->view->setPage('on', 'orders');
            $this->view->render("orders/display"); 
        }

    }

    public function queue() {

        $this->view->js('jquery/jquery-ui.min');
        $this->view->js('jquery/jquery.sortable');

        $date = isset($_REQUEST['date']) ? $_REQUEST['date']: date('Y-m-d'); 

        if( !empty($_POST) ){

            $item = $this->model->query('masseuse')->getCode( $_POST['code'] );

            if( !empty($item) ){

                $job = $this->model->query('masseuse')->getJob( $item['id'], array('status'=>'on', 'date'=>$date) );
                
                if( !empty($job) ){
                    $arr['message'] = 'ไม่สามารถ CheckIn ซ้ำได้';
                } else{
                    $this->model->query('masseuse')->setJob( $item['id'], array( 'date'=>$date ) );
                }
            }
            else{
                $arr['message'] = 'ไม่พบข้อมูล';
            }
        }

        $this->view->setData('date', $date );
        $this->view->setData('lists', $this->model->query('masseuse')->listJob( array('date'=>$date, 'unlimit'=>1, 'status'=>'on' ) ) );
        $this->view->setPage('on', 'queue');
        $this->view->render("queue/display");
    }   
}