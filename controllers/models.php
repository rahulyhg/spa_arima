<?php

class Models extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index(){
		$this->error();
	}

	public function add() {
		if( empty($this->me) || $this->format!='json' ) $this->error();

        $this->view->setData('brand', $this->model->query('brands')->lists());
        $this->view->setData('dealer', $this->model->query('dealer')->lists() );

        $this->view->setPage('path', 'Themes/manage/forms/models');
		$this->view->render("add");
	}

	public function edit($id=null) {
		if( empty($this->me) || $this->format!='json' ) $this->error();

		$item = $this->model->get($id, array('colors'=>true));
		if( empty($item) ) $this->error();

        $this->view->setData('brand', $this->model->query('brands')->lists() );
        $this->view->setData('dealer', $this->model->query('dealer')->lists() );
		$this->view->setData('item', $item);

		$this->view->setPage('path', 'Themes/manage/forms/models');
        $this->view->render("add");
	}

	public function save() {
		if( empty($_POST) ) $this->error();

    	$id = isset($_POST['id']) ? $_POST['id']: null;
    	if( !empty($id) ){
    		$item = $this->model->get($id, array('colors'=>true));
    		if( empty($item) ) $this->error();
    	}

    	try {
            $form = new Form();
            $form   ->post('model_brand_id')->val('is_empty')
                    ->post('model_dealer_id')->val('is_empty')
                    ->post('model_name')->val('is_empty');

            $form->submit();
            $postData = $form->fetch();

            $has_name = true;
            if( !empty($id) ){
            	if( $postData['model_name'] == $item['name'] && $postData['model_brand_id'] == $item['brand_id']){
            		$has_name = false;
            	}
            }

            if( $this->model->is_name($postData['model_brand_id'], $postData['model_name']) && $has_name == true ){
            	$arr['error']['model_name'] = "มีชื่อนี้อยู่ในระบบแล้ว";
            }

            // set colors
            $colors = $_POST['colors'];

            if( empty($arr['error']) ){

            	if( !empty($item) ){
            		$this->model->update( $id, $postData );
            	}
            	else{
                	$this->model->insert( $postData );
                    $id = $postData['id'];
            	}

                // set color
                if( !empty($colors) ){
                    $_colors = !empty($item['colors']) ? $item['colors']: array();

                    for ($i=0; $i < count($colors['name']); $i++) { 
                        
                        if( empty($colors['name'][$i]) ) continue;
                        
                        $data = array();
                        if( !empty($_colors[$i]['id']) ){
                            $data['id'] = $_colors[$i]['id'];
                            unset($_colors[$i]);
                        }

                        $data['model_id'] = $id;
                        $data['name'] = $colors['name'][$i];
                        $data['primary'] = !empty( $colors['primary'][$i] ) ? $colors['primary'][$i]:'#ffffff';

                        $this->model->set_color( $data );
                    }

                    foreach ($_colors as $key => $value) {
                        $this->model->del_color( $value['id'] );
                    }
                    
                }
                // end: if color

                // upload image cover
                if( !empty($_FILES['image_cover']) ){
                    $userfile = $_FILES['image_cover'];

                    // set Album
                    $album_options = array(
                        'album_obj_type' => 'public',
                        'album_obj_id' => 1,
                    );
                    $album = $this->model->query('media')->searchAlbum( $album_options );

                    if( empty($album) ){

                        $this->model->query('media')->setAlbum( $album_options );
                        $album = $album_options;
                    }

                    // set Media
                    $media = array(
                        'media_album_id' => $album['album_id'],
                        'media_type' => isset($_REQUEST['media_type']) ? $_REQUEST['media_type']: strtolower(substr(strrchr($userfile['name'],"."),1))
                    );
                    $media_options = array(
                        'folder' => $album['album_id'],
                    );

                    $this->model->query('media')->set( $_FILES['image_cover'], $media , $media_options);

                    // update id image to Model
                    if( !empty($media['media_id']) ){

                        // remove delete image old
                        if( !empty($item['image_cover']) ){
                            $this->model->query('media')->del($item['image_cover']);
                        }

                        $item['image_cover'] = $media['media_id'];
                        $this->model->update( $id, array('model_image_cover'=>$media['media_id'] ) );
                    }
                }
                // end: if upload image cover 

                $arr['message'] = 'บันทึกเรียบร้อย';
                $arr['url'] = 'refresh';
            }

        } catch (Exception $e) {
            $arr['error'] = $this->_getError($e->getMessage());
        }

        echo json_encode($arr);
	}

	public function del($id=null)
	{
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
            $this->view->setPage('path', 'Themes/manage/forms/models');
            $this->view->render("del");
        }
	}
         public function del_image_cover($id=null)
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id']: $id;
        if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        if( !empty($_POST) ){
            $this->model->query('media')->del($item['image_cover']);
            $this->model->update( $id, array('model_image_cover'=>0 ) );

            $arr['message'] = "ลบเรียบร้อย";
            $arr['status'] = 1;
            echo json_encode($arr);
        }
        else{
            $this->view->id = $id;
            $this->view->setPage('path','Themes/manage/forms/models');
            $this->view->render('del_image_cover');
        }
    }

}