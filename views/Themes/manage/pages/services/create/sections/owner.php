<?php

$form = new Form();
$form = $form->create()
	// set From
	->elem('div');


$form   ->field("cus_name")
        ->label('ชื่อ')
        ->text( $this->fn->q('form')->fullname( !empty($this->item)?$this->item:array(), array('field_first_name'=>'cus[','field_last_name'=>']') ) );

$form   ->field("cus_birthday")
        ->label('วันเกิด')
        ->text( $this->fn->q('form')->birthday( array(), array('field_first_name'=>'cus[','field_last_name'=>']') ) );

$form   ->field("cus_card_id")
        ->label('หมายเลขบัตรประจำตัวประชาชน')
        ->name('cus[card_id]')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('');

$form   ->field("cus_address")
        ->name('cus[address]')
        ->label('ที่อยู่*')
        ->text( $this->fn->q('form')->address( array(), array('city' => $this->city, 'field_first_name'=>'cus[','field_last_name'=>']') ) );


// email
$form->hr( $this->fn->q('form')->contacts( 
    'email', array(), array( 'field_first_name'=>'cus[options][email]' )
) );

// email
$form->hr( $this->fn->q('form')->contacts( 
    'phone', array(), array( 'field_first_name'=>'cus[options][phone]' )
) );

// social
$form->hr( $this->fn->q('form')->contacts( 
    'social', array(), array( 'field_first_name'=>'cus[options][social]' )
) );

$section .= $form->html();