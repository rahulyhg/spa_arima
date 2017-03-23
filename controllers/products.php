<?php

class Products extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($id=null) {
    	$this->view->setPage('on', 'products' );

        if( !empty($id) ){

            $item = $this->model->get( $id );
            if( empty($item) ) $this->error();

            $this->view->setData('status', $this->model->items_status() ); 
            $this->view->setData('id', $id );
            $this->view->setData('item', $item );

            // print_r( $item ); die;
            if( $this->format=='json' ){

                $this->view->setData('results', $this->model->items( $id ) ); 
                
                $render = "products/profile/lists/json";
            }
            else{
                $render = "products/profile/display";
            }
        }
        else{

            $this->error();
            if( $this->format=='json' )
            {
                $this->view->setData('results', $this->model->lists() );
                $render = "products/lists/json";
            }
            else{
                $render = "products/lists/display";
            }

            $this->view->setData('model', $this->model->query('models')->lists());
            $this->view->setData('product', $this->model->lists(array('sum'=>true)));
            $render = "products/lists/display";
            
        }

        $this->view->render($render);
    }

    public function create() {
    	$this->view->setPage('on', 'products' );

        $this->view->setData('brands', $this->model->brands());
        $this->view->setData('models', $this->model->models());

        $this->view->js('jquery/jquery-ui.min');
        $this->view->render("products/create/display");
    }

    public function edit($id=null){

        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        $activity = $this->model->getActivity($item['id']);
        if( empty($activity) ) $this->error();

        $this->view->setData('brands', $this->model->brands());
        $this->view->setData('models', $this->model->models());
        $this->view->setData('item', $item);
        $this->view->setData('activity', $activity);
        $this->view->render("products/forms/add_or_edit_dialog");

    }

    public function save() {

        if( empty($this->me) ||empty($_POST) ) $this->error();

        $id = isset($_POST['id']) ? $_POST['id']: null;

        if( !empty($id) ){
            $item = $this->model->get($id ,array('items'=>1));
            if( empty($item) ) $this->error();
        }

        try{
            $car = !empty($_POST['car']) ? $_POST['car']:array();
            $activity = !empty($_POST['activity']) ? $_POST['activity']:array();
            $items = !empty($_POST['items']) ? $_POST['items']:array();

            /* SET CAR */
            $cars = array();
            $a = array('model_id','name','price','cc','mfy');
            for($i=0;$i<count($car);$i++){
                if( empty($car[$a[$i]]) ){
                    $arr['error']['pro_'.$a[$i]] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
                }
                $cars['pro_'.$a[$i]] = $car[$a[$i]];
            }

            /* SET ACTIVITY */
            $activities = array();
            $b = array('cost','qty');
            for($i=0;$i<count($activity);$i++){
                if( empty($activity[$b[$i]]) ){
                    $arr['error'][$b[$i]] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
                }
                $activities['act_'.$b[$i]] = $activity[$b[$i]];
            }

            $cars['pro_balance'] = 0;
            $activities['act_qty'] = 0;
            $activities['act_emp_id'] =  $this->me['id'];

            if( empty($arr['error']) ){

                if( !empty($item) ){
                    $this->model->update($id, $cars);
                }
                else{
                    $this->model->insert( $cars );
                    $id = $cars['id'];
                }

                if( !empty($id) ){

                    /* Insert & Update Activity */
                    if( !empty($item) ){
                        $this->model->updateActivity($_POST['act_id'], $activities);
                        $act['id'] = $_POST['act_id'];
                    }
                    else{
                        $activities['act_pro_id'] = $id;
                        $this->model->insertActivity($activities);
                        $act['id'] = $activities['act_id'];
                    }

                    $_items = !empty($item['item']) ? $item['item']: array();

                    if( !empty($items) )
                    {
                        $sum = 0;
                        for ($i=0; $i < count($items['vin']); $i++) { 

                            if( empty($items['vin'][$i]) ) continue;

                            $data['act_id'] = $act['id'];
                            $data['pro_id'] = $id;
                            $data['vin'] = $items['vin'][$i];
                            $data['color'] = $items['color'][$i];
                            $data['engine'] = $items['engine'][$i];
                            $data['status'] = 'standby';

                            $this->model->set_item( $data );
                            $sum++;
                        }

                        $qty = array('act_qty'=>$sum);
                        $pro = array(
                            'pro_balance'=>$sum,
                            'pro_subtotal'=>$sum,
                            'pro_total'=>$sum,
                            );

                        $this->model->update($id, $pro);
                        $this->model->updateActivity( $act['id'],$qty );
                    }
                }

                $arr['message'] = 'บันทึกเรียบร้อย';
                if( !empty($item) )
                {
                    $arr['url'] = 'refresh';
                }
                else
                {
                    $arr['url'] = URL.'products/';
                }
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }
        echo json_encode($arr);
    }

    public function get_modelcolor($id=null){

        $id = isset($_GET['id']) ? $_GET['id']: $id;
        if( empty($this->me) ||empty($id) || $this->format!='json' ) $this->error();

        echo json_encode($this->model->color_model($id));
    }
    public function lists_productcolor($id=null) {
        $id = isset($_GET['id']) ? $_GET['id']: $id;
        if( empty($this->me) ||empty($id) || $this->format!='json' ) $this->error();

        echo json_encode($this->model->productcolor($id));
    }

    public function del($id=null){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();

        $item = $this->model->get($id , array('items'=>1));
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ($item['permit']['del']) {
                $this->model->delete($id);
                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
            } else {
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            $arr['url'] = URL.'products';

            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->render("products/forms/del_dialog");
        }
    }

    public function add_item($pid=null){

        if( empty($this->me) || $this->format!='json' || empty($pid) ) $this->error();

        $item = $this->model->get( $pid );
        if( empty($item) ) $this->error();

        if( !empty($_POST) ){

            $items = !empty($_POST['items']) ? $_POST['items']:array();

            $form = new Form();
            $form   ->post('qty')->val('is_empty');

            $form->submit();
            $postData = $form->fetch();

            try {

                if( !empty($items) ){

                    $sum = 0;

                    $act['act_pro_id'] = $item['id'];
                    $act['act_cost'] = $_POST['cost'];

                    if( empty($_POST['cost']) ){
                        $act['act_cost'] = $_POST['old_cost'];
                    }

                    $act['act_emp_id'] = $this->me['id'];

                    $this->model->insertActivity($act);
                    $act_id = $act['act_id'];

                    for ($i=0; $i < $postData['qty']; $i++) { 

                        if( empty($items['vin'][$i]) ) continue;

                        $sum = $sum + 1;
                        
                        $data['pro_id'] = $item['id'];
                        $data['vin'] = $items['vin'][$i];
                        $data['color'] = $items['color'][$i];
                        $data['engine'] = $items['engine'][$i];
                        $data['status'] = 'standby';
                        $data['act_id'] = $act['act_id'];

                        $this->model->set_item( $data );
                    }

                    $balance = $item['balance']+$sum;
                    $subtotal = $item['subtotal']+$sum;
                    $total = $item['total']+$sum;

                    $qty = array('act_qty'=>$sum);
                    $pro = array(
                        'pro_balance'=>$balance,
                        'pro_subtotal'=>$subtotal,
                        'pro_total'=>$total,
                        );

                    $this->model->update($pid, $pro);
                    $this->model->updateActivity( $act['act_id'],$qty );

                    $arr['message'] = 'บันทึกเรียบร้อย';
                    $arr['url'] = 'refresh';
                }

            } catch (Exception $e) {
                $arr['error'] = $this->_getError($e->getMessage());
            }
            echo json_encode($arr);
        }
        else{

            $activity = $this->model->getActivity($item['id']);
            $this->view->setData('activity' ,$activity);
            $this->view->setData('item', $item);
            $this->view->setData('colors', $this->model->query('models')->getColors( $item['model_id'] ));
            $this->view->render("products/forms/add_item");
        }
    }

    public function edit_item($id){

        if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

        $item = $this->model->query('products')->getItem($id);

        if( empty($item) ) $this->error();

        $color = $this->model->query('models')->getColors($item['model_id']);

        $this->view->setData('item',$item);
        $this->view->setData('color', $color);
        $this->view->render("products/forms/edit_item_dialog");
    }

    public function update_item() {
        if( empty($_POST) ) $this->error();

        $id = isset($_POST['id']) ? $_POST['id']: null;
        if( !empty($id) ){
            $item = $this->model->getItem($id);
            if( empty($item) ) $this->error();
        }

        try {
            $form = new Form();
            $form   ->post('vin')->val('is_empty')
            ->post('engine')->val('is_empty')
            ->post('color')->val('is_empty');

            $form->submit();
            $postData = $form->fetch();

            if( empty($arr['error']) ){

                $postData['id'] = $_POST['id'];
                $postData['pro_id'] = $_POST['pro_id'];
                $postData['act_id'] = $item['act_id'];
                $postData['status'] = $item['status'];

                $this->model->query('products')->set_item( $postData );

                $arr['message'] = 'บันทึกเรียบร้อย';
                $arr['url'] = 'refresh';
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }

        echo json_encode($arr);
    }

    public function del_item($id=null){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) ) $this->error();

        // $this->_getCompany();

        $item = $this->model->getItem($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            $this->model->delItem($id, $item['pro_id']);
            $arr['message'] = 'ลบข้อมูลเรียบร้อย';

            $arr['url'] = 'refresh';
            echo json_encode($arr);
        }
        else{
            $this->view->item = $item;
            $this->view->render("products/forms/del_item_dialog");
        }
    }
    
}