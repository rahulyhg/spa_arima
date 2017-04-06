<?php

class Settings extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index( ){
    	$this->my();
    }

    public function company() {

        if( empty($this->permit['company']['view']) ) $this->error();
        // print_r($this->permit); die;

        if( !empty($_POST) && $this->format=='json' ){

            foreach ($_POST as $key => $value) {
                $this->model->query('system')->set( $key, $value);
            }

            $arr['url'] = 'refresh';
            $arr['message'] = 'บันทึกเรียบร้อย';

            echo json_encode($arr);
        }
        else{
            $this->view->setPage('on', 'settings' );
            $this->view->setData('section', 'company');
            

            $this->view->render("settings/display");
        } 
    }

    public function my( $tap='basic' ) {

        $this->view->setPage('on', 'settings' );
        $this->view->setData('section', 'my');
        $this->view->setData('tap', 'display');
        $this->view->setData('_tap', $tap);

        if( $tap=='basic' ){
            $this->view
            ->js(VIEW .'Themes/manage/assets/js/bootstrap-colorpicker.min.js', true)
            ->css( VIEW .'Themes/manage/assets/css/bootstrap-colorpicker.min.css', true);

            $this->view->setData('prefixName', $this->model->query('system')->_prefixNameCustomer());
        }

        $this->view->render("settings/display");
    }

    /**/
    /* booking */
    /**/
    public function booking($tap='cus_refer'){

        $this->view->setPage('on', 'settings' );
        $this->view->setData('section', 'booking');
        $this->view->setData('tap', $tap);

        $data = array();
        if( $tap=='status' && !empty($this->me['dep_is_admin']) ){

            $this->view
            ->js(VIEW .'Themes/manage/assets/js/bootstrap-colorpicker.min.js', true)
            ->css( VIEW .'Themes/manage/assets/css/bootstrap-colorpicker.min.css', true);
            $data = $this->model->query('booking')->status();
        }else if($tap=='conditions' && !empty($this->me['dep_is_admin']) ){
            $data = $this->model->query('booking')->conditions();
        }
        else 
        if($tap=='cus_refer'){
            $data = $this->model->query('booking')->cus_refer();
        }
        else{
            $this->error();
        }

        $this->view->setData('data', $data);
        $this->view->render("settings/display");
    }

    /**/
    /* Manage employees */
    /**/
    public function accounts($tap='employees'){

        // print_r($this->premit); die;

        $this->view->setPage('on', 'settings' );
        $this->view->setData('section', 'accounts');
        $this->view->setData('tap', $tap);
        $render = 'settings/display';

        if($tap=='position'){
            $data = $this->model->query('employees')->position();
        }
        elseif($tap=='department'){
            $data = $this->model->query('employees')->department();
        }
        elseif($tap=='employees'){

            if( $this->format=='json' ){
                // sleep(5);
                $this->view->setData('results', $this->model->query('employees')->lists());

                $render = 'settings/sections/accounts/employees/lists/json';
            }

            $this->view->setData('department', $this->model->query('employees')->department() );
            $this->view->setData('position', $this->model->query('employees')->position() );
            $this->view->setData('display', $this->model->query('employees')->display() );
            $data = array();
        }
        elseif($tap=='skill'){
            $data = $this->model->query('employees')->skill();
        }
        else{
            $this->error();
        }

        $this->view->setData('data', $data);
        $this->view->render( $render );
    }

    /**/
    /* products */
    /**/
    public function brands(){
        $this->view->setPage('on', 'settings');
        $this->view->setData('section', 'products');
        $this->view->setData('tap', 'brands');

        $this->view->setData('data', $this->model->query('brands')->lists());
        $this->view->render('settings/display');
    }
    public function models() {
        $this->view->setPage('on', 'settings');
        $this->view->setData('section', 'products');
        $this->view->setData('tap', 'models');

        $this->view
        ->js(VIEW .'Themes/manage/assets/js/bootstrap-colorpicker.min.js', true)
        ->css( VIEW .'Themes/manage/assets/css/bootstrap-colorpicker.min.css', true);


        $this->view->setData('data', $this->model->query('models')->lists( array('colors'=>true) ) );
        $this->view->render('settings/display');
        
    }
    public function dealer() {

        $this->view->setPage('on', 'settings');
        $this->view->setData('section', 'dealer');

        $this->view->setData('data', $this->model->query('dealer')->lists());
        $this->view->render('settings/display');
    }
    public function accessory($tap='accessory') {

        $this->view->setPage('on', 'settings');
        $this->view->setData('section', 'products');
        $this->view->setData('tap', $tap);
        $render = 'settings/display';

        if( $tap=='stores' ){
            $data = $this->model->query('stores')->lists();
        }
        elseif( $tap=='accessory' ){
            if( $this->format=='json' ){ 

                $this->view->setData('results', $this->model->query('accessory')->lists());
                $render = 'settings/sections/products/accessory/lists/json';
            }
            $this->view->setData('model', $this->model->query('accessory')->model() );
            $this->view->setData('store', $this->model->query('accessory')->store() );
            $data = array();
            
        }else{
            $this->error();
        }
        $this->view->setData('data', $data);
        $this->view->render( $render );
    }

    public function paytype(){

        $this->view->setPage('on', 'settings');
        $this->view->setData('section', 'paytype');

        $this->view->setData('data', $this->model->query('paytype')->lists());
        $this->view->render('settings/display');
    }

    public function customers( $tap='level' ){

        $this->view->setPage('on', 'settings');
        $this->view->setData('section', 'customers');
        $this->view->setData('tap', $tap);
        $render = 'settings/display';

        if( $tap == 'level' ){
            $data = $this->model->query('customers')->level();
        }
        else{
            $this->error();
        }

        $this->view->setData('data', $data);
        $this->view->render( $render );
    }

}