<?php

$form = new Form();
$form = $form 	->create()
				->style('table')
    			->elem('div');

$form   ->field("book_created")
        ->name('book[created]')
		->type('date')
        ->label('วัน/เดือน/ปี')
        ->autocomplete('off')
        ->attr('data-plugins', 'datepicker')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( date('Y-m-d') );

echo $form->html();