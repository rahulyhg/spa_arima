<?php

$title = 'Masseuse';

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
    ->style('horizontal')
	->addClass('form-insert');

$form   ->field("emp_address")
        ->name('emp[address]')
        ->label('ที่อยู่*')
        ->text( $this->fn->q('form')->address( !empty($this->item['address'])? $this->item['address']:array(), array( 'city' => $this->city ) ) );

$form   ->field("emp_phone_number")
        ->label('Phone number*')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['phone_number'])? $this->item['phone_number']:'' );

$form   ->field("emp_email")
        ->label('Email')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['email'])? $this->item['email']:'' );

$form   ->field("emp_line_id")
        ->label('Line ID')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['line_id'])? $this->item['line_id']:'' );

$form 	->field("emp_notes")
    	->label('Note')
    	->type('textarea')
    	->autocomplete('off')
    	->addClass('inputtext')
    	->attr('data-plugins', 'autosize')
    	->placeholder('')
    	->value( !empty($this->item['notes'])? $this->fn->q('text')->textarea($this->item['notes']):'' );

# set form
$arr['form'] = '<form class="js-submit-form" data-plugins="" method="post" action="'.URL. 'masseuse/update"></form>';

# body
$arr['body'] = $form->html();

# title
if( !empty($this->item) ){
    $arr['title']= "ข้อมูลการติดต่อ";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
    $arr['hiddenInput'][] = array('name'=>'section','value'=>'contact');
}
else{
    $arr['title']= "New {$title}";
}

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">Save</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">Cancel</span></a>';

$arr['width'] = 550;

echo json_encode($arr);