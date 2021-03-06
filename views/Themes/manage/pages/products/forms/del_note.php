<?php

$arr['title'] = 'ยืนยันการลบข้อมูล';
if( $this->item['permit']['del'] ){
	
	$arr['form'] = '<form class="js-submit-form" action="'.URL. 'customers/del_note"></form>';
	$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
	$arr['body'] = "คุณต้องการลบข้อความนี้หรือไม่?";
	
	$arr['button'] = isset($_REQUEST['callback'])
		? '<button type="submit" role="submit" class="btn btn-danger btn-submit"><span class="btn-text">ลบ</span></button>'
		: '<button type="submit" class="btn btn-danger btn-submit"><span class="btn-text">ลบ</span></button>';

	$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';
}
else{

	$arr['body'] = "คุณไม่สามารถลบข้อความนี้ได้?";	
	$arr['button'] = '<a href="#" class="btn btn-cancel" role="dialog-close"><span class="btn-text">ปิด</span></a>';
}

if( !empty($this->hasMasterHost) ){
    $arr['hiddenInput'][] = array('name'=>'company','value'=>$this->company['id']);
}


echo json_encode($arr);