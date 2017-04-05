<?php

class Search extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
    	
    	$q = isset( $_REQUEST['q'] )? $_REQUEST['q']: "";

        $objects['cus'] = array('type'=>'cus','name'=>'ลูกค้า');
        $objects['emp'] = array('type'=>'car','name'=>'พนักงาน');

        $results = $this->model->results($objects, $q);

        if( $this->format=='json' ){
            echo json_encode( $results );
        }
        else{
            $this->view->render('index/search');
        }
    }
}