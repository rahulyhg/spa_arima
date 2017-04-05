<?php

$arr['title'] = 'ยืนยันการเปลี่ยนสถานะ';
if( !empty($this->item['permit']['del']) ){

	$status_name = '';
	foreach ($this->status as $key => $value) {
		if( $this->status_id==$value['id'] ){
			$status_name = $value['name'];
			break;
		}
	}

	$form = new Form();
	$form = $form->create()
	    // set From
	    ->elem('div')
	    ->addClass('form-insert');

	$form   ->field("note")
			->name('note')
			->type('textarea')
	        ->label('หมายเหตุ')
	        ->autocomplete('off')
	        ->addClass('inputtext');
	
	$arr['form'] = '<form class="js-submit-form" action="'.URL. 'services/update"></form>';
	$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
	$arr['hiddenInput'][] = array('name'=>'type','value'=>'status');
	$arr['hiddenInput'][] = array('name'=>'status','value'=>$this->status_id);

	$arr['body'] = "<div class=\"uiBoxYellow pam mbm\">คุณต้องการเปลี่ยนสถานะการจองนี้ให้เป็น <span class=\"fwb\">\"{$status_name}\"</span> หรือไม่?</div>".$form->html();
	
	$arr['button'] = '<button type="submit" class="btn btn-blue btn-submit"><span class="btn-text">บันทึก</span></button>';
	$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';
}
else{

	$arr['body'] = "คุณไม่สามารถเปลี่ยนสถานะการจองนี้ได้?";	
	$arr['button'] = '<a href="#" class="btn btn-cancel" role="dialog-close"><span class="btn-text">ปิด</span></a>';
}


if( isset($_REQUEST['next']) ){
	$arr['hiddenInput'][] = array('name'=>'next','value'=>$_REQUEST['next']);
}

echo json_encode($arr);