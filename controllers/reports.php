<?php

class reports extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index(){

    	$this->view->render('reports/display');
    }

    public function get() {

    	
    	$type = $_GET['type'];
    	echo json_encode( $this->model->{$type}($_GET['start'], $_GET['end']) );
    }

}