<?php

$header = '<span class="fwb">ใบสั่งจองรถยนต์ / ใบยืนยันข้อตกลงการขาย</span>'.
			' วันเดือนปีที่จอง '.date('Y-m-d').' เล่มที่ 13'.
			' เลขที่ 13';

$form = new Form();
$form = $form 	->create()
    			->addClass('form-insert clearfix')
    			->elem('div');

$form 	->hr('<div class="text-center">'.$header.'</div>');


$company = '<fieldset id="book_company_fieldset" class="control-group">'.
			'<label for="book_company" class="control-label">บริษัท (Dealer Name)
			</label>'.
			'<div class="controls"><input id="book_company" autocomplete="off" class="inputtext" type="text" name="book_company"><div class="notification"></div></div></fieldset>';
$company.= '<fieldset id="book_emp_id_fieldset" class="control-group">'.
			'<label for="book_emp_id" class="control-label">ที่ปรึกษาการขาย (Sales Consultant)
			</label>'.
			'<div class="controls">'.$this->me['name'].'<div class="notification"></div></div></fieldset>';

$company.= '<fieldset id="book_emp_phone_fieldset" class="control-group">'.
			'<label for="book_emp_phone" class="control-label">โทรศัพท์ (Mobile)
			</label>'.
			'<div class="controls">'.$this->me['phone_number'].'<div class="notification"></div></div></fieldset>';

$cus = '';
foreach ($this->customers['lists'] as $key => $value) {
    
    $selected = '';
    if( !empty($this->item['cus_id']) ){
        if( $this->item['cus_id']==$value['id'] ){
            $selected = ' selected="1"';
        }
    }

    $cus .= '<option'.$selected.' value="'.$value['id'].'">'.$value['fullname'].'</option>';
}
$cus = '<select class="inputtext" name="book_cus_id">'.$cus.'</select>';

$customer = '<fieldset id="book_cus_name_fieldset" class="control-group">'.
			'<label for="book_cus_name" class="control-label">ชื่อลูกค้า
			</label>'.
			'<div class="controls">'.$cus.'<div class="notification"></div></div></fieldset>';

$customer.= '<fieldset id="book_cus_card_id_fieldset" class="control-group">'.
			'<label for="book_cus_card_id" class="control-label">เลขบัตรประชาชน
			</label>'.
			'<div class="controls">1529900668255<div class="notification"></div></div></fieldset>';

$customer.= '<fieldset id="book_cus_phone_fieldset" class="control-group">'.
			'<label for="book_cus_phone" class="control-label">โทรศัพท์ที่ทำงาน
			</label>'.
			'<div class="controls"><input id="book_cus_phone" autocomplete="off" class="inputtext" type="text" name="book_cus_phone"><div class="notification"></div></div></fieldset>';

$customer.= '<fieldset id="book_cus_mobile_fieldset" class="control-group">'.
			'<label for="book_cus_mobile" class="control-label">มือถือ
			</label>'.
			'<div class="controls">088-226-7030<div class="notification"></div></div></fieldset>';

$form 	->hr('<div class="span5">'.$company.'</div><div class="span5">'.$customer.'</div>');
		

$book = '<fieldset class="control-group">'.
 		'<label class="control-label">รายละเอียดการจองรถ/Detail'.
        '</label>'.
        '<label class="control-label">วันที่จ่ายเงินมัดจำ(จอง)'.
        '</label>'.
        '<div class="controls">'.
            '<input class="inputtext js-input" autocomplete="off" type="text" name="date" value="">'.
            '<div class="notification"></div>'.
        '</div>'.
    '</fieldset>';

$car = '';
foreach ($this->car['lists'] as $key => $value) {
    $car .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
}
$car = '<select class="inputtext" name="book_car_id">'.$car.'</select>';

$book.= '<fieldset id="book_cus_name_fieldset" class="control-group">'.
			'<label for="book_cus_name" class="control-label">รถยนต์รุ่น (Model)
			</label>'.
			'<div class="controls">'.$car.'<div class="notification"></div></div></fieldset>';

$color = '';
foreach ($this->colors['lists'] as $key => $value) {
	$color.= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
}
$color = '<select class="inputtext" name="color_id">'.$color.'</select>';

$book.='<fieldset id="book_cus_name_fieldset" class="control-group">'.
			'<label for="color_id" class="control-label">สี (Color)
			</label>'.
			'<div class="controls">'.$color.'<div class="notification"></div></div></fieldset>';

$book.= '<fieldset id="book_car_year" class="control-group">'.
			'<label for="book_car_year" class="control-label">ปีที่ผลิต
			</label>'.
			'<div class="controls">ปีที่ผลิต<div class="notification"></div></div></fieldset>';

$book.= '<fieldset id="book_car_year" class="control-group">'.
			'<label for="book_car_year" class="control-label">ปีที่ผลิต
			</label>'.
			'<div class="controls">ปีที่ผลิต<div class="notification"></div></div></fieldset>';

$book.= '<fieldset id="car_price" class="control-group">'.
			'<label for="car_price" class="control-label">ราคาจำหน่ายสุทธิ (Net selling price)
			</label>'.
			'<div class="controls">112312312321<div class="notification"></div></div></fieldset>';

$book.= '<fieldset id="book_price" class="control-group">'.
			'<label for="book_price" class="control-label">จำนวนเงินมัดจำ (จอง)
			</label>'.
			'<div class="controls"><input id="book_price" autocomplete="off" class="inputtext" type="text" name="book_price"><div class="notification"></div></div></fieldset>';

$book.= '<fieldset id="book_car_date" class="control-group">'.
			'<label for="book_car_date" class="control-label">กำหนดส่งมอบรถโดยประมาณ
			</label>'.
			'<div class="controls"><input id="book_car_date" autocomplete="off" class="inputtext" type="date" name="book_price"><div class="notification"></div></div></fieldset>';

$book.= '<fieldset id="book_car_date" class="control-group">'.
			'<label for="book_car_date" class="control-label">ประเภทเงินมัดจำ(จอง)
			</label><div class="controls"><div class="notification"></div></div></fieldset></fieldset>';

$form 	->hr('<div class="span5">'.$book.'</div>');

// $form 	->field("book_company")
// 		->label("บริษัท")
//         ->autocomplete('off')
//         ->addClass('inputtext')
//         ->placeholder('')
//         ->value( !empty($this->item['company']) ? $this->item['company']:'' );

// $form 	->field("book_emp_id")
// 		->label("ที่ปรึกษาการขาย")
// 		->autocomplete('off')
// 		->addClass('inputtext')
// 		->placeholder('')
// 		->value( !empty($this->item['emp_id']) ? $this->item['emp_id']:'' );

$form   ->submit()
        ->addClass("btn-submit btn btn-blue rfloat")
        ->value("บันทึก");

echo '<div class="pal">'.$form->html().'<div>';