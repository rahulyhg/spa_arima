<?php 

$form = new Form();
$form = $form->create()
	// set From
	->elem('div');

$form   ->field("event_title")
        ->name('event[title]')
        ->label( 'เรื่อง' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->field("event_detail")
        ->type('textarea')
        ->name('event[detail]')
        ->label( 'รายละเอียด' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->field("event_when")
        ->type('date')
        ->name('event[when]')
        ->label( 'วันที่' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

echo $form->html();