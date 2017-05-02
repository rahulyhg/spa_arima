<?php

class Events extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index($id=null){
		$id = isset($_REQUEST['id']) ? $_REQUEST['id']: $id;
        if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        $this->view->setData('item', $item);
        $this->view->setPage('path', 'Themes/manage/forms/events');
        $this->view->render('lists');
	}

	public function add() {
		if( empty($this->me) || $this->format!='json' ) $this->error();

		$this->view->setData('customer', $this->model->query('customers')->lists());
        $this->view->setPage('path', 'Themes/manage/forms/events');
		$this->view->render("add");
	}

	public function edit($id=null) {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id']: $id;
		if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

		$item = $this->model->get($id);
		if( empty($item) ) $this->error();

		$this->view->setData('item', $item);
        $this->view->setPage('path', 'Themes/manage/forms/events');
        $this->view->render("add");
	}

	public function save() {
		if( empty($_POST) ) $this->error();

        $start_time = !empty($_POST['start_time']) ? $_POST['start_time'].':00' : '00:00:00';
        $end_time = !empty($_POST['end_time']) ? $_POST['end_time'].':00' : '00:00:00';
        
    	$id = isset($_POST['id']) ? $_POST['id']: null;
    	if( !empty($id) ){
    		$item = $this->model->get($id);
    		if( empty($item) ) $this->error();
    	}

    	try {
            $form = new Form();
            $form   ->post('event_title')->val('is_empty')
                    ->post('event_text')
            		->post('event_location')
                    ->post('event_color_code');

            $form->submit();
            $postData = $form->fetch();

            $has_invite = isset($_REQUEST['has_invite']) ? $_REQUEST['has_invite']: 1;

            if( empty($_POST['invite']) && $has_invite==1 ){
                $arr['error']['event_invite'] = 'กรุณาเลือกผู้ที่เกี่ยวข้อง';
                $arr['message'] = 'กรุณาเลือกผู้ที่เกี่ยวข้อง';
            }

            $invite = isset($_POST['invite'])? $_POST['invite']: null;
            $postData['event_has_invite'] = $has_invite;
            $postData['event_start'] = $_POST['start_date'].' '.$start_time;
            $postData['event_end'] = $_POST['end_date'].' '.$end_time;
            $postData['event_allday'] = isset($_POST['allday']) ? $_POST['allday'] : 1;

            if( empty($arr['error']) ){

            	if( !empty($item) ){

                    if( $has_invite==1 ){
                        $this->model->deleteJoinEvent( $id );
                    }
                    
                    $this->model->update( $id, $postData );
            		$postData['id'] = $id;
            	}
            	else{
                    $postData['event_emp_id'] = $this->me['id'];
                	$this->model->insert( $postData );
                    $id = $postData['event_id'];
            	}

                if( !empty($invite) ){
                    for( $i=0;$i<count($invite['id']);$i++ ){

                        if( $invite['type'][$i]=='employees' && $invite['id'][$i]==$this->me['id'] ) continue;

                        $join = array(
                            'event_id'=>$id,
                            'obj_id'=>$invite['id'][$i],
                            'obj_type'=>$invite['type'][$i],
                        );

                        $this->model->insertJoinEvent( $join );


                        /* Due Services Status */
                        if( $invite['type'][$i] == 'services' || $invite['type'][$i] == 'booking' ){

                            $data = $this->model->query($invite['type'][$i])->get( $invite['id'][$i] );

                            $join_data = array(
                                'event_id'=>$id,
                                'obj_id'=>$data['cus']['id'],
                                'obj_type'=>'customers',
                            );

                            $this->model->insertJoinEvent( $join_data );

                            if( $invite['type'][$i] == 'services' ){

                                $service = array(
                                    'service_date_repair'=>$postData['event_start'],
                                    'service_status'=>'due'
                                    );
                                $this->model->query('services')->update( $invite['id'][$i] , $service );
                            }
                        }
                    }
                }

                if( isset($_REQUEST['callback']) ){

                    if( $_REQUEST['callback']=='bucketed' ){
                        $arr['data'] = $this->model->bucketed( $postData );
                    }
                    else{
                        $arr['data'] = $this->model->convert( $postData );
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

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ( !empty($item['permit']['del']) ) {
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
            
            $this->view->setPage('path', 'Themes/manage/forms/events');
            $this->view->render("del");
        }
	}


    public function invite($value='') {
        
        if( empty($this->me) || $this->format!='json' ) $this->error();

        if( isset($_REQUEST['objects']) ){
            if( $_REQUEST['objects']=='employees' ){
                $objects['employees'] = array('name'=> $this->lang->translate('Employee') );
            }
            else if( $_REQUEST['objects']=='customers' ){
                $objects['customers'] = array('name'=> $this->lang->translate('Customer') );
            }
        }

        if( empty($objects) ){
            $objects['employees'] = array('name'=> $this->lang->translate('Employee') );
            $objects['customers'] = array('name'=> $this->lang->translate('Customer') );
        }

        $results = $this->model->query('search')->results($objects, array('limit'=>5));
        echo json_encode($results);
    }
    public function upcoming() {
        
        if( empty($this->me) || $this->format!='json' ) $this->error();
        $data = $this->model->lists();
        echo json_encode( $data );
    }
}