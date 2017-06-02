<?php

$url = URL;

echo '<div class="navigation-main-bg js-navigation-trigger"></div>';

echo '<nav class="navigation-main" role="navigation">';

	// echo '<a class="btn btn-icon js-navigation-trigger"><i class="icon-bars"></i></a>';

echo '<div class="navigation-main-content">';

$image = '';
if( !empty($this->me['image_url']) ){
	$image = '<div class="avatar lfloat mrm"><img class="img" src="'.$this->me['image_url'].'" alt="'.$this->me['fullname'].'"></div>';
}
else{
	$image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
}

echo '<div class="welcome-box"><div class="anchor clearfix">'.$image.'<div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">'.$this->me['fullname'].'</div><span class="subname">'.$this->me['dep_name'].'</span></div></div></div></div>';


include WWW_VIEW. 'Layouts/navigation-main.php';


echo '</div>';
/* end: navigation-main-content*/

echo '<div class="navigation-main-footer">';


	echo '<ul class="navigation-list"><li><a data-plugins="dialog" href="'.URL.'logout/admin"><i class="icon-power-off"></i>Log Out</a></li></ul>';

	echo '</div>';


echo '</nav>';