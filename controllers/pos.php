<?php

class Pos extends Controller{
	
	function __construct(){
		parent::__construct();
	}

	public function index() {
        header('Location: '. URL.'pos/orders' );
	}

    public function orders(){
        
        $options = Cookie::get('POs');
        if( !empty($options) ){

            $options = json_decode($options, 1);
            

            if( strtotime($options['date'])!=strtotime(date('Y-m-d')) || $this->fn->q('util')->get_client_ip()!=$options['ip'] ){
                $has_new = true;
                Cookie::clear('POs');
            }
            else{
                $options['number']++;
                $options['queue'] = array();
                Cookie::set('POs', json_encode($options));
            }
        }
        else{
            $has_new = true;
        }

        if( isset($has_new) ){
            $options['ip'] = $this->fn->q('util')->get_client_ip();
            $options['number'] = 1;
            $options['date'] = date('Y-m-d');
            $options['queue'] = array();
            Cookie::set('POs', json_encode($options));
        }

        
        $this->view->js('jquery/jquery-ui.min');
        $this->view->js('jquery/jquery.sortable');

        $this->view->js( VIEW. 'Themes/POs/assets/js/POsOrder.js', true);
        $this->view->js( VIEW. 'Themes/POs/assets/js/TableOrder.js', true);
        $this->view->js( VIEW. 'Themes/POs/assets/js/POs.js', true);
        $this->view->js( VIEW. 'Themes/POs/assets/js/addorder.js', true);
        $this->view->js( VIEW. 'Themes/POs/assets/js/summaryOfDaily.js', true);
        $this->view->js( VIEW. 'Themes/POs/assets/js/setqueue.js', true);
        $this->view->js( VIEW. 'Themes/POs/assets/js/setmenu.js', true);

        $this->view->setData('package', $this->model->query('package')->lists());
        // $this->view->setData('promotions', $this->model->query('promotions')->lists());


        $this->view->setPage('on', 'orders');
        $this->view->render("orders/display"); 
   
    }
    
    public function settings($tap='basic') {

        $this->view->setPage('on', 'settings');
        $this->view->setData('tap', $tap);
        $this->view->render("settings/display");
    }

    public function members( $id=null ){
        $this->error();
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


    public function masseuse(){

        if( $this->format!='json' || empty($this->me) ) $this->error();
        
        $date = isset($_REQUEST['date']) ? $_REQUEST['date']: date('Y-m-d'); 

        $results = $this->model->query('masseuse')->listJob( array('date'=>$date, 'unlimit'=>1, 'status'=>'on' ) );

        // print_r($results); die;
        $this->view->setData('results', $results );
        $this->view->render("masseuse/display");

        // $this->view->render("settings/display");
    } 

    public function summary(){

        if( $this->format!='json' || empty($this->me) ) $this->error();

        $date = isset($_REQUEST['date']) ? $_REQUEST['date']: date('Y-m-d');
        $this->view->setData('date', $date);
        $this->view->render("summary/display");
    }
}