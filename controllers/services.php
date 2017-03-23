<?php

class Services extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index( $id='' ){
    	$this->view->setPage('on', 'services' );

        if( $this->format=='json' ) {
            $this->view->setData('results', $this->model->query('services')->lists() );
            // sleep(50);
            $render = "services/lists/json";
        } else{
            $this->view->setData('status', $this->model->query('services')->status() );
            $render = "services/lists/display";
        }

        $this->view->elem('body')->addClass('is-overlay-left');
        $this->view->render($render);
    }

    public function create(){
        if( empty($this->me) || $this->format!='json' ) $this->error();

        $this->view->setData('prefixName', $this->model->query('system')->_prefixNameCustomer());
        $this->view->setData('city', $this->model->query('system')->city() );
        $this->view->setData('models', $this->model->query('booking')->models() );
        
        $this->view->setData('tec', $this->model->query('employees')->tec() );

        $this->view->render("services/create/display");
    }

    public function save() {
    
        try {

            $arr['post'] = $_POST;

            $arr['post']['me'] = $this->me['id'];

            $this->model->check_form($arr);

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }
        echo json_encode($arr);
    }

    public function lists() {
        if( empty($this->me) || $this->format!='json' ) $this->error();
        echo json_encode( $this->model->lists() );
    }
    public function profile($id=null, $tab=null) {

        $id = isset( $_REQUEST['id'] ) ?  $_REQUEST['id']: $id;
        $tab = isset( $_REQUEST['tab'] ) ?  $_REQUEST['tab']: $tab;
        if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

        $item = $this->model->get( $id );
        if( empty($item) ) $this->error();
        
        $this->view->setData('item', $item );
        $this->view->setData('tab', $tab );
        $this->view->render('services/profile/display');
    }

    public function listing($id=null){
        
        $id = isset( $_REQUEST['id'] ) ?  $_REQUEST['id']: $id;
        if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        $this->view->setData('item', $item);
        $this->view->render('services/forms/listing');
    }

}