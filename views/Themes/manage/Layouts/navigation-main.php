<?php

$url = URL;

$image = '';
if( !empty($this->me['image_url']) ){
	$image = '<div class="avatar lfloat mrm"><img class="img" src="'.$this->me['image_url'].'" alt="'.$this->me['fullname'].'"></div>';
}
else{
	$image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
}

echo '<div class="navigation-main-bg navigation-trigger"></div><nav class="navigation-main" role="navigation"><a class="btn btn-icon navigation-trigger"><i class="icon-bars"></i></a>';

echo '<div class="navigation-main-header"><div class="anchor clearfix">'.$image.'<div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">'.$this->me['fullname'].'</div><span class="subname">'.$this->me['dep_name'].'</span></div></div></div></div>';

echo '<div class="navigation-main-content">';

#info
$info[] = array('key'=>'dashboard','text'=>'Dashboard','link'=>$url.'dashboard','icon'=>'home');
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
foreach ($cus as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($cus[$key]);
}
if( !empty($cus)){
	echo $this->fn->manage_nav($cus, $this->getPage('on'));
}

#booking
$bok[] = array('key'=>'orders','text'=> $this->lang->translate('menu','Invoice'),'link'=>$url.'order','icon'=>'file-text-o');
$bok[] = array('key'=>'booking','text'=> $this->lang->translate('menu','Booking'),'link'=>$url.'booking','icon'=>'address-book-o');
foreach ($bok as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($bok[$key]);
}
if( !empty($bok)){
	echo $this->fn->manage_nav($bok, $this->getPage('on'));
}

#services
$sv[] = array('key'=>'packet','text'=>$this->lang->translate('menu','Packet'),'icon'=>'cubes','link'=>$url.'packet');
$sv[] = array('key'=>'promotions','text'=> $this->lang->translate('menu','Discount') . ' & '. $this->lang->translate('menu','Promotions'),'icon'=>'tags','link'=>$url.'promotions');
foreach ($sv as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($sv[$key]);
}
if( !empty($sv)){
	echo $this->fn->manage_nav($sv, $this->getPage('on'));
}

#reports
// $reports[] = array('key'=>'tasks','text'=>$this->lang->translate('menu','Tasks'),'link'=>$url.'tasks','icon'=>'check-square-o');
$reports[] = array('key'=>'reports','text'=>$this->lang->translate('menu','Reports'),'link'=>$url.'reports','icon'=>'line-chart');
foreach ($reports as $key => $value) {
	if( empty($this->permit[$value['key']]['view']) ) unset($reports[$key]);
}
if( !empty($reports) ){
	echo $this->fn->manage_nav($reports, $this->getPage('on'));
}


$cog[] = array('key'=>'settings','text'=>$this->lang->translate('menu','Settings'),'link'=>$url.'settings','icon'=>'cog');
echo $this->fn->manage_nav($cog, $this->getPage('on'));

	echo '</div>';

	echo '<div class="navigation-main-footer">';


echo '<ul class="navigation-list">'.

	'<li class="clearfix">'.
		'<div class="navigation-main-footer-cogs">'.
			'<a data-plugins="dialog" href="'.URL.'logout/admin"><i class="icon-power-off"></i><span class="visuallyhidden">Log Out</span></a>'.
			// '<a href="'.URL.'logout/admin"><i class="icon-cog"></i><span class="visuallyhidden">Settings</span></a>'.
		'</div>'.
		'<div class="navigation-brand-logo clearfix"><img class="lfloat mrm" src="'.IMAGES.'logo/small.png">'.( !empty( $this->system['title'] ) ? $this->system['title']:'' ).'</div>'.
	'</li>'.
'</ul>';

echo '</div>';


echo '</nav>';