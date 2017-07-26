<?php

$arr['title'] = 'ยืนยันการลบข้อมูล';
if( !empty($this->item['permit']['del']) || 1==1 ){
	
	$arr['form'] = '<form class="js-save-orderlist" action="'.URL. 'orders/delItem"></form>';
	$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['item_id']);
	$arr['body'] = "คุณต้องการลบรายการนี้หรือไม่?";
	 
	$arr['button'] = '<button type="submit" class="btn btn-danger btn-submit"><span class="btn-text">ลบ</span></button>';
	$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

}
else{

	$arr['body'] = "คุณไม่สามารถลบรายการได้?";	
	$arr['button'] = '<a href="#" class="btn btn-cancel" role="dialog-close"><span class="btn-text">ปิด</span></a>';
}

echo json_encode($arr);