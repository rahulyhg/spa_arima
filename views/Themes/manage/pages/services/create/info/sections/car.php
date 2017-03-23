<?php 

$form = new Form();
$form = $form->create()
	// set From
	->elem('div');

	
$fieldcar[] = array( 
    'id' => 'cus_prefix_name', 
    'name' => 'cus[prefix_name]', 
    'label' => '',
    'type' => 'select',
    'options' => $this->prefixName
);

$fieldcar[] = array( 
    'id' => 'cus_first_name', 
    'name' => 'cus[first_name]', 
    'label' => '',
);

$fieldcar[] = array( 
    'id' => 'cus_nickname', 
    'name' => 'cus[nickname]', 
    'label' => 'สี/Color',
);


$form   ->field("receiver_name")
        ->label('รถยนต์รุ่น/Model')
        ->text( $this->fn->uTableCell($fieldcar) );

$form   ->field("car_VIN")
        ->name('car[VIN]')
        ->label( 'VIN(เลขตัวถัง)' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->field("car_engine")
        ->name('car[engine]')
        ->label( 'เลขเครื่องยนต์' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form->hr('<div class="clearfix"></div>');

$form   ->field("car_license_plate")
        ->name('car[license_plate]')
        ->label( 'ป้ายทะเบียนรถ' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->field("car_mile")
        ->name('car[mile]')
        ->label( 'ไมล์รถ' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

echo $form->html();