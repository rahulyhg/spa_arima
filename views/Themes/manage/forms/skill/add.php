<?php

$title = 'ความสามารถ';

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert');

$form   ->field("skill_type")
        ->label($this->lang->translate('Type'))
        ->addClass('inputtext')
        ->autocomplete("off")
        ->select( $this->type )
        ->value( !empty($this->item['type']) ? $this->item['type']:'' );

$form   ->field("skill_name")
        ->label($this->lang->translate('Name'))
        ->addClass('inputtext')
        ->required(true)
        ->autocomplete("off")
        ->value( !empty($this->item['name']) ? $this->item['name']:'' );
        
# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'employees/save_skill"></form>';

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