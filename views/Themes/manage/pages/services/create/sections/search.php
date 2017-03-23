<?php 

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
    ->addClass('formSearch_newOrder form-large clearfix');

$form   ->hr('<h2 class="mbs">ค้นหา</h2>');

$form   ->field("q")
        ->placeholder('ชื่อลูกค้า/VIN(เลขตัวถัง)/เลขเครื่องยนต์/ป้ายทะเบียนรถ')
        ->autocomplete('off')
        ->addClass('inputtext js-search')
        ->note('<a class="mts clearfix fsl js-new-cus">ลูกค้าใหม่</a>')
        ->value('');

$form   ->submit()
        ->addClass('btn btn-blue')
        ->value('ค้นหา');

$search = $form->html();