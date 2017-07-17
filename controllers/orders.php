<?php

class Orders extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->error();
    }

    public function add() {
        if( empty($this->me) ) $this->error();

        // $this->view->setData('floors', $this->model->query('rooms')->floors() );
        $this->view->setData('package', $this->model->query('package')->lists());
        
        $this->view->setPage('path','Forms/orders');
        $this->view->render("create");
    }

    public function lists() {
    	echo json_encode( $this->model->lists(array('has_item'=>1)) );
    }
    public function get($id=null){

        echo json_encode( $this->model->get($id, array('has_item'=>1)) );
    }

    public function del($id=null) {
        
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();
        
        $options = array();

        if( isset($_REQUEST['has_item']) ){
            $options['has_item'] = 1;
        }

        $item = $this->model->get($id, $options);
        if( empty($item) ) $this->error();

        $item['permit']['del'] = true;

        if (!empty($_POST)) {

            if ($item['permit']['del']) {

                foreach ($item['items'] as $value) {
                    
                    $this->model->delDetail($value['id']);
                    foreach ($value['masseuse'] as $val) {
                        $this->model->query('masseuse')->updateJob( $val['job_id'], array('job_status'=>'on') );
                    }
                    $this->model->delItemJobMasseuse($value['id']);
                }
                $this->model->delOrder($id);
                
                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
            } else {
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            if( isset($_REQUEST['callback']) ){
                $arr['callback'] = $_REQUEST['callback'];
            }
            
            // $arr['url'] = isset($_REQUEST['next'])? $_REQUEST['next'] : URL.'customers/';
            
            echo json_encode($arr);
        }
        else{

            $this->view->setData('item', $item);
            $this->view->setPage('path','Forms/orders');
            $this->view->render("del");
        }
    }

    public function lastNumber() {
    	echo json_encode( $this->model->lastNumber() );
    }

    public function menu() {

    	$type = isset($_GET['type']) ? $_GET['type']: 'package';

    	if( $type=='package' ){
    		if( !empty($_GET['id']) ){
    			$data = $this->model->query('package')->get( $_GET['id'] );

                if( !empty($data['has_masseuse']) ){
                    $masseuse = $this->model->query('masseuse')->requireMasseuse($data['skill']);
                    if( !empty($masseuse) ){
                        $data['masseuse'] = $masseuse;
                    }
                }
    		}
    		else{
    			$data = $this->model->query('package')->lists();
    		}
    	}
        
    	echo json_encode( $data );
    }

    public function save() {
        // order_number
        
        // save order
        $order = array(
            'order_date' => date('Y-m-d', strtotime($_POST['date'])),
            'order_number' => $_POST['number'],
            'order_status' => isset( $_POST['status'] ) ? $_POST['status']: 'order',
            'order_total' => $_POST['summary']['total'],
            'order_drink' => $_POST['summary']['drink'],
            'order_discount' => $_POST['summary']['discount'],
            'order_balance' => $_POST['summary']['balance'],
            'order_room_price' => $_POST['summary']['room_price'],
            
        );

        // echo json_encode( $_POST ); die;
        // print_r($_POST); die;

        if( !empty($_POST['id']) ){
            $id = $_POST['id'];
            $item = $this->model->get( $id );
        }

        // print_r($_POST['items']); die;
        $detail = array();
        if( !empty($_POST['items']) ){
            foreach ($_POST['items'] as $value) {

                $dd = array(
                    'item_pack_id' => $value['pack_id'],
                    'item_price' => $value['price'],
                    'item_total' => $value['total'],
                    'item_discount' => $value['discount'],
                    'item_balance' => $value['total']-$value['discount'],
                    'item_status' => $value['status'],
                    'item_qty' =>  isset($value['qty'])? $value['qty']:1,
                    // 'item_job_id' => isset( $value['job_id'] ) ? $value['job_id'] :0,
                );

                if( !empty($value['masseuse']) ){
                    $dd['masseuse'] = $value['masseuse'];
                }

                if( isset($value['room_id']) ){
                    $dd['item_room_id'] = $value['room_id'];
                }
                if( isset($value['room_price']) ){
                    $dd['item_room_price'] = $value['room_price'];
                }
                if( isset($value['bed_id']) ){
                    $dd['item_bed_id'] = $value['bed_id'];
                }

                $detail[] = $dd;
            }
        }


        if( !empty($detail) ){

            if( !empty($item) ){
                // print_r($order); die;
                $this->model->updateOrder( $id, $order );
                $this->model->removeDetail( $id );
    
                $order['id'] = $id;
                $order = $this->model->convert($order); 
            }
            else{

                $order['order_emp_id'] = $this->me['id'];
                $this->model->insertOrder( $order );

                $order['status'] = 'run';
                $this->model->updateOrder( $order['id'], array('order_status'=>'run') );
            }

             // update Item 
            foreach ($detail as $value) {

                $data = $value;
                $data['item_order_id'] = $order['id'];
                $data['item_emp_id'] = $this->me['id'];
                $data['item_status'] = $order['status'];

                if( !empty($data['masseuse']) ){
                    unset($data['masseuse']);
                }

                $this->model->insertDetail( $data );

                // uodate masseuse
                if( !empty($value['masseuse']) && !empty($data['id']) ){

                    foreach ($value['masseuse'] as $m) {

                        // add masseuse to item
                        $this->model->itemJobMasseuse( array(
                            'item_id' => $data['id'],
                            'masseuse_id' => $m['id'],
                            'job_id' => isset($m['job']) ? $m['job']: 0,
                            'date' => $order['date'],
                        ) );
                        
                        // uodate Q job
                        $masseuse = $this->model->query('masseuse')->getJob($m['id'], array( 'status'=>'on', 'date'=> $order['date'] ) );
                        if( !empty($masseuse) ){
                            $this->model->query('masseuse')->updateJob( $masseuse['job_id'], array('job_status'=>'run') );
                        }
                    } // end for masseuse

                } // end if masseuse

            } // end for Item

            $order['items'] = $detail;
            // $order['message'] = 'Order';
        }
        else{

            $order['error'] = 1;
            $order['message'] = 'กรุณาเลือก PACKAGE';
        }

        echo json_encode( $order );
    }
    public function update($id=null, $name=null, $value=null) {

        $name = isset($_POST) ? $_POST:$name;

        $order = array();
        if( is_array($name) ){

            foreach ($name as $key => $value) {
                $order["order_{$key}"] = trim($value);
            }
        }
        else{
            $order["order_{$name}"] = $value;
        }


        $this->model->updateOrder( $id, $order );

        $arr['message'] = 'บันทึกเรียบร้อย';

        echo json_encode($arr);
    }

    public function set_bill() {

        $type = $_GET['type'];
        $date = isset($_GET['date']) ? $_GET['date']: date('Y-m-d');

        if( $type=='masseuse' ){
            $this->view->setData('position', $this->model->query('employees')->position(5) );
        }

        if( $type=='plus_masseuse' ){
            $this->view->setData('position', $this->model->query('employees')->position(5) );
        }

        if( $type=='member' ){
            $this->view->setData('level', $this->model->query('customers')->level() );
        }

        if( $type=='room' ){
            $this->view->setData('floors', $this->model->query('rooms')->floors() );
        }

        if( $type=='remove_item' ){
            $this->view->setData('package', $this->model->query('package')->get( $_GET['package'] ) );
        }

        $this->view->setData('date', $date);
        $this->view->setPage('path','Forms/orders');
        $this->view->render("set_bill_{$type}");
    }

    public function summary() {

        $date = isset($_REQUEST['date']) ? $_REQUEST['date']: '';
        
        // Summary //
        $options = array();

        if( !empty($date) ){
            $options['date'] = date("Y-m-d", strtotime($date));
        }

        $sum = $this->model->query('orders')->sumOrder( $options );
        $detail = $this->model->query('orders')->listsDetail( $options );
        // print_r($sum); die;

        $package = $this->model->query('orders')->package();

        $income = array();
        $income[] = array(
            'total' => $sum['room_price'],
            'name' => 'ค่าห้อง V.I.P.'
        );

        foreach ($package as $key => $value) {

            $arr = array(
                'total' => 0,
                // 'discount' => 0,
                // 'balance' => 0,
                'name' => $value['name']
            );

            foreach ($detail as $val) {
                if( $value['id']==$val['item_pack_id'] ){
                    // $arr['total'] += $val['item_total'];
                    // $arr['discount'] += $val['item_discount'];
                    $arr['total'] += $val['item_balance'];
                }
            }
            
            $income[] = $arr;
        }

        $income[] = array(
            'total' => $sum['drink'],
            'name' => 'DRINK'
        );
        // print_r($income); die;

        $this->view->setData('income', $income);


        /*$res = $this->model->query('orders')->summaryItem( $options );
        $this->view->setData('items', $res);*/
        /* ยอดห้อง VIP */
        /*$room_options = array(
            'period_start'=>$start,
            'period_end'=>$end,
            'type'=>'room',
        );
        $this->view->setData('room', $this->model->query('orders')->summary( $room_options ));*/

        /* Package List */
        /*$package_options = array(
            'period_start'=>$start,
            'period_end'=>$end,
            'dashboard'=>true
        );*/
        // print_r($this->model->query('package')->lists( $package_options ));die;
        // $this->view->setData('lists', $this->model->query('package')->lists( $package_options ));
        
        $this->view->setPage('path','Themes/pos/pages/orders/sections');
        $this->view->render("_summary");
    }

    public function pay($id=null) {
        
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();
        
        $options = array();

        $options['has_item'] = 1;

        $item = $this->model->get($id, $options);
        if( empty($item) ) $this->error();
 
        if (!empty($_POST)) {

            // print_r($item); die;

            if( $_POST['pay'] < $item['balance'] ){
                $arr['error']['pay'] = 'จำนวนเงินไม่ถูกต้อง';
            }

            if( empty($arr['error']) ){

                $data = array(
                    'order_pay' => $_POST['pay'],
                    'order_change' => $_POST['pay'] - $item['balance'],
                    'order_status' => 'paid'
                );

                $this->model->updateOrder( $item['id'], $data );

                foreach ($item['items'] as $key => $val) {
                    
                    $detail = array('item_status'=>'paid');
                    if( $val['end_date'] == '0000-00-00 00:00:00' ){
                        $detail['item_end_date'] = date('c');
                    }
                    $this->model->updateDetail( $val['id'], $detail );

                    foreach ($val['masseuse'] as $mas) {
                        if( !empty($mas['job_id']) && $val['status'] == 'run' ){

                            $job = $this->model->query('masseuse')->getJob( $mas['id'], array('status'=>'on', 'date'=>$item['date']) );
                
                            if( empty($job) ){
                                
                                $this->model->query('masseuse')->setJob( $mas['id'], array( 'date'=>$item['date'] ) );
                            }
                        }
                    }
                }

                if( $_POST['pay'] > $item['balance'] ){
                    $message = 'ทอนเงิน '.$data['order_change'];
                }
                else{
                    $message = 'บันทึกเรียบร้อย';
                }

                $arr['data'] = $this->model->get($id, $options);
                $arr['message'] = $message;
                $arr['id'] = $item['id'];

            }

            if( isset($_REQUEST['callback']) ){
                $arr['callback'] = $_REQUEST['callback'];
            }
            
            echo json_encode($arr);
        }
        else{

            $this->view->setData('item', $item);
            $this->view->setPage('path','Forms/orders');
            $this->view->render("pay");
        }
    }


    public function setBill() {
        
        $type = $_REQUEST['type'];

        if( $type=='member' ){
            $this->view->setData('level', $this->model->query('customers')->level() );
        }

        $this->view->setPage('path','Forms/orders');
        $this->view->render("set_bill_{$type}");
    }




    /* */
    /* set list POs */
    /**/
    public function _chooseMenu() {
        
        if( empty($_REQUEST['package']) ) $this->error();

        $package = $this->model->query('package')->get( $_REQUEST['package'] );
        if( empty($package) ) $this->error();

        if( !empty($package['has_masseuse']) ){
            $masseuse = $this->model->query('masseuse')->requireMasseuse($package['skill']);
            if( !empty($masseuse) ){
                $package['masseuse'] = $masseuse;
            }
        }

        $date = isset($_REQUEST['date']) ? $_REQUEST['date']: date('Y-m-d');

        $this->view->setData('date', $date );
        $this->view->setData('number', $_REQUEST['number'] );
        $this->view->setData('package', $package );
        $this->view->setData('date', isset($_REQUEST['date']) ? $_REQUEST['date']: date('Y-m-d') );

        $order = $this->model->get('number', array(
            'date' => $date,
            'number' => $_REQUEST['number']
        ));
        $this->view->setData('order', $order );

        if( !empty($order) ){

            $itemID = $this->model->getDetailID($order['id'], $_REQUEST['package']);
            $this->view->setData('item', $this->model->getDetail( $itemID ) );
        }

        $this->view->setPage('path','Forms/orders');
        $this->view->render("set_orderlist_menu");
    }
    public function saveMenu()  {
        
        if( empty($arr['error']) ){

            $order = $this->model->get( 'number', array(
                'date' => $_POST['date'],
                'number' => $_POST['number']
            ));
            if( empty($order) ){

                // Insert order
                $order = array(
                    'order_date' => $_POST['date'],
                    'order_number' => $_POST['number'],
                    'order_emp_id' => $this->me['id'],
                    'order_start_date' => date('c')
                );

                $this->model->insertOrder( $order );
            }

            // set package
            $itemID = $this->model->getDetailID($order['id'], $_POST['package']);

            $item = array(
                'item_order_id' => $order['id'],
                'item_pack_id' => $_POST['package'],
                'item_qty' => $_POST['time'],
                // 'item_price' => $_POST['price'],
                'item_total' => $_POST['total'],
                'item_discount' => $_POST['discount'],
                'item_balance' => $_POST['total']-$_POST['discount'],
                'item_note' => $_POST['note'],
            );
            if( !empty($itemID) ){
                // update
                $this->model->updateDetail($itemID, $item);
                $item['id'] = $itemID;
            }
            else{
                // insert 
                $this->model->insertDetail($item);
            }

            // del หมอ
            $this->model->delItemJobMasseuse($item['id']);

            // save หมอ
            if( !empty($_REQUEST['masseuse']) ){
                foreach ($_REQUEST['masseuse'] as $value) {
                    
                    $job_id = 0;
                    if( isset($value['job']) ){
                        $job_id = $value['job'];
                    }
                    else{

                        $job = $this->model->query('masseuse')->getJob( $value['id'], array('status'=>'on', 'date'=>$_POST['date']) );
                        if( !empty($job) ){
                            $job_id = $job['job_id'];
                        }
                    }

                    $this->model->itemJobMasseuse(array(
                        'item_id' => $item['id'],
                        'masseuse_id' => $value['id'],
                        'job_id' => $job_id,
                        'date' => $_POST['date']
                    ));
                }
            }
            
            $arr['message'] = 'บันทึกเรียบร้อย';
            $arr['url'] = 'refresh';

        }

        echo json_encode($arr);
    }


    public function _drink() {

        $date = isset($_REQUEST['date']) ? $_REQUEST['date']: date('Y-m-d');
        $number = isset($_REQUEST['number']) ? $_REQUEST['number']: 0;
        if( empty($number) ) $this-> error();
        
        $order = $this->model->get('number', array(
            'date' => $date,
            'number' => $number
        ));

        if( !empty($_POST) ){

            if( empty($order) ){
                $order = array(
                    'order_date' => $date,
                    'order_number' => $number,
                    'order_emp_id' => $this->me['id'],
                    'order_start_date' => date('c'),
                );

                $this->model->insertOrder( $order );

                $order['balance'] = 0;
            }

            $drink = intval($_POST['drink']);
            $this->model->updateOrder( $order['id'], array(
                'order_drink' => $drink,
                'order_balance' =>$order['balance'] + $drink
            ) );

            $arr['message'] = 'บันทึกเรียบร้อย';
            echo json_encode($arr);
            
        }
        else{
            $this->view->setData('order', $order );
            $this->view->setData('date', $date );
            $this->view->setData('number', $number );

            $this->view->setPage('path','Forms/orders');
            $this->view->render("set_orderlist_drink");

        } 
    }

    public function delItem($id=null) {
        
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) ) $this->error();

        $item = $this->model->getDetail( $id );
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ( !empty($item['permit']['del']) || 1==1 ) {

                $this->model->delItemJobMasseuse($id);
                $this->model->delDetail($id);
                
                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
            } else {
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            $arr['url'] = isset($_REQUEST['next']) ? $_REQUEST['next']:'refresh';
            echo json_encode($arr);
        }
        else{
            $this->view->item = $item;
            $this->view->setPage('path','Forms/orders');
            $this->view->render("item_del");
        }
    }

    
}
