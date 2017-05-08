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
    		}
    		else{

    			$data = $this->model->query('package')->lists();
    		}
    	}
    	else{
    		$data = $this->model->query('promotions')->lists();
    	}


    	echo json_encode( $data );
    }
}