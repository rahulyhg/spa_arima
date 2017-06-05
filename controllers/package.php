<?php

class Package extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        

        if( $this->format=='json' ) {
            $this->view->setData('results', $this->model->lists() );
            $render = "package/lists/json";
        }
        else{

            $this->view->setData('skill', $this->model->query('employees')->skill() );
            $this->view->setData('unit', $this->model->unit() );
            $this->view->setData('status', $this->model->status() );

            $render = "package/lists/display";
        }

        $this->view->render( $render );
    }

    public function add() {
        if( empty($this->me) || $this->format!='json' ) $this->error();

        $this->view->setData('skill', $this->model->query('employees')->skill() );
        $this->view->setData('unit', $this->model->unit() );

        $this->view->setPage('path','Themes/manage/forms/package');
        $this->view->render("add");
    }

    public function edit($id=null) {
        if( empty($this->me) || $this->format!='json' ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();
        $this->view->setData('item', $item);

        $this->view->setData('skill', $this->model->query('employees')->skill() );
        $this->view->setData('unit', $this->model->unit() );

        $this->view->setPage('path','Themes/manage/forms/package');
        $this->view->render("add");
    }

    public function save() {
        if( empty($_POST) ) $this->error();

        $id = isset($_POST['id']) ? $_POST['id']: null;
        if( !empty($id) ){
            $item = $this->model->get($id);
            if( empty($item) ) $this->error();
        }

        try {
            $form = new Form();
            $form   ->post('pack_code')
                    ->post('pack_name')->val('is_empty')
                    ->post('pack_qty')->val('is_empty')
                    ->post('pack_unit')->val('is_empty')
                    ->post('pack_price')->val('is_empty');

            $form->submit();
            $postData = $form->fetch();

            $has_name = true;
            if( !empty($id) ){
                if( $postData['pack_name'] == $item['name']){
                    $has_name = false;
                }
            }

            if( $this->model->is_name($postData['pack_name']) && $has_name == true ){
                $arr['error']['pack_name'] = "มีชื่อนี้อยู่ในระบบแล้ว";
            }

            if( empty($arr['error']) ){

                // 0 = ตามเวลา(Ontime) , 1 ครั้ง(Pertime)
                $postData['pack_has_masseuse'] = isset($_POST['has_masseuse']) ? 1: 0;

                if( !empty($item) ){

                    if( !empty($item['skill']) ){
                        $this->model->unsetSkill( $id );
                    }
                    
                    $this->model->update( $id, $postData );
                }
                else{
                    $postData['pack_emp_id'] = $this->me['id'];
                    $this->model->insert( $postData );
                    $id = $postData['id'];
                }

                if( !empty($_POST['skill']) ){

                    foreach ($_POST['skill'] as $key => $value) {

                        $skill = array(
                            'skill_id'=>$value,
                            'pack_id'=>$id,
                        );

                        $this->model->setSkill( $skill );
                    }
                }

                //----- UPLOAD IMAGE -----//
                if( !empty($_FILES['pack_image']) ){

                    $userfile = $_FILES['pack_image'];

                    if( !empty($item['image_id']) ){
                        $this->model->query('media')->del($item['image_id']);
                        $this->model->update( $id, array('pack_image_id'=>0 ) );
                    }

                    $album = array('album_id'=>2);
                    
                    if( empty($structure) ){
                        $structure = WWW_UPLOADS . $album['album_id'];
                        if( !is_dir( $structure ) ){
                            mkdir($structure, 0777, true);
                        }
                    }

                    /**/
                    /* get Data Album */
                    /**/
                    $options = array(
                        'album_obj_type' => isset( $_REQUEST['obj_type'] ) ? $_REQUEST['obj_type']: 'public',
                        'album_obj_id' => isset( $_REQUEST['obj_id'] ) ? $_REQUEST['obj_id']: 1,
                        );

                    if( isset( $_REQUEST['album_name'] ) ){
                        $options['album_name'] = $_REQUEST['album_name'];
                    }
                    $album = $this->model->query('media')->searchAlbum( $options );

                    if( empty($album) ){
                        $this->model->query('media')->setAlbum( $options );
                        $album = $options;
                    }

                    // set Media Data
                    $media = array(
                        'media_album_id' => $album['album_id'],
                        'media_type' => isset($_REQUEST['media_type']) ? $_REQUEST['media_type']: strtolower(substr(strrchr($userfile['name'],"."),1))
                        );

                    $options = array(
                        'folder' => $album['album_id'],
                        );

                    if( !isset($media['media_emp_id']) ){
                        $media['media_emp_id'] = $this->me['id'];
                    }

                    $this->model->query('media')->set( $userfile, $media, $options );

                    if( empty($media['error']) ){
                        $media = $this->model->query('media')->convert($media);
                    }
                    $item['image_id'] = $media['id'];
                    $this->model->update( $id, array('pack_image_id'=>$item['image_id'] ) );
                    
                }

                // resize 
                if( !empty($_POST['cropimage']) && !empty($item['image_id']) ){
                    $this->model->query('media')->resize($item['image_id'], $_POST['cropimage']);
                }
                //----- END UPLOAD -----//

                $arr['message'] = 'บันทึกเรียบร้อย';
                // $arr['url'] = 'refresh';
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
            $this->view->render("package/forms/del");
        }
    }

    public function del_image_cover($id=null)
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id']: $id;
        if( empty($this->me) || $this->format!='json' || empty($id) ) $this->error();

        $item = $this->model->get($id);
        if( empty($item) ) $this->error();

        if( !empty($_POST) ){
            $this->model->query('media')->del($item['image_id']);
            $this->model->update( $id, array('pack_image_id'=>0 ) );

            $arr['message'] = "ลบเรียบร้อย";
            $arr['status'] = 1;
            echo json_encode($arr);
        }
        else{
            $this->view->id = $id;
            $this->view->setPage('path','Themes/manage/forms/package');
            $this->view->render('del_image_cover');
        }
    }

}