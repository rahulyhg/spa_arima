<?php

class Orders extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->error();
    }

    public function lists() {
    	echo json_encode( $this->model->lists() );
    }
    public function get($id=null){

        echo json_encode( $this->model->get($id, array('has_item'=>1)) );
    }

    public function del($id=null)  {
        
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

                // print_r($item); die;
                foreach ($item['items'] as $value) {
                    

                    $this->model->delDetail($value['id']);
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

                // if( isset($_GET['masseuse']) ){
                //     $masseuse = $this->model->query('masseuse')->getJob( $_GET['masseuse'], array('date'=>$_GET['date'], 'status'=>'on', 'view_stype'=>'bucketed'));

                //     if( !empty($masseuse['skill']) ){
                //         foreach ($masseuse['skill'] as $val) {
                //             foreach ($data['skill'] as $skill) {
                //                 if( $skill['id']==$val['id'] ){
                //                     $data['masseuse'] = $masseuse;
                //                     break;
                //                 }
                //             }
                //         }
                //     }
                // }

                if( empty($data['masseuse']) ) {

                    $masseuse = $this->model->query('masseuse')->listJob( array('date'=>$_GET['date'], 'unlimit'=>1, 'status'=>'on', 'view_stype'=>'bucketed'));

                    foreach ($masseuse['lists'] as $value) {
                        
                        foreach ($value['skill'] as $val) {
                            
                            foreach ($data['skill'] as $skill) {
                                if( $skill['id']==$val['id'] ){
                                    $data['masseuse'] = $value;
                                    break;
                                }
                            }

                            if( !empty($data['masseuse']) ) break;
                        }

                        if( !empty($data['masseuse']) ) break;
                    }
                }
                // $masseuse = $this->model->query('masseuse')->firstMasseuse();
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

                // $data['masseuse'] = $this->model->query('masseuse')->firstMasseuse();
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
            'order_emp_id' => $this->me['id'],
            // ''
        );

        if( !empty($_POST['id']) ){
            $item = $this->model->get( $_POST['id'] );
        }

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
                );

                if( isset($value['masseuse_id']) ){
                    $dd['item_masseuse_id'] = $value['masseuse_id'];
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
                $this->model->updateOrder( $id, $order );
            }
            else{
                $this->model->insertOrder( $order );

                $order['status'] = 'run';
                $this->model->updateOrder( $order['id'], array('order_status'=>'run') );
            }

        // update Item 
        
            foreach ($detail as $value) {
                $value['item_order_id'] = $order['id'];
                $value['item_emp_id'] = $this->me['id'];
                $value['item_status'] = $order['status'];

                $this->model->insertDetail( $value );

                // uodate Q job
                if( !empty($value['item_masseuse_id']) ){

                    $masseuse = $this->model->query('masseuse')->getJob($value['item_masseuse_id'], array( 'status'=>'on', 'date'=> $order['date'] ) );

                    if( !empty($masseuse) ){
                        $this->model->query('masseuse')->updateJob( $masseuse['job_id'], array('job_status'=>'run') );

                    }
                }
            }

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

            // $data = $this->model->query('masseuse')->listJob( array('limit'=>1) );

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

        $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : '';
        
        // Summary //
        $start = date('Y-m-d 00:00:00');
        $end = date('Y-m-d 23:59:59');

        if( !empty($date) ){
            $start = date("Y-m-d 00:00:00", strtotime($date));
            $end = date("Y-m-d 23:59:59", strtotime($date));
        }

        /* สรุปยอดรายรับ */
        $revenue_options = array(
            'period_start'=>$start,
            'period_end'=>$end,
            'type'=>'revenue',
        );
        $this->view->setData('revenue', $this->model->query('orders')->summary( $revenue_options ));

        /* ยอดห้อง VIP */
        $room_options = array(
            'period_start'=>$start,
            'period_end'=>$end,
            'type'=>'room',
        );
        $this->view->setData('room', $this->model->query('orders')->summary( $room_options ));

        /* Package List */
        $package_options = array(
            'period_start'=>$start,
            'period_end'=>$end,
            'dashboard'=>true
        );
        // print_r($this->model->query('package')->lists( $package_options ));die;
        $this->view->setData('lists', $this->model->query('package')->lists( $package_options ));
        
        $this->view->setPage('path','Themes/pos/pages/orders/sections');
        $this->view->render("_summary");
    }

}