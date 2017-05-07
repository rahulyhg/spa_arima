<?php

class Promotions extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        
        $this->view->setPage('on', 'promotions' );
           
        if( !empty($id) ){

            $options = array();

            $options['options'] = 1;

            $item = $this->model->query('promotions')->get( $id, $options );
            if( empty($item) ) $this->error();

            $this->view->setData('id', $id );
            $this->view->setData('item', $item );
            $this->view->setData('tab', $section); 
            $this->view->render("promotions/profile/display");
        }
        else{

            $this->view->setData('status', $this->model->status() );

            if( $this->format=='json' ) {
                $this->view->setData('results', $this->model->lists() );
                $render = "promotions/lists/json";
            }
            else{

                $this->view->setData('type', $this->model->type() );

                $render = "promotions/lists/display";
            }

            $this->view->render($render);
        }



        /*$data = $this->model->lists();
        // print_r($data);die;
        $this->view->setData('data', $data);
        $this->view->render('promotions/lists/display');*/
    }

    public function add() {

        if( empty($this->me) || $this->format!='json' ) $this->error();

        $this->view->setData('status', $this->model->status());
        $this->view->setData('type', $this->model->type());

        $this->view->setPage('path','Themes/manage/forms/promotions');
        $this->view->render("add");
    }

    public function edit($id=null) {
        if( empty($this->me) || $this->format!='json' ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        $this->view->setData('status', $this->model->status());
        $this->view->setData('type', $this->model->type());

        $this->view->setData('item', $item);

        $this->view->setPage('path','Themes/manage/forms/promotions');
        $this->view->render("add");
    }

    public function save() {
        if( empty($_POST) ) $this->error();
        // print_r($_POST); die;

        $id = isset($_POST['id']) ? $_POST['id']: null;
        if( !empty($id) ){
            $item = $this->model->get($id);
            if( empty($item) ) $this->error();
        }

        try {
            $form = new Form();
            $form   ->post('pro_type')->val('is_empty')
                    ->post('pro_name')->val('is_empty')
                    ->post('pro_discount')->val('is_empty');

            $form->submit();
            $postData = $form->fetch();

            
            $postData['pro_has_qty'] = isset($_POST['has_qty']) ? $_POST['has_qty']:0;
            if( !empty($postData['pro_has_qty']) ){
                if( empty($_POST['pro_qty']) ){
                    $arr['error']['pro_qty'] = 'Input Quantity!';
                }
                elseif( !is_numeric($_POST['pro_qty']) ){
                    $arr['error']['pro_qty'] = 'Input is Number';
                }
                else{
                    $postData['pro_qty'] = $_POST['pro_qty'];
                }
            }

            $postData['pro_has_time'] = isset($_POST['has_time']) ? $_POST['has_time']:0;
            if( isset($_POST['has_time']) ){

                /* SET Default */ 
                $postData['pro_has_enddate'] = isset($_POST['has_end']) ? 1:0;
                $postData['pro_time_allday'] = isset($_POST['allday']) ? $_POST['allday']:0;

                $startTime = '00:00';
                $endTime = '00:00';
                /**/

                /* SET DATA TIME  */
                if( empty($postData['pro_time_allday']) ){
                    $startTime = $_POST['start_time'];

                    if( !empty($postData['pro_has_enddate']) ){
                        $endTime = $_POST['end_time'];
                    }
                }

                /* SET TIME */
                $postData['pro_start_date'] = date("{$_POST['start_date']} {$startTime}:00");
                $postData['pro_end_date'] = date("{$_POST['end_date']} {$endTime}:00");
                /**/

                if( !empty($postData['pro_has_enddate']) ){
                    if( strtotime($postData['pro_end_date']) < strtotime($postData['pro_start_date']) ){
                        $arr['error']['pro_time'] = 'กำหนดเวลาไม่ถูกต้อง';
                    }
                }
            }

            $postData['pro_is_join'] = isset($_POST['is_join']) ? $_POST['is_join']:0;
            if( empty($_POST['invite']['id']) && !empty($postData['pro_is_join']) ){
                $arr['error']['invite'] = 'กำหนดสินค้าที่อยู่ในรายการ';
                $arr['message'] = array('text'=>'กำหนดสินค้าที่ร่วมรายการ','bg'=>'red','load'=>1,'auto'=>1);
            }

            if( empty($arr['error']) ){

                if( !empty($item) ){

                    $this->model->clearProduct($id);
                    $this->model->update( $id, $postData );
                }
                else{

                    $postData['pro_emp_id'] = $this->me['id'];
                    $this->model->insert( $postData );
                    $id = $postData['id'];
                }

                if( !empty($_POST['invite']['id']) && !empty($postData['is_join']) ){

                    foreach ($_POST['invite']['id'] as $val) {

                        $this->model->joinProduct( array(
                            'pro_id' => $id,
                            'obj_type' => 'package',
                            'obj_id' => $val
                        ) );
                    }
                }

                $arr['message'] = 'บันทึกเรียบร้อย';
                $arr['url'] = 'refresh';
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }

        echo json_encode($arr);
    }

    public function del($id=null) {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) ) $this->error();

        // $this->_getCompany();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ($item['permit']['del']) {
                $this->model->delete($id);
                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
            } else {
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            $arr['url'] = 'refresh';
            echo json_encode($arr);
        }
        else{
            $this->view->item = $item;
            $this->view->render("promotions/forms/del");
        }
    }


    public function invite() {
        if( empty($this->me) || $this->format!='json' ) $this->error();

        $objects['package'] = array('name'=> $this->lang->translate('Package') );
        $options = array(
            'limit'=> isset($_REQUEST['limit']) ? $_REQUEST['limit']: 20
        );

        $results = $this->model->query('search')->results( $objects, $options );
        echo json_encode($results);
    }

    public function setdata($id='', $field=null)
    {
        if( empty($id) || empty($field) || empty($this->me) ) $this->error();

        $data['pro_'.$field] = isset($_REQUEST['value'])? $_REQUEST['value']:'';
        $this->model->update($id, $data);

        $arr['message'] = 'บันทึกเรียบร้อย';
        echo json_encode($arr);
    }
}