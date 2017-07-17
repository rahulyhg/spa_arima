<?php

$this->count_nav = 0;

/* System */
$sub = array();
$sub[] = array('text' => $this->lang->translate('Company'),'key' => 'company','url' => URL.'settings/company');
// $sub[] = array('text'=>'Dealer','key'=>'dealer','url'=>URL.'settings/dealer');
$sub[] = array('text' => $this->lang->translate('Profile'),'key' => 'my','url' => URL.'settings/my');
// $sub[] = array('text'=>$this->lang->translate('Rooms'), 'key'=>'rooms','url'=>URL.'settings/rooms/');

foreach ($sub as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sub[$key]);
}
if( !empty($sub) ){
	$this->count_nav+=count($sub);
	$menu[] = array('text' => '', 'url' => URL.'settings/company', 'sub' => $sub);
}

/* Room */
/*$sub = array();
$sub[] = array('text'=>'ห้อง','key'=>'room','url'=>URL.'settings/rooms/');
$sub[] = array('text'=>'เตียง','key'=>'bed','url'=>URL.'settings/rooms/bed');

foreach ($sub as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sub[$key]);
}
if( !empty($sub)  ){
	$menu[] = array('text'=>'จัดการห้อง','sub' => $sub, 'url' => URL.'settings/rooms/');
}*/

/* Accounts */
$sub = array();
$sub[] = array('text'=> $this->lang->translate('Department'),'key'=>'department','url'=>URL.'settings/accounts/department');
$sub[] = array('text'=> $this->lang->translate('Position'),'key' => 'position','url' => URL.'settings/accounts/position');
$sub[] = array('text'=> $this->lang->translate('Employees'),'key' => 'employees','url' => URL.'settings/accounts/');


foreach ($sub as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sub[$key]);
}
if( !empty($sub) ){
	$this->count_nav+=count($sub);
	$menu[] = array('text'=> $this->lang->translate('Accounts'),'sub' => $sub, 'url' => URL.'settings/accounts/');
}

$sub = array();
$sub[] = array('text'=> 'ความสามารถ','key'=>'skill','url'=> URL.'settings/masseuse/skill');
if( !empty($sub) ){
	$this->count_nav+=count($sub);
	$menu[] = array('text'=> 'พนง.บริการ','sub' => $sub, 'url' => URL.'settings/masseuse/');
}



/* Customer */
$sub = array();
$sub[] = array('text'=> $this->lang->translate('Level') ,'key'=>'level','url'=>URL.'settings/customers/level');
$sub[] = array('text'=> $this->lang->translate('Payment type'),'key'=>'paytype','url'=>URL.'settings/paytype');

foreach ($sub as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sub[$key]);
}
if( !empty($sub) ){
	$this->count_nav+=count($sub);
	$menu[] = array('text'=> $this->lang->translate('Customer'),'sub' => $sub, 'url' => URL.'settings/customers/');
}