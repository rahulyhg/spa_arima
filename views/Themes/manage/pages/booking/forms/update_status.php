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

	if( $this->status_id == 'finish' ){

		if( empty($this->vin) ){

			$form 	->field('item_vin')
					->label('VIN(หมายเลขตัวถัง)')
					->autocomplete('off')
					->addClass('inputtext')
					->value('');

			$form 	->field('item_engine')
					->label('Engine(หมายเลขเครื่อง)')
					->autocomplete('off')
					->addClass('inputtext')
					->value('');
		}
		else{

			$vin = '';
			foreach ($this->vin as $key => $value) {
				$vin .= '<option value="'.$value['id'].'">'.$value['vin'].'</option>';
			}

			$vin = '<select class="inputtext" name="item_id">'.$vin.'</select>';

			$form 	->field('vin')
					->label('VIN(หมายเลขตัวถัง')
					->text( $vin );
		}
	}

	$form   ->field("note")
			->name('note')
			->type('textarea')
	        ->label('หมายเหตุ')
	        ->autocomplete('off')
	        ->addClass('inputtext');
	
	$arr['form'] = '<form class="js-submit-form" action="'.URL. 'booking/update"></form>';
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