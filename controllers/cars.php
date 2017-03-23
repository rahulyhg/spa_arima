<?php

class Cars extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index($id=null, $section='basic'){
		$this->view->setPage('on', 'cars' );
        if( !empty($id) ){
         
            $options = array();
            if( $section=='basic' ){

                $this->view->setData('prefixName', $this->model->query('customers')->prefixName());
                $options['options'] = 1;
            }

            $item = $this->model->query('cars')->get( $id, $options );
            //print_r($item); die;
            if( empty($item) ) $this->error();

            $this->view->setData('id', $id );
            $this->view->setData('item', $item );
            $this->view->setData('section', $section); 
            $this->view->render("cars/profile/display");
        }
        else{
            print_r($this->model->query('cars')->lists());            die();
            if( $this->format=='json' )
            {               
                $this->view->setData('results', $this->model->query('cars')->lists() );
                $render = "Themes/crm/pages/cars/lists/json";
            }
            else{
                 
                $this->view->setData('status', $this->model->query('cars')->lists_status() );

                $render = "cars/lists/display";
            }

            $this->view->render($render);
        }
	}

    public function search(){

        // if( empty($this->me) || $this->format!='json' ) $this->error();
        echo json_encode( $this->model->lists() );
    }
     public function bookmark($id=null){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        $bookmark = isset($_REQUEST['value']) ? $_REQUEST['value']: false;
        $bookmark = !empty($bookmark) ? 0: 1;

        $this->model->update( $id, array('cus_bookmark'=>$bookmark) );

        $arr['value'] = $bookmark;
        $arr['message'] = 'บันทึกเรียบร้อย';

        echo json_encode( $arr );
    }
    public function edit_basic($id=null){
        if( empty($this->me) || empty($id) ) $this->error();

        $item = $this->model->get($id);

        if( empty($item) ) $this->error();

        $this->view->setData('prefixName', $this->model->prefixName());
        
        $this->view->setData('item', $item);
        $this->view->render('Themes/crm/pages/customers/forms/edit_basic');
    }
    
}