<?php 

$form = new Form();
$form = $form->create()
	// set From
	->elem('div');

$form   ->field("note")
        ->type('textarea')
        ->name('note[]')
        ->label( 'หมายเหตุ' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

echo $form->html();