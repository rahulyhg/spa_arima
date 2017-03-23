<?php

$form = new Form();
$form = $form 	->create()
    			->elem('div');

$form   ->field("book_model_id")
        ->name('book[model_id]')
        ->label('รถยนต์รุ่น/Model')
        ->addClass('inputtext js-data')
        ->attr('selector', 'model')
        ->select( $this->models, 'id', 'name', false );

$form   ->field("book_pro_id")
        ->name('book[pro_id]')
        ->label('&nbsp;')
        ->attr('product', 'item')
        ->autocomplete('off')
        ->addClass('inputtext js-data')
        ->select( array() );

$form   ->field("book_color")
        ->name('book[color]')
        ->label('สี/Color')
        ->autocomplete('off')
        ->addClass('inputtext js-data')
        ->select( array() );

// $form   ->field("book_link_select_car")
//         ->text( '<div style="margin-top: 22px;"><a class="btn"><i class="icon-car"></i></a></div>' );

$form   ->hr('<div class="clearfix"></div>');


$form   ->field("book_net_price")
        ->name('book[net_price]')
        ->label('ราคาจำหน่ายสุทธิ/Net selling price')
        ->autocomplete('off')
        ->addClass('inputtext js-number')
        ->placeholder('')
        ->attr('data-name', 'carprice')
        ->value('');

$form   ->field("book_deposit")
        ->name('book[deposit]')
        ->label('จำนวนเงินมัดจำ/Deposit')
        ->autocomplete('off')
        ->addClass('inputtext js-number')
        ->attr('data-name', 'deposit')
        ->placeholder('')
        ->value('');

$form   ->field("book_due")
        ->name('book[due]')
        ->type('date')
        ->label('กำหนดส่งมอบรถโดยประมาณ/Estimated delivery')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value('');

$section .= $form->html();