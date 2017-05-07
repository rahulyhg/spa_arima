<?php

class Index extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        header('Location: '. URL.'dashboard' );
    }

    public function search($_url) {

        $this->pathName = $_url[0];
        $this->_modify();
        
        $this->error();
    }
}
