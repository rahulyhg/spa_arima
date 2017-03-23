<?php

$title = 'Brand';

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert');

// ประเภท
$form 	->field("name")
    	->label('Name*')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['name'])? $this->item['name']:'' );

$form->field("notes")
    ->label('Note')
    ->type('textarea')
    ->autocomplete('off')
    ->addClass('inputtext')
    ->maxlength( 160 )
    ->attr('data-plugins', 'autosize')
    ->value( !empty($this->item['notes'])? $this->fn->q('text')->textarea($this->item['notes']):'' );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'brands/save"></form>';

# body
$arr['body'] = $form->html();

# title
if( !empty($this->item) ){
    $arr['title']= "Edit {$title}";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "New {$title}";
}

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">Save</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">Cancel</span></a>';

echo json_encode($arr);