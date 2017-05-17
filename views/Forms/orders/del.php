<?php

$arr['title'] = 'ยืนยันการลบข้อมูล';

$name = "Order: {$this->item['date']} No.{$this->item['number']}";
if( !empty($this->item['permit']['del']) ){
	
	$arr['form'] = '<form class="js-submit-form" action="'.URL. 'orders/del"></form>';
	$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
	$arr['hiddenInput'][] = array('name'=>'has_item','value'=>1);
	$arr['body'] = "คุณต้องการลบ <span class=\"fwb\">\"{$name}\"</span> หรือไม่?";
	
	$arr['button'] = '<button type="submit" role="submit"  class="btn btn-red btn-submit"><span class="btn-text">ลบ</span></button>';
	$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';
}
else{

	$arr['body'] = "คุณไม่สามารถลบ <span class=\"fwb\">\"{$name}\"</span> ได้?";	
	$arr['button'] = '<a href="#" class="btn btn-cancel" role="dialog-close"><span class="btn-text">ปิด</span></a>';
}


echo json_encode($arr);