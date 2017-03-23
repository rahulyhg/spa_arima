<?php

$form = new Form();
$form = $form->create()
	// set From
	->elem('div');


$fieldname = array();
$fieldname[] = array( 
    'id' => 'cus_prefix_name', 
    'name' => 'cus[prefix_name]', 
    'label' => 'คำนำหน้าชื่อ',
    'type' => 'select',
    'attr' => array('data-name'=>'cus_prefix_name'),
    'options' => $this->prefixName
);

$fieldname[] = array( 
    'id' => 'cus_first_name', 
    'name' => 'cus[first_name]', 
    'addClass' => 'js-search-cus',
    'attr' => array('data-name'=>'cus_first_name'),
    'label' => 'ชื่อ',
);

$fieldname[] = array( 
    'id' => 'cus_last_name', 
    'name' => 'cus[last_name]', 
    'label' => 'นามสกุล',
    'attr' => array('data-name'=>'cus_last_name'),
);

$fieldname[] = array( 
    'id' => 'cus_nickname', 
    'name' => 'cus[nickname]', 
    'label' => 'ชื่อเล่น',
    'attr' => array('data-name'=>'cus_nickname'),
);

$form   ->field("cus_name")
        ->label('ข้อมูลเจ้าของรถ')
        ->text( '<div class="u-table"><div class="u-table-row">'.$this->fn->uTableCell($fieldname).'</div></div>' );

$form   ->field("cus_phone")
        ->name('cus[phone]')
        ->label( 'เบอร์มือถือ' )
        ->autocomplete('off')
        ->attr('data-name', 'cus_phone')
        ->addClass('inputtext')
        ->value('');

/*$form   ->field("cus_tel")
        ->name('cus[tel]')
        ->label( 'โทรศัพท์บ้าน/ทำงาน' )
        ->autocomplete('off')
        ->attr('data-name', 'cus_tel')
        ->addClass('inputtext')
        ->value('');
*/
$form   ->field("cus_lineID")
        ->name('cus[lineID]')
        ->label( 'Line ID' )
        ->autocomplete('off')
        ->attr('data-name', 'cus_lineID')
        ->addClass('inputtext')
        ->value('');

// ที่อยู่
$address = array( 0=> 

	array( 0 => 
		array(
			'id' => 'address_number', 
		    'name' => 'address[number]', 
		    'label' => 'บ้านเลขที่',
		),
		array(
			'id' => 'address_mu', 
		    'name' => 'address[mu]', 
		    'label' => 'หมู่ที่',
		),
		array(
			'id' => 'address_village', 
		    'name' => 'address[village]', 
		    'label' => 'หมู่บ้าน',
		),
		array(
			'id' => 'address_alley', 
		    'name' => 'address[alley]', 
		    'label' => 'ซอย',
		),
	),

	array( 0 => 
		array(
			'id' => 'address_street', 
		    'name' => 'address[street]', 
		    'label' => 'ถนน',
		),
		array(
			'id' => 'address_district', 
		    'name' => 'address[district]', 
		    'label' => 'แขวง/ตำบล',
		),
		array(
			'id' => 'address_amphur', 
		    'name' => 'address[amphur]', 
		    'label' => 'เขต/อำเภอ'
		),
	),

	array( 0 => 
		array(
			'id' => 'address_city', 
		    'name' => 'address[city]', 
		    'label' => 'จังหวัด',
		    'type' => 'select',
		    'options' => $this->city['lists'],
		    'value' => 1
		),
		array(
			'id' => 'address_zip', 
		    'name' => 'address[zip]', 
		    'label' => 'รหัสไปรษณีย์'
		),
	),
);

$form   ->field("cus_address")
        ->name('cus[address]')
        ->label('ที่อยู่')
        ->text( '<div class="table-address-wrap">'. $this->fn->uTableAddress($address).'</div>' );

$form   ->hr('<div class="clearfix">'.
	'<div class="rfloat"><a class="btn btn-blue js-next" data-type="owner">ต่อไป</a></div>'.
'</div>');

echo $form->html();