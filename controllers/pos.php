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

        // print_r($this->model->query('masseuse')->listJob( array('date'=>$date, 'unlimit'=>1, 'status'=>'on' ) )); die;

        $this->view->setData('date', $date );
        $this->view->setData('lists', $this->model->query('masseuse')->listJob( array('date'=>$date, 'unlimit'=>1, 'status'=>'on' ) ) );
        $this->view->setPage('on', 'queue');
        $this->view->render("queue/display");
    }

    public function members( $id=null ){

        $this->view->setPage('on', 'members');

        if( !empty($id) ){

            $this->error();

            // $options = array();

            // $options['options'] = 1;

            // $item = $this->model->query('customers')->get( $id, $options );
            // if( empty($item) ) $this->error();

            // // ประวัติการรับบริการ
            // $services = $this->model->query('orders')->get_customer_item( $id );
            // $this->view->setData('services', $services);

            // // ประวัติการจอง
            // $booking = $this->model->query('orders')->get_customer_item( $id, array('status'=>'booking') );
            // $this->view->setData('booking', $booking);

            // $this->view->setData('id', $id );
            // $this->view->setData('item', $item );
            // $this->view->setData('tab', $section); 
            // $this->view->render("members/profile/display");
        }
        else{

            if( $this->format=='json' )
            {
                $this->view->SetData('results', $this->model->query('customers')->lists() );
                $render = "members/lists/json";
            }
            else{
                $this->view->setData('status', $this->model->query('customers')->lists_status() );
                $render = "members/lists/display";
            }
        }

        $this->view->render( $render );
    }    
}