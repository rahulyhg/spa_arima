<?php

class Orders extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->error();
    }

    public function lists() {
    	echo json_encode( $this->model->lists() );
    } 

    public function lastNumber() {
    	echo json_encode( $this->model->lastNumber() );
    }

    public function menu() {

    	$type = $_GET['type'];

    	if( $type=='package' ){
    		if( !empty($_GET['id']) ){
    			$data = $this->model->query('package')->get( $_GET['id'] );

                // $masseuse = $this->model->query('masseuse')->firstMasseuse();
    		}
    		else{
    			$data = $this->model->query('package')->lists();
    		}
    	}
    	else{

            if( !empty($_GET['id']) ){
                $menuset = $this->model->query('promotions')->get( $_GET['id'] );

                $data = array();
                if( !empty($menuset['invite']['package']) ){
                    foreach ($menuset['invite']['package'] as $key => $value) {

                        $package = $this->model->query('package')->get( $value['id'] );

                        $data[] = $package;
                    }
                }

                // $data['masseuse'] = $this->model->query('masseuse')->firstMasseuse();
            }
            else{
                $data = $this->model->query('promotions')->lists();
            }
    	}
        
    	echo json_encode( $data );
    }

    public function save() {
        // order_number

        // save order
        $order = array(
            'order_date' => date('Y-m-d', strtotime($_POST['date'])),
            'order_number' => $_POST['number'],
            'order_status' => isset( $_POST['status'] ) ? $_POST['status']: 'order',
            'order_total' => $_POST['summary']['total'],
            'order_drink' => $_POST['summary']['drink'],
            'order_discount' => $_POST['summary']['discount'],
            'order_balance' => $_POST['summary']['balance'],
        );

        if( !empty($_POST['id']) ){
            $item = $this->model->get( $_POST['id'] );
        }

        $detail = array();
        if( !empty($_POST['items']) ){
            foreach ($_POST['items'] as $value) {

                $dd = array(
                    'item_pack_id' => $value['pack_id'],
                    'item_price' => $value['price'],
                    'item_discount' => $value['discount'],
                    'item_status' => $value['status'],
                    'item_balance' => $value['price']-$value['discount']
                );


                if( isset($value['masseuse_id']) ){
                    $dd['item_masseuse_id'] = $value['masseuse_id'];
                }

                if( isset($value['room_id']) ){
                    $dd['item_room_id'] = $value['room_id'];
                }
                if( isset($value['room_price']) ){
                    $dd['item_room_price'] = $value['room_price'];
                }
                if( isset($value['bed_id']) ){
                    $dd['item_bed_id'] = $value['bed_id'];
                }

                $detail[] = $dd;
            }
        }

        /*if( !empty($item) ){
            $this->model->updateOrder( $id, $order );
        }
        else{
            $this->model->insertOrder( $order );
        }

        // update Item 
        if( !empty($detail) ){
            foreach ($detail as $value) {
                $value['item_order_id'] = $order['id'];
                $this->model->insertDetail( $value );
            }
        }*/

        // 'order_created' => $_POST['created'],

        echo json_encode( $detail );
    }

    public function set_bill() {

        $type = $_GET['type'];
        $date = isset($_GET['date']) ? $_GET['date']: date('Y-m-d');

        if( $type=='masseuse' ){

            // $data = $this->model->query('masseuse')->listJob( array('limit'=>1) );

            $this->view->setData('position', $this->model->query('employees')->position(5) );
        }

        if( $type=='member' ){
            $this->view->setData('level', $this->model->query('customers')->level() );
        }

        if( $type=='room' ){
            $this->view->setData('floors', $this->model->query('rooms')->floors() );
        }

        if( $type=='remove_item' ){

            $this->view->setData('package', $this->model->query('package')->get( $_GET['package'] ) );
        }


        $this->view->setData('date', $date);
        $this->view->setPage('path','Forms/orders');
        $this->view->render("set_bill_{$type}");

    }

}