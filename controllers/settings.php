<?php

class Settings extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index( ){
    	$this->my();
    }

    public function company( $tap='basic' ) {

        $this->view->setPage('on', 'settings' );
        $this->view->setData('section', 'company');
        $this->view->setData('tap', 'display');
        $this->view->setData('_tap', $tap);

        if( empty($this->permit['company']['view']) ) $this->error();
        // print_r($this->permit); die;

        if( $tap == 'dealer' ){

            $this->view->setData('paytype', $this->model->query('paytype')->lists());
            $this->view->setData('data', $this->model->query('dealer')->lists());
        }
        elseif( $tap != 'basic' ){

            $this->error();
        }

        if( !empty($_POST) && $this->format=='json' ){

            foreach ($_POST as $key => $value) {
                $this->model->query('system')->set( $key, $value);
            }

            $arr['url'] = 'refresh';
            $arr['message'] = 'บันทึกเรียบร้อย';

            echo json_encode($arr);
        }
        else{
            $this->view->render("settings/display");
        }
        // else{
        //     $this->view->setPage('on', 'settings' );
        //     $this->view->setData('section', 'company');
            

        //     $this->view->render("settings/display");
        // } 
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
            $this->view->setData('access', $this->model->query('system')->roles());
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


    public function dealer() {

        $this->view->setPage('on', 'settings');
        $this->view->setData('section', 'dealer');

        $this->view->setData('paytype', $this->model->query('paytype')->lists());
        $this->view->setData('data', $this->model->query('dealer')->lists());
        $this->view->render('settings/display');
    }

    public function paytype(){

        $this->view->setPage('on', 'settings');
        $this->view->setData('section', 'paytype');

        $this->view->setData('data', $this->model->query('paytype')->lists());
        $this->view->render('settings/display');
    }

    /**/
    /* rooms */
    /**/
    public function rooms($tap='') {

        $this->view->setData('on','settings');
        $this->view->setData('section', 'rooms');

        Session::init();
        $dealer_id = Session::get('dealer_id');

        $this->view->setData('dealer_id', $dealer_id); 
        $this->view->setData('dealer', $this->model->query('dealer')->lists()); 

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