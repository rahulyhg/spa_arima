<?php

/* System */
$sub = array();
$sub[] = array('text' => 'รายละเอียดของบริษัท','key' => 'company','url' => URL.'settings/company');
$sub[] = array('text'=>'Dealer','key'=>'dealer','url'=>URL.'settings/dealer');
$sub[] = array('text'=>'ประเภทการจ่ายเงิน','key'=>'paytype','url'=>URL.'settings/paytype');
$sub[] = array('text' => 'โปรไฟล์','key' => 'my','url' => URL.'settings/my');

foreach ($sub as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sub[$key]);
}
if( !empty($sub)  ){
	$menu[] = array('text' => '', 'url' => URL.'settings/company', 'sub' => $sub);
}

/* Room */
$sub = array();
$sub[] = array('text'=>'ห้อง','key'=>'room','url'=>URL.'settings/rooms/');
$sub[] = array('text'=>'เตียง','key'=>'bed','url'=>URL.'settings/rooms/bed');

foreach ($sub as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sub[$key]);
}
if( !empty($sub)  ){
	$menu[] = array('text'=>'จัดการห้อง','sub' => $sub, 'url' => URL.'settings/rooms/');
}

/* Accounts */
$sub = array();
$sub[] = array('text'=>'แผนก','key'=>'department','url'=>URL.'settings/accounts/department');
$sub[] = array('text'=>'ตำแหน่ง','key' => 'position','url' => URL.'settings/accounts/position');
$sub[] = array('text'=>'พนักงาน','key' => 'employees','url' => URL.'settings/accounts/');
$sub[] = array('text'=>'ความสามารถ','key'=>'skill','url'=> URL.'settings/accounts/skill');

foreach ($sub as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sub[$key]);
}
if( !empty($sub)  ){
	$menu[] = array('text'=>'จัดการบัญชี','sub' => $sub, 'url' => URL.'settings/accounts/');
}

/* Customer */
$sub = array();
$sub[] = array('text'=>'ระดับ','key'=>'level','url'=>URL.'settings/customers/');

foreach ($sub as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sub[$key]);
}
if( !empty($sub)  ){
	$menu[] = array('text'=>'จัดการลูกค้า','sub' => $sub, 'url' => URL.'settings/customers/');
}