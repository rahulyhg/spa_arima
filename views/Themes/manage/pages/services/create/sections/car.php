<?php 

$form = new Form();
$form = $form->create()
	// set From
	->elem('div');

	
$fieldcar[] = array( 
    'id' => 'car_model_id', 
    'name' => 'car[model_id]', 
    'label' => '',
    'attr' => array('selector'=>'model'),
    'type' => 'select',
    'options' => $this->models
);

$fieldcar[] = array( 
    'id' => 'car_pro_id', 
    'name' => 'car[pro_id]', 
    'attr' => array('selector'=>'product'),
    'type' => 'select',
    'options' => array()
);

$fieldcar[] = array( 
    'id' => 'cus_color_id', 
    'label' => 'สี',
    'name' => 'car[color_id]', 
    'label' => 'สี/Color',
    'attr' => array('selector'=>'colorcar'),
    'type' => 'select',
    'options' => array()
);


$form   ->field("receiver_name")
        ->label('รถยนต์รุ่น/Model')
        ->text( $this->fn->uTableCell($fieldcar) );

$form   ->field("car_VIN")
        ->name('car[VIN]')
        ->label( 'VIN(เลขตัวถัง)' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->attr('data-name', 'car_VIN')
        ->value('');

$form   ->field("car_engine")
        ->name('car[engine]')
        ->label( 'เลขเครื่องยนต์' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->attr('data-name', 'car_engine')
        ->value('');

$form->hr('<div class="clearfix"></div>');

$form   ->field("car_plate")
        ->name('car[plate]')
        ->label( 'ป้ายทะเบียนรถ' )
        ->autocomplete('off')
        ->attr('data-name', 'car_plate')
        ->addClass('inputtext')
        ->value('');

$form   ->field("car_red_plate")
        ->name('car[red_plate]')
        ->label( 'ป้ายแดง' )
        ->autocomplete('off')
        ->attr('data-name', 'car_red_plate')
        ->addClass('inputtext')
        ->value('');

$form   ->field("car_mile")
        ->name('car[mile]')
        ->label( 'ไมล์รถ' )
        ->attr('data-name', 'car_mile')
        ->autocomplete('off')
        ->addClass('inputtext has-edit')
        ->value('');


$section .= $form->html();