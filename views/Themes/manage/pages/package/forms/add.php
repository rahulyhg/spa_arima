<?php

$title = $this->lang->translate('Package');

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert');

$form   ->field("pack_code")
        ->label($this->lang->translate('Code'))
        ->addClass('inputtext')
        ->autocomplete("off")
        ->value( !empty($this->item['code']) ? $this->item['code']:'' );

$form   ->field("pack_name")
        ->label($this->lang->translate('Name'))
        ->addClass('inputtext')
        ->required(true)
        ->autocomplete("off")
        ->value( !empty($this->item['name']) ? $this->item['name']:'' );

$form   ->field("pack_timer")
        ->label($this->lang->translate('Time').' ('.$this->lang->translate('Minute').')')
        ->addClass('inputtext')
        ->autocomplete("off")
        ->type('number')
        ->value( !empty($this->item['timer']) ? $this->item['timer']:'' );

$ck_per = ''; $ck_on = '';
if( !empty($this->item['is_time']) ){
	$ck_per = ' checked="1"';
}
else{
	$ck_on = ' checked="1"';
}

//ตามเวลา
$is_time = '<div><label class="radio"><input'.$ck_on.' type="radio" name="pack_is_time" value="ontime"> '.$this->lang->translate('On Time').'</label></div>';

//ต่อครั้ง
$is_time .= '<div><label class="radio"><input'.$ck_per.' type="radio" name="pack_is_time" value="pertime"> '.$this->lang->translate('Per Time').'</label></div>';

$form 	->field("pack_is_time")
		->label($this->lang->translate('Type'))
		->addClass("inputtext")
		->text( $is_time );

$form   ->field("pack_price")
        ->label($this->lang->translate('Price'))
        ->addClass('inputtext')
        ->autocomplete("off")
        ->type('number')
        ->value( !empty($this->item['price']) ? $this->item['price']:'' );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'package/save"></form>';

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
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';

echo json_encode($arr);