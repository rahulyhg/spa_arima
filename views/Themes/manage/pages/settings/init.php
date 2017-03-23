<?php

/* System */
$sub = array();
$sub[] = array('text' => 'รายละเอียดของบริษัท','key' => 'company','url' => URL.'settings/company');
$sub[] = array('text'=>'Dealer','key'=>'dealer','url'=>URL.'settings/dealer');
$sub[] = array('text' => 'โปรไฟล์','key' => 'my','url' => URL.'settings/my');

foreach ($sub as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sub[$key]);
}
if( !empty($sub)  ){
	$menu[] = array('text' => '', 'url' => URL.'settings/company', 'sub' => $sub);
}

/* Accounts */
$sub = array();
$sub[] = array('text'=>'แผนก','key'=>'department','url'=>URL.'settings/accounts/department');
$sub[] = array('text'=>'ตำแหน่ง','key' => 'position','url' => URL.'settings/accounts/position');
$sub[] = array('text'=>'พนักงาน','key' => 'employees','url' => URL.'settings/accounts/');

foreach ($sub as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sub[$key]);
}
if( !empty($sub)  ){
	$menu[] = array('text'=>'จัดการบัญชี','sub' => $sub, 'url' => URL.'settings/accounts/');
}

/* */
/* Products */
/* */
$sub = array();
$sub[] = array('text'=>'Brands','key'=>'brands','url'=>URL.'settings/brands');
$sub[] = array('text'=>'Models','key'=>'models','url'=> URL.'settings/models');
$sub[] = array('text'=>'ชุดแต่ง','key'=>'accessory','url'=>URL.'settings/accessory');
$sub[] = array('text'=>'ตัวแทนจำหน่ายชุดแต่ง','key'=>'stores','url'=>URL.'settings/accessory/stores');

foreach ($sub as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sub[$key]);
}
if( !empty($sub)  ){
	$menu[] = array('text'=> 'จัดการสินค้า','sub' => $sub, 'url'=> URL.'settings/models' );
}

/* */
/* Booking Menu */
/* */
$sub = array();
// $sub[] = array('text'=>'สถานะ','key'=>'book_status','url'=> URL.'settings/booking/status');
// $sub[] = array('text'=>'เงื่อนไข','key'=>'conditions','url'=> URL.'settings/booking/conditions');
$sub[] = array('text'=>'แหล่งที่มาของลูกค้า','key'=>'cus_refer','url'=>URL.'settings/booking/cus_refer');

foreach ($sub as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sub[$key]);
}
if( !empty($sub)  ){
	$menu[] = array('text'=>'จัดการการจอง','sub'=>$sub );
}
