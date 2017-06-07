<?php

$arr['title'] = 'Cancel Queue';
if( !empty($this->item['permit']['del']) ){
	
	$arr['form'] = '<form class="js-submit-form" action="'.URL. 'masseuse/cancel"></form>';
	$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);

	if( !empty($this->date) ){
		$arr['hiddenInput'][] = array('name'=>'date', 'value'=>$this->date);
	}

	$arr['body'] = "ยกเลิกคิวงาน <span class=\"fwb\">({$this->item['code']}) {$this->item['fullname']}</span> ใน <span class=\"fwb\"> {$this->fn->q('time')->normal($this->job['job_date'])} หรือไม่ ? </span>";
	
	$arr['button'] = isset($_REQUEST['callback'])
		? '<button type="submit" role="submit" class="btn btn-danger btn-submit"><span class="btn-text">'.$this->lang->translate('Delete').'</span></button>'
		: '<button type="submit" class="btn btn-red btn-submit"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></button>';

	$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Close').'</span></a>';
}
else{

	$arr['body'] = "{$this->lang->translate('You can not delete')} <span class=\"fwb\">\"{$this->item['fullname']}\"</span>";	
	$arr['button'] = '<a href="#" class="btn btn-cancel" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Close').'</span></a>';
}


if( isset($_REQUEST['next']) ){
	$arr['hiddenInput'][] = array('name'=>'next','value'=>$_REQUEST['next']);
}

echo json_encode($arr);