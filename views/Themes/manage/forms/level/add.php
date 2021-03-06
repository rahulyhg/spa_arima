<?php

$title = $this->lang->translate('Customer Level');

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert');

$form   ->field("level_name")
        ->label($this->lang->translate('Name'))
        ->addClass('inputtext')
        ->autocomplete("off")
        ->value( !empty($this->item['name']) ? $this->item['name']:'' );

$form   ->field("level_discount")
        ->label($this->lang->translate('Discount'))
        ->addClass('inputtext')
        ->autocomplete("off")
        ->value( !empty($this->item['discount']) ? $this->item['discount']:'' );
        
# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'customers/save_level"></form>';

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