<?php


#info
$info[] = array('key'=>'dashboard','text'=>$this->lang->translate('menu','Dashboard'),'link'=>$url.'dashboard','icon'=>'home');
// $info[] = array('key'=>'notifications','text'=>$this->lang->translate('menu','Notifications'),'link'=>$url.'notifications','icon'=>'bell-o');
// $info[] = array('key'=>'calendar','text'=>$this->lang->translate('menu','Calendar'),'link'=>$url.'calendar','icon'=>'calendar');
foreach ($info as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($info[$key]);
}
if( !empty($info) ){
	echo $this->fn->manage_nav($info, $this->getPage('on'));
}


#customer
$cus[] = array('key'=>'customers','text'=>$this->lang->translate('menu','Members'),'link'=>$url.'customers','icon'=>'address-card-o');
$cus[] = array('key'=>'employees','text'=>$this->lang->translate('menu','Employees'),'link'=>$url.'employees','icon'=>'user');
$cus[] = array('key'=>'masseuse','text'=>$this->lang->translate('menu','Masseuse'),'link'=>$url.'masseuse','icon'=>'user-circle-o');
foreach ($cus as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($cus[$key]);
}
if( !empty($cus)){
	echo $this->fn->manage_nav($cus, $this->getPage('on'));
}

#services
$sv[] = array('key'=>'package','text'=>$this->lang->translate('menu','Package'),'icon'=>'cubes','link'=>$url.'package');
//$this->lang->translate('menu','Discount') . ' & '. 
$sv[] = array('key'=>'promotions','text'=> $this->lang->translate('menu','Promotions'),'icon'=>'tags','link'=>$url.'promotions');
foreach ($sv as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sv[$key]);
}
if( !empty($sv)){
	echo $this->fn->manage_nav($sv, $this->getPage('on'));
}


#booking
/*$bok[] = array('key'=>'orders','text'=> $this->lang->translate('menu','Invoice'),'link'=>$url.'order','icon'=>'file-text-o');
$bok[] = array('key'=>'booking','text'=> $this->lang->translate('menu','Booking'),'link'=>$url.'booking','icon'=>'address-book-o');
foreach ($bok as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($bok[$key]);
}
if( !empty($bok)){
	echo $this->fn->manage_nav($bok, $this->getPage('on'));
}*/


$reports[] = array('key'=>'reports','text'=>$this->lang->translate('menu','Reports'),'link'=>$url.'reports','icon'=>'line-chart');
foreach ($reports as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($reports[$key]);
}
if( !empty($reports) ){
	echo $this->fn->manage_nav($reports, $this->getPage('on'));
}


$cog[] = array('key'=>'settings','text'=>$this->lang->translate('menu','Settings'),'link'=>$url.'settings','icon'=>'cog');
echo $this->fn->manage_nav($cog, $this->getPage('on'));


$pos[] = array('key'=>'pos','text'=>$this->lang->translate('menu','Pos'),'link'=>$url.'pos','icon'=>'television');
echo $this->fn->manage_nav($pos, $this->getPage('on'));