<?php

class Notes extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->error();
    }

    public function notes(){
        if( empty($this->me) || $this->format!='json') $this->error();
        echo json_encode($this->model->query('notes')->notes());
    }

    public function save_note(){
        if( empty($this->me) || empty($_POST) || $this->format!='json') $this->error();


        if( empty($_POST['text']) || empty($_POST['obj_id']) || empty($_POST['obj_type']) ){

            $arr['message'] = array('text'=>'กรุณากรอกข้อมูลให้ครบ!', 'bg'=>'red', 'auto'=>1, 'load'=>1) ;
            $arr['error'] = 1;
        }
        else{
            $data = array(
                'note_text' => $_POST['text'],
                'note_date' => date('Y-m-d H:s:i'),
                'note_emp_id' => $this->me['id'],
                'note_obj_id' => $_POST['obj_id'],
                'note_obj_type' => $_POST['obj_type'],
                );
            $this->model->query('notes')->save_note( $data );

            $arr['data'] = $data;

            $arr['message'] = 'บันทึกเรียบร้อย';
            $arr['url'] = 'refresh';

        }

        echo json_encode( $arr );
    }

    public function del_note($id=null) {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();
        
        $item = $this->model->query('notes')->get_note($id);
        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            if ($item['permit']['del']) {
                $this->model->query('notes')->deleteNote($id);
                $arr['message'] = 'ลบข้อมูลเรียบร้อย';
            } else {
                $arr['message'] = 'ไม่สามารถลบข้อมูลได้';
            }

            if( isset($_REQUEST['callback']) ){
                $arr['callback'] = $_REQUEST['callback'];
            }
            $arr['url'] = 'refresh';
            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->setPage('path', 'Themes/manage/forms/notes');
            $this->view->render("del_note");
        }
    }

    public function edit_note(){
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : $id;
        if( empty($this->me) || empty($id) || $this->format!='json' ) $this->error();

        $item = $this->model->query('notes')->get_note($id);

        if( empty($item) ) $this->error();

        if (!empty($_POST)) {

            try {
                $form = new Form();
                $form   ->post('note_text')->val('is_empty');

                $form->submit();
                $postData = $form->fetch();  
                
                if( empty($arr['error']) ){

                    $this->model->query('notes')->updateNote($id, $postData );
                    
                    $arr['message'] = 'บันทึกเรียบร้อย';

                    $arr['url'] = 'refresh';
                    $arr['text'] = $postData['note_text'];
                }

            } catch (Exception $e) {
                $arr['error'] = $this->_getError($e->getMessage());
            }

            echo json_encode($arr);
        }
        else{
            $this->view->setData('item', $item);
            $this->view->setPage('path', 'Themes/manage/forms/notes');
            $this->view->render("get_note");
        }
    }

}
