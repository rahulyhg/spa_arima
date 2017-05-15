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
        echo json_encode( $_POST );
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