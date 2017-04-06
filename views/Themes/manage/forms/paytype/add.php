<?php

$title = 'ประเภทการจ่ายเงิน';

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert');

$form   ->field("name")
        ->label('ประเภท')
        ->addClass('inputtext')
        ->required(true)
        ->autocomplete("off")
        ->value( !empty($this->item['name']) ? $this->item['name']:'' );
        
# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'paytype/save"></form>';

# body
$arr['body'] = $form->html();

# title
if( !empty($this->item) ){
    $arr['title']= "{$title}";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "{$title}";
}

/*$arr['height'] = 'full';
$arr['overflowY'] = 'auto';
$arr['width'] = 550;*/

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">Save</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">Cancel</span></a>';

echo json_encode($arr);