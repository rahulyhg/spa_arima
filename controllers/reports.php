<?php

class reports extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index(){
        header("location:".URL.'/reports/lists/masseuse');
    }

    public function lists($section='masseuse', $id=null){

        if( $section != "masseuse" && !empty($id) ) $this->error();

        $this->view->setPage('title', 'รายงาน');
        $this->view->setData( 'section', $section );
        $this->view->render("reports/display");
    }
}