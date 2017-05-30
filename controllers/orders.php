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

    	$type = $_GET['type'];

    	if( $type=='package' ){
    		if( !empty($_GET['id']) ){
    			$data = $this->model->query('package')->get( $_GET['id'] );

                $masseuse = $this->model->query('masseuse')->requireMasseuse($data['skill']);
                if( !empty($masseuse) ){
                    $data['masseuse'] = $masseuse;
                }
    		}
    		else{
    			$data = $this->model->query('package')->lists();
    		}
    	}
    	else{

            if( !empty($_GET['id']) ){
                $menuset = $this->model->query('promotions')->get( $_GET['id'] );

                $data = array();
                if( !empty($menuset['invite']['package']) ){
                    foreach ($menuset['invite']['package'] as $key => $value) {

                        $package = $this->model->query('package')->get( $value['id'] );

                        $data[] = $package;
                    }
                }

                foreach ($data as $key => $value) {

                    $masseuse = $this->model->query('masseuse')->requireMasseuse($value['skill']);
                    if( !empty($masseuse) ){
                        $data[$key]['masseuse'] = $masseuse;
                    }
                }
            }
            else{
                $data = $this->model->query('promotions')->lists();
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
}
