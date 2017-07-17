<?php

class reports extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index(){
        // $this->error();
    	$this->view->render('reports/display');
    }

    public function get() {
    	$type = $_GET['type'];
    	echo json_encode( $this->model->{$type}($_GET['start'], $_GET['end']) );
    }


    public function SummaryOfDaily() {

        $date = isset($_REQUEST['date']) ? $_REQUEST['date']: date('Y-m-d');

        $start = date('Y-m-d 00:00:00', strtotime($date));
        $end = date('Y-m-d 23:59:59', strtotime($date));

        echo json_encode($this->model->summaryEachPackage( $start, $end ));
    }
}