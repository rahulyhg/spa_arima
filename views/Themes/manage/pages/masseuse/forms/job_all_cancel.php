<?php

$arr['title'] = 'Cancel All Queue';
	
$arr['form'] = '<form class="js-submit-form" action="'.URL. 'masseuse/cancelAll"></form>';

if( !empty($this->date) ){
	$arr['hiddenInput'][] = array('name'=>'date', 'value'=>$this->date);
}

$arr['body'] = "ยกเลิกคิวงาน <span class=\"fwb\">ของวันที่ {$this->fn->q('time')->normal($this->date)}</span> หรือไม่ ?";

$arr['button'] = isset($_REQUEST['callback'])
? '<button type="submit" role="submit" class="btn btn-danger btn-submit"><span class="btn-text">'.$this->lang->translate('Delete').'</span></button>'
: '<button type="submit" class="btn btn-red btn-submit"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></button>';

$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Close').'</span></a>';

if( isset($_REQUEST['next']) ){
	$arr['hiddenInput'][] = array('name'=>'next','value'=>$_REQUEST['next']);
}

echo json_encode($arr);