<?php

$arr['title'] = $this->lang->translate('Confirm').' '.$this->lang->translate('Delete');
if( !empty($this->item['permit']['del']) ){
	
	$arr['form'] = '<form class="js-submit-form" action="'.URL. 'rooms/del"></form>';
	$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
	$arr['body'] = "{$this->lang->translate('You want to delete')} <span class=\"fwb\">\"{$this->item['number']}\"</span> {$this->lang->translate('or not')}?";
	
	$arr['button'] = isset($_REQUEST['callback'])
		? '<button type="submit" role="submit" class="btn btn-danger btn-submit"><span class="btn-text">'.$this->lang->translate('Delete').'</span></button>'
		: '<button type="submit" class="btn btn-danger btn-submit"><span class="btn-text">'.$this->lang->translate('Delete').'</span></button>';

	$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';
}
else{

	$arr['body'] = "{$this->lang->translate('You can not delete')} <span class=\"fwb\">\"{$this->item['number']}\"</span>";	
	$arr['button'] = '<a href="#" class="btn btn-cancel" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Close').'</span></a>';
}


if( isset($_REQUEST['next']) ){
	$arr['hiddenInput'][] = array('name'=>'next','value'=>$_REQUEST['next']);
}

echo json_encode($arr);