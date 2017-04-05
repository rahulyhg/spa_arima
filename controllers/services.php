<?php

class Services extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index( $id='',$tab='services' ){
    	$this->view->setPage('on', 'services' );
         if( !empty($id) ){      
            $options = array();
      
            $item = $this->model->get( $id, $options );
            $events = $this->model->query('events')->lists( array('obj_id'=>$item['cus']['id'],'obj_type'=>'customers') );

            $this->view->setData('id', $id );
            $this->view->setData('events',$events);
            $this->view->setData('item', $item );
            $this->view->setData('tab', $tab); 
            $this->view->setData('status', $this->model->status());
            $this->view->render("services/profile/display");
        }else {
            
      

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

    public function update($id=null , $type='' , $status=''){
        $id = isset( $_REQUEST['id'] ) ?  $_REQUEST['id']: $id;
        $type = isset( $_REQUEST['type'] ) ?  $_REQUEST['type']: $type;
        if( empty($this->me) || $this->format!='json' || empty($id) || empty($type) ) $this->error();
        $status = isset( $_REQUEST['status'] ) ?  $_REQUEST['status']: $status;

        $item = $this->model->get( $id );
        if( empty($item) ) $this->error();

        if( !empty($_POST) ){

            if( $type == 'status' ){
                $_POST['services']['status'] = $_POST['status'];
            }

            $postData = array();

            if( !empty($_POST['services']) ){
                foreach ($_POST['services'] as $key => $value) {
                    $postData['service_'.$key] = $value;
                }
            }

            if( !empty($postData) ){
                $this->model->update( $id , $postData );
            }

            $url = 'refresh';
            if( !empty($_REQUEST['next'])){
                $url = $_REQUEST['next'];
            }

            $arr['message'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
            $arr['url'] = $url;

            echo json_encode($arr);
        }
        else{

            if( $type == 'tec' ){
                $checked = !empty($item['tec']['id']) ? $item['tec']['id']: '';
                $checked = isset( $_REQUEST['checked'] ) ? $_REQUEST['checked']: $checked;

                $this->view->setData('checked', $checked);
                $this->view->setData('options', array( 'limit' => 1 ) );
                $this->view->setData('results', $this->model->query('employees')->tec() );
            }

            if( $type == 'status' ){
                $this->view->setData('status', $this->model->status() );
                $this->view->setData('status_id', $status);
            }

            $this->view->setData('type', $type);
            $this->view->setData('item', $item);
            $this->view->render("services/forms/update_{$type}");
        }
    }
}