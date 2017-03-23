<?php

$title = 'Model';

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert');


$options = '';
if( empty($this->item['options']) ){
	$options.= '<li class="fullname fwb">ไม่มีข้อมูล</li>';
}
else{
	foreach ($this->item['options'] as $key => $value) {
		$options.= '<li>'.$value['name'].' '.$value['value'].'</li>';
	}
}

$form 	->field("services_options")
    	->label('รายการซ่อม')
    	->text('<ul>'.$options.'</ul>');
   
# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'models/save"></form>';

# body
$arr['body'] = $form->html();

# title
$arr['title'] = 'รายการซ่อม '.$this->item['car']['plate'];

# fotter: button
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">Cancel</span></a>';

echo json_encode($arr);