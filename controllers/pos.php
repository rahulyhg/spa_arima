<?php

class Pos extends Controller{
	
	function __construct(){
		parent::__construct();
	}

	public function index() {
        header('Location: '. URL.'pos/orders' );
        
	}

    public function orders(){
        
        $this->view->setData('package', $this->model->query('package')->lists());
        $this->view->setData('promotions', $this->model->query('promotions')->lists());
        
        $this->view->setPage('on', 'orders');
        $this->view->render("orders/display");
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
        $this->view->setData('lists', $this->model->query('masseuse')->listJob( array('date'=>$date, 'unlimit'=>1 ) ) );
        $this->view->setPage('on', 'queue');
        $this->view->render("queue/display");
    }   
}