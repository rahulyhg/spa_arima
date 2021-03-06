<?php

class Booking extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index( $id='', $tab='conditions' ){

    	$this->view->setPage('on', 'booking' );
        $this->view->setData('status', $this->model->query('booking')->status() ); 
        
        if( empty($id) ){
            
            if( $this->format=='json' ) {
                $this->view->setData('results', $this->model->lists() );
                $render = "booking/lists/json";
            }
            else{
                
                $this->view->setPage('title', 'ข้อมูลการจอง' );
                $this->view->setData('sales', $this->model->query('employees')->sales() );
                $this->view->setData('summary', $this->model->summary() );
                $this->view->elem('body')->addClass('is-overlay-left');
                $render = "booking/lists/display";
            }
        }
        else{
            
            $item = $this->model->get( $id, array('accessory'=>1, 'conditions'=>1) );
           
            if( empty($item) ) $this->error();

            $this->view->setData('conditions', $this->model->query('booking')->conditions() );
            // print_r($this->model->query('booking')->conditions()); die;
            // print_r($item['conditions']); die;
              $events = $this->model->query('events')->lists( array('obj_id'=>$id,'obj_type'=>'customers') );         
             if(empty($events ))   $this->error ();

            $this->view->setData('tab', $tab );
            $this->view->setData('events',$events);
            $this->view->setData('item', $item );
            $render = "booking/profile/display";
        }
        $this->view->render($render);
    }

    public function lists(){
        if( empty($this->me) || $this->format!='json' ) $this->error();
        echo json_encode($this->model->query('booking')->lists());
    }

    public function create(){
        if( empty($this->me) || $this->format!='json' ) $this->error();

        // set data dealer
        $this->view->setData('dealer', $this->model->dealer() );

        // set Sales
        // print_r($this->model->query('employees')->sales()); die;
        $this->view->setData('sales', $this->model->query('employees')->sales() );

        // Customers
        $this->view->setData('prefixName', $this->model->query('system')->_prefixNameCustomer());
        $this->view->setData('cus_refer', $this->model->query('booking')->cus_refer());
        $this->view->setData('city', $this->model->query('system')->city() );

        // set Car
        $this->view->setData('models', $this->model->query('booking')->models() );

        // conditions
        $this->view->setData('conditions', $this->model->query('booking')->conditions());

        $this->view->render("booking/create/display");
    }
    public function save() {

        if( empty($this->me) ||empty($_POST) ) $this->error();

        try {

            $arr['post'] = $_POST;
            $arr['post']['me'] = $this->me['id'];
            $this->model->check_form($arr);
            
        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }
        echo json_encode($arr);
    }
    
    public function change_sale($id=null){

        if( empty($this->me) || $this->format!='json' ) $this->error();
        $id = isset( $_REQUEST['id'] ) ?  $_REQUEST['id']: $id;

        if( !empty($id) ){

            $item = $this->model->query('booking')->get($id);
            if( empty($item) ) $this->error();
            $this->view->setData('item', $item);

            $checked = !empty($item['sale']['id']) ? $item['sale']['id']: '';
            $checked = isset( $_REQUEST['checked'] ) ? $_REQUEST['checked']: $checked;

            $this->view->setData('checked', $checked);

            if( !empty($_POST) ){

                $postData['book_sale_id'] = $_POST['ids'][0];
                $this->model->update($id, $postData);
                $arr['message'] = 'บันทึกข้อมูลเรียบร้อย';
                $arr['url'] = 'refresh';

                echo json_encode($arr);
                exit;
            }
        }

        $this->view->setData('results', $this->model->query('employees')->sales() );
        $this->view->setData('options', array( 'limit' => 1 ) );
        $this->view->render("booking/sales/forms/checklist");
    }

    public function update($id=null, $type='', $status=''){
        $id = isset( $_REQUEST['id'] ) ?  $_REQUEST['id']: $id;
        $type = isset( $_REQUEST['type'] ) ?  $_REQUEST['type']: $type;
        if( empty($this->me) || $this->format!='json' || empty($id) || empty($type) ) $this->error();

        $status = isset( $_REQUEST['status'] ) ?  $_REQUEST['status']: $status;
        $options = array();

        if( $type=='accessory' ){
            $options['accessory'] = true;
        }

        if( $type=='conditions' ){
            $options['conditions'] = true;
        }

        $item = $this->model->get($id, $options);
        if( empty($item) ) $this->error();
        //print_r($item);

        if( !empty($_POST) ){

            if( $type=='status' ){

                unset($_POST['type']);

                if( $_POST['status'] == 'finish' ){

                    /**/
                    /* SET ITEM */
                    /**/
                    if( !empty($_POST['item_id']) ){

                        $post = $this->model->query('products')->getItem( $_POST['item_id'] );
                        $post['status'] = 'sold';

                        unset($_POST['item_id']);
                    }
                    else{

                        if( empty($_POST['item_vin'])) $arr['error']['item_vin'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
                        if( empty($_POST['item_engine']) ) $arr['error']['item_engine'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';

                        $act = $this->model->query('products')->getActivity( $item['pro']['id'] );

                        $post['act_id'] = $act['id'];
                        $post['vin'] = $_POST['item_vin'];
                        $post['engine'] = $_POST['item_engine'];
                        $post['status'] = 'sold';
                        $post['color'] = $item['color']['id'];
                        $post['pro_id'] = $item['pro']['id'];

                        unset($_POST['item_vin']);
                        unset($_POST['item_engine']);
                    }

                    $this->model->query('products')->set_item( $post );

                    /**/
                    /* SET CAR */
                    /**/
                    $car['car_cus_id'] = $item['cus']['id'];
                    $car['car_emp_id'] = $this->me['id'];
                    $car['car_pro_id'] = $item['pro']['id'];
                    $car['car_color_code'] = $item['color']['primary'];
                    $car['car_color_text'] = $item['color']['name'];
                    $car['car_VIN'] = $post['vin'];
                    $car['car_engine'] = $post['engine'];

                    $this->model->query('cars')->insert( $car , false );

                    /**/
                    /* UPDATE PRODUCTS */
                    /**/
                    $products = $this->model->query('products')->get( $item['pro']['id'] );
                    $pro['pro_booking'] = $products['booking'] - 1;
                    $pro['pro_soldtotal'] = $products['soldtotal'] + 1;

                    if( empty($_POST['item_id']) ){
                        $pro['pro_order_total'] = $products['order_total'] - 1;
                    }
                    else{
                        $pro['pro_balance'] = $products['balance'] - 1;
                    }
                    //$pro['pro_total'] = $pro['pro_booking'] + $pro['pro_soldtotal'];
                    $pro['pro_date_finish'] = date('c');

                    $this->model->query('products')->update( $item['pro']['id'], $pro );

                    /**/
                    /* UPDATE MODEL */
                    /**/
                    $models = $this->model->query('models')->get( $item['model']['id'] );
                    $mod['model_amount_reservation'] = $models['amount_reservation'] - 1;
                    $mod['model_amount_sales'] = $models['amount_sales'] + 1;
                    if( empty($_POST['item_id']) ){
                        $mod['model_amount_order'] = $models['amount_order'] - 1;
                    }
                    else{
                        $mod['model_amount_balance'] = $models['amount_balance'] - 1;
                    }
                    //$mod
                    
                    $this->model->query('models')->update( $item['model']['id'], $mod );
                }

                $vin = $this->model->lists_vin( $item['pro']['id'] , $item['color']['id'] );

                if( $_POST['status'] == 'cancel' ){

                     /**/
                    /* UPDATE PRODUCTS */
                    /**/
                    $products = $this->model->query('products')->get( $item['pro']['id'] );
                    $pro['pro_booking'] = $products['booking'] - 1;
                    $pro['pro_balance'] = $products['balance'] + 1;
                    if( empty($vin) ){
                        $pro['pro_order_total'] = $products['order_total'] - 1;
                    }

                    /**/
                    /* UPDATE MODEL */
                    /**/
                    $models = $this->model->query('models')->get( $item['model']['id'] );
                    $mod['model_amount_reservation'] = $models['amount_reservation'] - 1;
                    $mod['model_amount_balance'] = $models['amount_balance'] + 1;
                    if( empty($vin) ){
                        $mod['model_amount_order'] = $models['amount_order'] - 1;
                    }
                }

                if( $_POST['status'] == 'booking' ){

                    /**/
                    /* UPDATE PRODUCTS */
                    /**/
                    $products = $this->model->query('products')->get( $item['pro']['id'] );
                    $pro['pro_booking'] = $products['booking'] + 1;
                    $pro['pro_balance'] = $products['balance'] - 1;

                    if( empty($vin) ){
                        $pro['pro_order_total'] = $products['order_total'] + 1;
                    }

                    /**/
                    /* UPDATE MODEL */
                    /**/
                    $models = $this->model->query('models')->get( $item['model']['id'] );
                    $mod['model_amount_reservation'] = $models['amount_reservation'] + 1;
                    $mod['model_amount_balance'] = $models['amount_balance'] - 1;

                    if( empty($vin) ){
                        $mod['model_amount_order'] = $models['amount_order'] + 1;
                    }
                }

                $_POST['book'] = $_POST;
            }

            if( $type == 'accessory' ){

                $this->model->del_accessory( $id );

                $accessory_price = 0;
                foreach ($_POST['accessory'] as $key => $value) {

                    if( empty($value['name']) ) continue;

                    $acc = array(
                        'name'=>$value['name'],
                        'value'=>$value['value'],
                        'cost'=>$value['cost'],
                        'rate'=>$value['rate'],
                        'has_etc'=>$value['has_etc'],
                        'FOC'=>(!empty($value['FOC'])? '1':'0'),
                        );

                    if( empty($value['FOC']) ){
                        $accessory_price = $accessory_price + $value['value'];
                    }

                    $this->model->set_accessory($acc, $id);
                }

                /**/
                /* UPDATE CONDITION */
                /**/
                $con = $this->model->conditions( );
                foreach ($con as $key => $value) {

                    if( $value['keyword'] == 'accessory' ) {
                        $con_id = $value['id'];
                    }
                }

                $s_con = $this->model->search_condition( $id , $con_id );

                if( !empty($s_con) ){
                    $up_con = array(
                        'value'=>$accessory_price
                    );

                    $this->model->up_condition( $id , $con_id , $up_con );
                }
                else{
                    $up_con = array(
                        'name'=>$con_id,
                        'value'=>$accessory_price,
                        'type'=>'income',
                        'has_etc'=>0
                    );

                    $this->model->set_condition( $up_con , $id ); 
                }

                $_POST['book'] = array('accessory_price'=>$accessory_price);
            }

            if( $type == 'insurance' ){
                $ins = array();
                $insurance_price = 0;
                foreach ($_POST['insurence'] as $key => $value) {
                    $ins['ins_'.$key] = $value;

                    if( $key == 'premium' ) $insurance_price = $value;
                }

                /**/
                /* UPDATE CONDITION */
                /**/
                $con = $this->model->conditions( );
                foreach ($con as $key => $value) {

                    if( $value['keyword'] == 'insurance' ) {
                        $ins_id = $value['id'];
                    }
                }

                $s_ins = $this->model->search_condition( $id , $ins_id );

                if( !empty($s_con) ){
                    $up_con = array(
                        'value'=>$insurance_price
                    );

                    $this->model->up_condition( $id , $ins_id , $up_con );
                }
                else{
                    $up_con = array(
                        'name'=>$ins_id,
                        'value'=>$insurance_price,
                        'type'=>'income',
                        'has_etc'=>0
                    );

                    $this->model->set_condition( $up_con , $id ); 
                }

                $this->model->update_insurance( $ins , $id );
            }

            if( $type == 'payment' ){

                $this->model->del_condition( $id );

                /* SET Payment Income (Booking Conditions) */
                $post_income = $_POST['payment']['income'];
                $price_income = 0;

                for( $i=0;$i<count($post_income['name']);$i++ ){

                    if( empty($post_income['value'][$i]) && !is_numeric($post_income['name'][$i]) ) continue;

                    $income = array(
                        'name'=>$post_income['name'][$i],
                        'value'=>$post_income['value'][$i],
                        'type'=>'income',
                        'has_etc'=>!is_numeric($post_income['name'][$i])? 1:0
                    );

                    $price_income = $price_income + $post_income['value'][$i];
                    $this->model->set_condition( $income , $id );
                }

                /* SET Payment Less */
                $post_less = $_POST['payment']['less'];
                $price_less = 0;

                for( $i=0; $i<count($post_less['name']); $i++ ) {

                    if( empty($post_less['value'][$i]) && !is_numeric($post_less['name'][$i]) ) continue;

                    $less = array(
                        'name'=>$post_less['name'][$i],
                        'value'=>$post_less['value'][$i],
                        'type'=>'income',
                        'has_etc'=>!is_numeric($post_less['name'][$i])? 1:0
                    );

                    $price_less = $price_less + $post_less['value'][$i];
                    $this->model->set_condition( $less , $id );
                }

                $net_price = $price_income - $price_less;

                $_POST['book'] = array('net_price'=>$net_price - $item['product']['price']);
            }

            if( !empty($_POST['book']) ){

                $postData = array();
                foreach ($_POST['book'] as $key => $value) {
                    
                    if( $key == 'next' ) continue;
                    $postData['book_'.$key] = $value;
                }

                if( !empty($postData['book_pro_price']) ){
                    /**/
                    /* UPDATE CONDITION */
                    /**/
                    $con = $this->model->conditions( );
                    foreach ($con as $key => $value) {

                        if( $value['keyword'] == 'carprice' ) {
                            $pro_price = $value['id'];
                        }
                    }

                    $s_car = $this->model->search_condition( $id , $pro_price );

                    if( !empty($s_car) ){
                        $up_con = array(
                            'value'=>$postData['book_pro_price']
                            );

                        $this->model->up_condition( $id , $pro_price , $up_con );
                    }
                    else{
                        $up_con = array(
                            'name'=>$pro_price,
                            'value'=>$postData['book_pro_price'],
                            'type'=>'income',
                            'has_etc'=>0
                            );

                        $this->model->set_condition( $up_con , $id ); 
                    }
                }

                if( !empty($postData['book_deposit']) ){
                    /**/
                    /* UPDATE CONDITION */
                    /**/
                    $con = $this->model->conditions( );
                    foreach ($con as $key => $value) {

                        if( $value['keyword'] == 'deposit' ) {
                            $depo_id = $value['id'];
                        }
                    }

                    $s_dep = $this->model->search_condition( $id , $depo_id );

                    if( !empty($s_dep) ){
                        $up_con = array(
                            'value'=>$postData['book_deposit']
                            );

                        $this->model->up_condition( $id , $depo_id , $up_con );
                    }
                    else{
                        $up_con = array(
                            'name'=>$depo_id,
                            'value'=>$postData['book_deposit'],
                            'type'=>'less',
                            'has_etc'=>0
                            );

                        $this->model->set_condition( $up_con , $id ); 
                    }
                }

                if( !empty($postData['book_deposit_type_options']) ){

                    $postData['book_deposit_type_options'] = json_encode($postData['book_deposit_type_options']);
                }

                if( !empty($postData['book_pay_type_options']) ){

                    /**/
                    /* UPDATE CONDITION */
                    /**/
                    $con = $this->model->conditions( );
                    foreach ($con as $key => $value) {

                        if( $value['keyword'] == 'paydown' ) {
                            $pay_id = $value['id'];
                        }
                    }

                    $s_pay = $this->model->search_condition( $id , $pay_id );

                    if( !empty($s_pay) ){
                        $up_con = array(
                            'value'=>$postData['book_pay_type_options']['down_payment_price']
                            );

                        $this->model->up_condition( $id , $pay_id , $up_con );
                    }
                    else{
                        $up_con = array(
                            'name'=>$pay_id,
                            'value'=>$postData['book_pay_type_options']['down_payment_price'],
                            'type'=>'income',
                            'has_etc'=>0
                            );

                        $this->model->set_condition( $up_con , $id ); 
                    }

                    $postData['book_finance_amount'] = $postData['book_pay_type_options']['finance_amount'];
                    $postData['book_pay_type_options'] = json_encode($postData['book_pay_type_options']);
                }

                $this->model->update( $id, $postData );
            }

            $arr['message'] = 'บันทึกข้อมูลเรียบร้อย';
            $arr['url'] = 'refresh';

            if( !empty($_REQUEST['next']) ){
                $arr['url'] = $_REQUEST['next'];
            }
            
            echo json_encode($arr);
        }
        else{

            if( $type=='car' ){
                $this->view->setData('models', $this->model->query('booking')->models() );
            }

            if( $type=='basic' ){
                 // set data dealer
                $this->view->setData('dealer', $this->model->dealer() );
                // Customers
                $this->view->setData('cus_refer', $this->model->query('booking')->cus_refer());
            }

            if( $type=='status' ){

                $this->view->setData('vin', $this->model->lists_vin( $item['pro']['id'] , $item['color']['id'] ) );
                $this->view->setData('status', $this->model->status() );
                $this->view->setData('status_id', $status);
            }

            if( $type=='conditions' ){

                $this->view->setData('conditions', $this->model->query('booking')->conditions());
            }
            
            $this->view->setData('type', $type);
            $this->view->setData('item', $item);
            $this->view->render("booking/forms/update_{$type}");
        }

    }

    public function del($id=null){
        $id = isset( $_REQUEST['id'] ) ?  $_REQUEST['id']: $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();

        $item = $this->model->get( $id );
        if( empty($item) ) $this->error();

        if( !empty($_POST) ){

            if( !empty($item['permit']['del']) ){

                if( $item['status']['id'] == 'booking' ){

                $product = $this->model->query('products')->get( $item['pro']['id'] );
                $product_item = $this->model->lists_vin( $item['pro']['id'], $item['color']['id'] );
                $model = $this->model->query('models')->get( $item['model']['id'] );

                    if( !empty($product['booking']) ){
                        $pro['pro_booking'] = $product['booking']-1;
                    }

                    if( !empty($model['amount_reservation']) ){
                        $mod['model_amount_reservation'] = $model['amount_reservation']-1;
                    }

                    if( empty($product_item) ){
                        $pro['pro_order_total'] = $product['order_total']-1;
                        $mod['model_amount_order'] = $model['amount_order']-1;
                    }
                    
                    $this->model->query('products')->update( $item['pro']['id'], $pro );
                    $this->model->query('models')->update( $item['model']['id'], $mod );
                }

                $this->model->delete( $id );
                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
                $arr['url'] = URL.'booking'; 
            }
            else{
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            if( isset($_REQUEST['callback']) ){
                $arr['callback'] = $_REQUEST['callback'];
            }

            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->render('booking/forms/del_booking');
        }
    }

    public function save_edit_car(){
        if( empty($this->me) ||empty($_POST) ) $this->error();

        $id = isset($_REQUEST['id']) ? $_REQUEST['id']: null;
        if( !empty($id) ){
            $item = $this->model->get($id);
            if( empty($item) ) $this->error();
        }

        try {
            $form = new Form();
            $form   ->post('book_model_id')->val('is_empty')
                    ->post('book_pro_id')->val('is_empty')
                    ->post('book_color')->val('is_empty');

            $form->submit();
            $postData = $form->fetch();

            if( empty($arr['error']) ){
                $this->model->update($id, $postData);

                $arr['message'] = 'บันทึกข้อมูล';
                $arr['url'] = 'refresh';
            }

        }
        catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }
        echo json_encode($arr);
    }

    public function get_product(){
        if( empty($this->me) || $this->format!='json' ) $this->error();
        echo json_encode($this->model->query('booking')->get_product());
    }

    public function get_color(){
        if( empty($this->me) || $this->format!='json' ) $this->error();
        echo json_encode($this->model->query('booking')->get_color());
    }
    public function get_accessory(){
        if( empty($this->me) || $this->format!='json' ) $this->error();
        echo json_encode($this->model->query('booking')->get_accessory());
    }

    /**/
    /* status */
    /**/
    public function add_status(){
        if( empty($this->me) || $this->format!='json' ) $this->error();
        $this->view->render("booking/status/forms/add");
    }
    public function edit_status($id=null){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();

        $item = $this->model->get_status($id);
        if( empty($item) ) $this->error();

        $this->view->setData('item', $item);
        $this->view->render("booking/status/forms/add");
    }
    public function save_status(){
        if( empty($this->me) || empty($_POST) || $this->format!='json' ) $this->error();

        if( isset($_REQUEST['id']) ){
            $id = $_REQUEST['id'];

            $item = $this->model->get_status($id);
            if( empty($item) ) $this->error();
        }

        try {
            $form = new Form();
            $form   ->post('status_label')->val('is_empty')
            ->post('status_color');

            $form->submit();
            $postData = $form->fetch();

            $postData['status_lock'] = isset($_POST['status_lock']) ? 1:0;
            $postData['status_enable'] = isset($_POST['status_enable']) ? 1:0;

            if( empty($arr['error']) ){

                if( !empty($item) ){
                    $this->model->update_status( $id, $postData );
                }
                else{
                    $this->model->insert_status( $postData );
                }

                $arr['url'] = 'refresh';
                $arr['message'] = 'บันทึกเรียบร้อย';
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }

        echo json_encode($arr);
    }
    public function del_status($id=null){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();
        
        $item = $this->model->get_status($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ( !empty($item['permit']['del']) ) {
                $this->model->delete_status($id);

                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
                $arr['url'] = isset($_REQUEST['next'])? $_REQUEST['next'] : 'refresh';
            } else {
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            if( isset($_REQUEST['callback']) ){
                $arr['callback'] = $_REQUEST['callback'];
            }

            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->render("booking/status/forms/del");
        }   
    }
    // end: status


    /**/
    /* conditions */
    /**/
    public function add_condition(){
        if( empty($this->me) || $this->format!='json' ) $this->error();
        $this->view->render("booking/conditions/forms/add");
    }
    public function edit_condition($id=null){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();

        $item = $this->model->get_condition($id);
        if( empty($item) ) $this->error();

        $this->view->setData('item', $item);
        $this->view->render("booking/conditions/forms/add");
    }
    public function save_condition(){
        if( empty($this->me) || empty($_POST) || $this->format!='json' ) $this->error();

        if( isset($_REQUEST['id']) ){
            $id = $_REQUEST['id'];

            $item = $this->model->get_condition($id);
            if( empty($item) ) $this->error();
        }

        try {
            $form = new Form();
            $form   ->post('condition_name')->val('is_empty')
            ->post('condition_keyword');

            $form->submit();
            $postData = $form->fetch();

            $postData['condition_income'] = isset($_POST['condition_income']) ? 1:0;
            $postData['condition_lock'] = isset($_POST['condition_lock']) ? 1:0;
            $postData['condition_is_cal'] = isset($_POST['condition_is_cal']) ? 1:0;

            if( empty($arr['error']) ){

                if( !empty($item) ){
                    $this->model->update_condition( $id, $postData );
                }
                else{
                    $this->model->insert_condition( $postData );
                }

                $arr['url'] = 'refresh';
                $arr['message'] = 'บันทึกเรียบร้อย';
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }

        echo json_encode($arr);
    }
    public function del_condition($id=null){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();
        
        $item = $this->model->get_condition($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ( !empty($item['permit']['del']) ) {
                $this->model->delete_condition($id);

                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
                $arr['url'] = isset($_REQUEST['next'])? $_REQUEST['next'] : 'refresh';
            } else {
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            if( isset($_REQUEST['callback']) ){
                $arr['callback'] = $_REQUEST['callback'];
            }

            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->render("booking/conditions/forms/del");
        }   
    }
    // end: conditions

    /**/
    /* Booking Customer Refer */
    /**/
    public function add_cus_refer(){
        if( empty($this->me) || $this->format!='json' ) $this->error();
        $this->view->render("booking/cus_refer/forms/add");
    }

    public function edit_cus_refer($id=null){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();

        $item = $this->model->get_cus_refer($id);
        if( empty($item) ) $this->error();

        $this->view->setData('item', $item);
        $this->view->render("booking/cus_refer/forms/add");
    }

    public function save_cus_refer(){
        if( empty($this->me) || empty($_POST) || $this->format!='json' ) $this->error();

        if( isset($_REQUEST['id']) ){
            $id = $_REQUEST['id'];

            $item = $this->model->get_cus_refer($id);
            if( empty($item) ) $this->error();
        }

        try {
            $form = new Form();
            $form   ->post('refer_name')->val('is_empty')
            ->post('refer_note');

            $form->submit();
            $postData = $form->fetch();

            $postData['refer_emp_id'] = $this->me['id'];

            if( empty($arr['error']) ){

                if( !empty($item) ){
                    $this->model->update_cus_refer( $id, $postData );
                }
                else{
                    $this->model->insert_cus_refer( $postData );
                }

                $arr['url'] = 'refresh';
                $arr['message'] = 'บันทึกเรียบร้อย';
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }
        echo json_encode($arr);
    }

    public function del_cus_refer($id=null)
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();
        
        $item = $this->model->get_cus_refer($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ( !empty($item['permit']['del']) ) {
                $this->model->delete_cus_refer($id);

                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
                $arr['url'] = isset($_REQUEST['next'])? $_REQUEST['next'] : 'refresh';
            } else {
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            if( isset($_REQUEST['callback']) ){
                $arr['callback'] = $_REQUEST['callback'];
            }

            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->render("booking/cus_refer/forms/del");
        }   
    }

    public function import() {
        
        if( !empty($_FILES) ){

            $target_file = $_FILES['file1']['tmp_name'];

            require WWW_LIBS. 'PHPOffice/PHPExcel.php';
            require WWW_LIBS. 'PHPOffice/PHPExcel/IOFactory.php';
            
            // print_r($_FILES['file1']); die;
            // $import->userfile = ;
            
            $inputFileName = $target_file;
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($inputFileName);

            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();

            $headingsArray = $objWorksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
            $headingsArray = $headingsArray[1];

            $r = -1;
            $data = array();
            $startRow = isset($_REQUEST['start_row']) ? $_REQUEST['start_row']:4;

            for ($row = $startRow; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true);

                ++$r;
                $col = 0;
                foreach ($headingsArray as $columnKey => $columnHeading) {
                    $val = $dataRow[$row][$columnKey];

                    $text = '';
                    foreach (explode(' ', trim($val)) as $value) {
                        if( empty($value) ) continue;
                        $text .= !empty($text) ? ' ':'';
                        $text .= $value;
                    }

                    $data[$r][$col] = $text;
                    $col++;
                }

                $postData['book_date'] = strtotime("Y-m-d", $data[$r][1]);
                if( empty($postData['book_date']) ) $postData['book_date'] = date('c');
                $page_number = explode("/", $data[$r][2]);
                $postData['book_page'] = $page_number[0];
                $postData['book_number'] = $page_number[1];

                /**/
                /* Search Sale */
                /**/
                $sale = $this->model->search_sale( $data[$r][11] );
                $postData['book_sale_id'] = $sale[0]['emp_id'];

                /**/
                /* Cut prefix Name */
                /**/
                $fullname = explode("/", $data[$r][3]);
                $prefix = array('นางสาว', 'นาย', 'นาง', 'บริษัท', 'บจก.');
                for( $i=0; $i<count($prefix);$i++ ){
                    $cut_prefix = explode($prefix[$i], $fullname[0]);

                    if( empty($cut_prefix[0]) && !empty($cut_prefix[1]) ){
                        $name = $cut_prefix[1];
                        break;

                        if( $prefix[$i] == 'นางสาว' ){
                            $cus['cus_prefix_name'] = 'Ms.';
                        }
                        elseif( $prefix[$i] == 'นาย' ){
                            $cus['cus_prefix_name'] = 'Mr.';
                        }
                        elseif( $prefix[$i] == 'นาง' ){
                            $cus['cus_prefix_name'] = 'Mrs.';
                        }
                        elseif( $prefix[$i] == 'บจก.' || $prefix[$i] == 'บริษัท' ){
                            $cus['cus_prefix_name'] = 'Co';
                        }
                    }
                }
                $name = explode(" ", $name);
                $first_name = $name[0];
                $last_name = $name[1];

                /**/
                /* CARD ID */
                /**/
                if( !empty($fullname[1]) && is_numeric($fullname[1]) ){
                    $card_id = $fullname[1];
                }
                else{
                    $card_id = '';
                }

                /**/
                /* Book Refer */
                /**/
                if( $data[$r][12] == 'โชว์รูม' ){
                    $postData['book_cus_refer'] = 1;
                }
                elseif( $data[$r][12] == 'ลูกค้าแนะนำ' ){
                    $postData['book_cus_refer'] = 4;
                }
                elseif( $data[$r][12] == 'ลูกค้าจากweb' || $data[$r][12] == 'Web' ){
                    $postData['book_cus_refer'] = 3;
                }
                else{
                    $postData['book_cus_refer'] = 2;
                }

                /**/
                /* ADDRESS */
                /**/
                $address = explode(" ", $data[$r][4]);
                $addr = array('ม.','ต.','ถ.','อ.','จ.');

                $customer = $this->model->search_customer( $first_name , $last_name );

                if( !empty($customer[0]['cus_id']) ){
                    $postData['book_cus_id'] = $customer[0]['cus_id'];
                }
                else{
                    $cus['cus_first_name'] = $first_name;
                    $cus['cus_last_name'] = $last_name;
                    $cus['cus_card_id'] = $card_id;

                    $this->model->query('customers')->insert( $cus );
                    $postData['book_cus_id'] = $cus['cus_id'];

                    $options['phone'][0] = array(
                        'cus_id'=>$cus['cus_id'],
                        'type'=>'phone',
                        'label'=>'เบอร์มือถือ',
                        'value'=>$data[$r][8],
                        );

                    $this->model->query('customers')->set_option( $options['phone'][0] );

                    $customer['cus_phone'] = !empty($options['phone'][0]['value'])
                    ? $options['phone'][0]['value']
                    : '';

                    $this->model->query('customers')->update( $cus['cus_id'] , $customer );
                }

                /**/
                /* Payment Down & Monthy */
                /**/

                if( !empty($data[$r][5]) ){
                    $down = explode('ดาวน์', $data[$r][5]);
                    $monthy = explode('ผ่อน', $data[$r][5]);

                    function extract_int($str){  
                        $str=str_replace(",","",$str);
                        preg_match('/[[:digit:]]+\.?[[:digit:]]*/', $str, $regs);  
                        return (doubleval($regs[0]));  
                    }

                    $down = extract_int( $down[1] );
                    $monthy = extract_int( $monthy[1] );

                    $postData['book_pay_type'] = 'hier';

                    $pay_type = array(
                        'finance_name'=>$data[$r][13],
                        'down_payment_percent'=>$down,
                        'down_payment_price'=>0,
                        'interest'=>'',
                        'supply'=>'begin',
                        'finance_amount'=>'',
                        'installment'=>$monthy,
                        'pay_monthly'=>''
                        );

                    $postData['book_pay_type_options'] = json_encode($pay_type);
                }
                else{
                    $postData['book_pay_type'] = 'cash';
                }

                /**/
                /* SET CAR */
                /**/

                $car = explode(" ", $data[$r][9]);

                $model = $this->model->search_model( $car[0] );

                $postData['book_model_id'] = $model[0]['id'];

                if( !empty($data[$r][6]) && !empty($data[$r][7]) ){
                    $vin = $data[$r][7];
                    $engine = $data[$r][6];

                    $item = $this->model->check_vin( $vin , $engine );

                    if( !empty($item) ){

                    }
                    else{
                        
                    }

                    $postData['book_status'] = 'finish';
                }
                else{
                    if( $data[$r][2] == 'ถอนจอง' ){
                        $postData['book_status'] = 'cancel';
                    }
                    else{
                        $postData['book_status'] = 'booking';
                    }
                }

                print_r($data);die;
            }
        }
        
        $this->view->render("booking/import/display");        
    }
}