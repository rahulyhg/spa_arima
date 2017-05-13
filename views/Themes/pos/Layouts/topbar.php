<?php 

$this->nav = array();
$this->nav[] = array('id'=>'orders','name'=> $this->lang->translate('menu','Orders'), 'icon'=>'file-text-o','url'=>URL.'pos/orders');
$this->nav[] = array('id'=>'booking','name'=> $this->lang->translate('menu','Booking'), 'icon'=>'address-book-o','url'=>URL.'pos/booking');
$this->nav[] = array('id'=>'members','name'=> $this->lang->translate('menu','Members'), 'icon'=>'address-card-o','url'=>URL.'pos/members');
$this->nav[] = array('id'=>'queue','name'=> $this->lang->translate('menu','masseuse'), 'icon'=>'user-circle-o','url'=>URL.'pos/queue');

// $this->nav[] = array('id'=>'orders','name'=> $this->lang->translate('menu','Service Changes'), 'icon'=>'file-text-o','url'=>URL.'pos');
// $this->nav[] = array('id'=>'orders','name'=> $this->lang->translate('menu','Promotions'), 'icon'=>'file-text-o','url'=>URL.'pos');

$pageNav = '';
foreach ($this->nav as $key => $value) {

	$cls = '';

	if( $this->getPage('on')==$value['id'] ){
		$cls .= !empty($cls) ? ' ':'';
		$cls .= 'active';
	}
	
	$countVal = '';
	if( !empty($value['count']) ){
		$cls .= !empty($cls) ? ' ':'';
		$cls .= 'hasCount';

		$countVal = $value['count'];
	}

	$cls = !empty($cls) ? ' class="'.$cls.'"':'';

	$pageNav .= '<li id="global-nav-'.$value['id'].'" '.$cls.' data-global-action="'.$value['id'].'"><a href="'.$value['url'].'" data-nav="'.$value['id'].'"><i class="icon-'.$value['icon'].'"></i><strong>'.$value['name'].'</strong>'.'<span class="mls countVal">('.$countVal.')</span>'.'</a></li>';
}

$pageNavR = '';

$pageNavR .= '<li class="headerClock">'.
	'<div class="headerClock-inner">'.
		'<div class="time"></div>'.
		'<div class="date"></div>'.
	'</div>'.
'</li>';

/*$pageNavR .= '<li class="lbtn">'.
	'<span class="gbtn"><a class="btn btn-red"><i class="icon-plus mrs"></i><span>New Order</span></a></span>'.
'</li>';*/

// $pageNavR .= '<li class="divider"></li>';


$imageAvatar = '';
if( !empty($this->me['image_url']) ){
	$imageAvatar = '<div class="avatar lfloat size32 headerAvatar"><img class="img" src="'.$this->me['image_url'].'"></div>';
	$imageAvatarBig = '<div class="avatar lfloat headerAvatar mrm"><img class="img" src="'.$this->me['image_url'].'"></div>';
}
else{
	$imageAvatar = '<div class="avatar lfloat size32 no-avatar"><div class="initials"><i class="icon-user"></i></div></div>';
	$imageAvatarBig = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
}


$pageNavR .= '<li class="uiToggle headerAvatarWrap">'.
    '<a data-plugins="toggleLink">'.$imageAvatar.'</a>'.

    '<div class="uiToggleFlyout uiToggleFlyoutRight uiToggleFlyoutPointer" id="accountSettingsFlyout"><ul role="menu" class="uiMenu">'.
            '<li class="menuItem head"><a class="itemAnchor" href="#"><span class="itemLabel"><div class="clearfix"><div class="anchor"><div class="clearfix">'.$imageAvatarBig.'<div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">'.$this->me['fullname'].'</div><div class="fcg">'.$this->lang->translate('menu','Profile').'</div></div></div></div></div></div></span></a></li>'.

            /*<li class="menuItemDivider" role="separator"></li>

            <li class="menuItem"><a class="itemAnchor" href="http://localhost/events/manage/index.php"><span class="itemLabel">จัดการระบบ</span></a></li>*/

            '<li class="menuItemDivider" role="separator"></li>'.
            
            '<li class="menuItem"><a class="itemAnchor" href="#"><span class="itemLabel">'.$this->lang->translate('menu','Settings').'</span></a></li>'.

            '<li class="menuItem"><a class="itemAnchor" data-plugins="dialog" href="'.URL.'logout/admin"><span class="itemLabel">'.$this->lang->translate('menu','Sign Out').'</span></a></li>'.
        '</ul></div>'.

'</li>';

$image_url = $this->getPage('image_url');

echo '<div id="header-primary" class="topbar"><div class="global-nav clearfix">';

		echo '<h1 class="topbar-logo">'.
			'<img src="'.$image_url.'" />'.
			'<span class="visuallyhidden"></span>'.
		'</h1>';

		echo '<div class="clearfix">';
		echo '<ul id="pageNav" class="clearfix lfloat js-global-actions">'.$pageNav.'</ul>';

		echo '<ul class="clearfix rfloat nav mrl">'.$pageNavR.'</ul>';
		echo '</div>';
		
echo '</div></div>';

if( !empty($this->topbar['back_url']) ){
	
	if( is_array($this->topbar['back_url']) ){
		echo '<a class="m-menu-toggle icon" href="'.$this->topbar['back_url']['url'].'"><i class="'.$this->topbar['back_url']['icon'].'"></i></a>';
	}
	else{

		echo '<a class="m-menu-toggle icon" href="'.$this->topbar['back_url'].'"><i class="icon-arrow-left"></i></a>';
	}
}
else{

	echo '<a class="m-menu-toggle js-navigation-trigger"><span class="m-menuicon-bread m-menuicon-bread-top"><span class="m-menuicon-bread-crust m-menuicon-bread-crust-top"></span></span><span class="m-menuicon-bread m-menuicon-bread-bottom"><span class="m-menuicon-bread-crust m-menuicon-bread-crust-bottom"></span></span></a>';
}