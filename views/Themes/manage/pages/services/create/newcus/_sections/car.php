<?php 

$form = new Form();
$form = $form->create()
	// set From
	->elem('div');

	
$fieldcar[] = array( 
    'id' => 'car_model', 
    'name' => 'car[model]', 
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
    'id' => 'cus_color', 
    'label' => 'สี',
    'name' => 'car[color]', 
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

$form   ->field("car_license_plate")
        ->name('car[license_plate]')
        ->label( 'ป้ายทะเบียนรถ' )
        ->autocomplete('off')
        ->attr('data-name', 'car_license_plate')
        ->addClass('inputtext')
        ->value('');

$form   ->field("car_mile")
        ->name('car[mile]')
        ->label( 'ไมล์รถ' )
        ->attr('data-name', 'car_mile')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->hr('<div class="clearfix">'.
    '<div class="lfloat"><a class="btn js-prev">กลับ</a></div>'.
    '<div class="rfloat"><a class="btn btn-blue js-next" data-type="car">ต่อไป</a></div>'.
'</div>');

echo $form->html();