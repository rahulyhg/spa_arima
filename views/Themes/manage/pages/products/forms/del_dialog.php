<?php

$arr['title'] = 'ยืนยันการลบข้อมูล';
if( $this->item['permit']['del'] ){
	
	$arr['form'] = '<form class="js-submit-form" action="'.URL. 'products/del"></form>';
	$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
	$arr['body'] = "คุณต้องการลบ <span class=\"fwb\">\"{$this->item['model_name']} รุ่น {$this->item['name']}\"</span> หรือไม่?";
	
	$arr['button'] = isset($_REQUEST['callback'])
		? '<button type="submit" role="submit" class="btn btn-danger btn-submit"><span class="btn-text">ลบ</span></button>'
		: '<button type="submit" class="btn btn-danger btn-submit"><span class="btn-text">ลบ</span></button>';

	$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';
}
else{

	$arr['body'] = "คุณไม่สามารถลบ <span class=\"fwb\">\"{$this->item['model_name']} รุ่น {$this->item['name']}\"</span> ได้?";	
	$arr['button'] = '<a href="#" class="btn btn-cancel" role="dialog-close"><span class="btn-text">ปิด</span></a>';
}


if( isset($_REQUEST['next']) ){
	$arr['hiddenInput'][] = array('name'=>'next','value'=>$_REQUEST['next']);
}

if( !empty($this->hasMasterHost) ){
    $arr['hiddenInput'][] = array('name'=>'company','value'=>$this->company['id']);
}


echo json_encode($arr);