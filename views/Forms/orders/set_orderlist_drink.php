<?php

$form = new Form();
$form = $form->create()
    // set From
	->elem('div')
    ->addClass('form-insert form-large');

$form   ->field("drink")
        ->autocomplete('off')
        ->type('number')
        ->attr('autoselect', 1)
        ->addClass('inputtext tac')
        ->value( isset($this->order['drink']) ? round($this->order['drink']): 0 );


# body
$arr['body'] = $form->html();


# title
$arr['title']= '<div class="clearfix">'.
	$this->lang->translate('DRINK').
	'<div class="rfloat"></div>'.
'</div>';

# set form
$arr['form'] = '<form class="js-save-orderlist" action="'.URL.'orders/_drink">';
$arr['hiddenInput'][] = array('name'=>'number','value'=>$this->number);
$arr['hiddenInput'][] = array('name'=>'date','value'=>$this->date);


# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><i class="icon-remove"></i><span class="mls">ปิด</span></a>';

// $arr['is_close_bg'] = 1;
$arr['width'] = 300;

echo json_encode($arr);