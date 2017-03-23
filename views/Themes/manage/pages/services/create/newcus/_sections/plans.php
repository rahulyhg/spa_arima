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

$form   ->field("note")
        ->type('textarea')
        ->name('note[]')
        ->label( 'หมายเหตุ' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->hr('<div class="clearfix">'.
    '<div class="lfloat"><a class="btn js-prev">กลับ</a></div>'.
    '<div class="rfloat"><a class="btn btn-blue js-next" data-type="save">บันทึก</a></div>'.
'</div>');

echo $form->html();