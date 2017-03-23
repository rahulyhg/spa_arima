<?php

$form = new Form();
$form = $form->create()
		->url(URL."me/updated/basic?run=1")
		->addClass('js-submit-form form-insert')
		->method('post');

$form   ->field("emp_first_name")
        ->label('ชื่อ-นามสกุล')
        ->text( $this->fn->q('form')->fullname( $this->me, array('field_first_name'=>'emp_') ) );

$form  	->field("emp_email")
		->label('อีเมล')
		->addClass('inputtext')
		->autocomplete("off")
		->value( !empty($this->me['email']) ? $this->me['email']:''  );

$form  	->field("emp_phone_number")
		->label('เบอร์โทรศัพท์')
		->addClass('inputtext')
		->autocomplete("off")
		->value( !empty($this->me['phone_number']) ? $this->me['phone_number']:''   );

$form   ->field("emp_line_id")
        ->label('LineID')
        ->addClass('inputtext')
        ->autocomplete("off")
        ->value( !empty($this->me['line_id']) ? $this->me['line_id']:'' );

$a = array();
$a[] = array('id'=>'light', 'name'=>'Light');
$a[] = array('id'=>'dark', 'name'=>'Dark');
$a[] = array('id'=>'blue', 'name'=>'Blue');
$a[] = array('id'=>'green', 'name'=>'Green');

$mode = '';
if( empty($this->me['mode']) ) $this->me['mode'] = 'word';
foreach ($a as $key => $value) {
    
    $check = $this->me['mode']==$value['id'] ? ' checked="1"':'';
    $mode .= '<li><label class="radio"><input type="radio" name="emp_mode" value="'.$value['id'].'"'.$check.' />'.$value['name'].'</label></li>';
}

$form   ->field("emp_mode")
        ->label('ธีมระบบ')
        ->text( '<ul>'.$mode.'</ul>' );

$form  	->submit()
		->addClass("btn-submit btn btn-blue")
		->value("บันทึก");

echo $form->html();