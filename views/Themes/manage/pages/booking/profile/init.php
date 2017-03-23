<?php 


$this->tabs = array();
// $a[] = array('id'=>'d','name'=>'สถานะ');
// $a[] = array('id'=>'s','name'=>'ประกันภัย');
$this->tabs[] = array('id'=>'accessory','name'=>'อุปกรณ์ตกแต่ง', 'icon'=>'cubes');
$this->tabs[] = array('id'=>'conditions','name'=>'เงื่อนไขการชำระเงิน', 'icon'=>'credit-card');
// $this->tabs[] = array('id'=>'activity','name'=>'Activity');

// $a[] = array('id'=>'s','name'=>'นัดหมาย');
// $a[] = array('id'=>'s','name'=>'Files');
// $a[] = array('id'=>'s','name'=>'Notes');



$this->tabs_rigth = array();

$this->tabs_rigth[] = array('id'=>'insurance','name'=>'ประกันภัย', 'active'=>1, 'icon'=>'heart');
$this->tabs_rigth[] = array('id'=>'files','name'=>'Files', 'icon'=>'file-o');
$this->tabs_rigth[] = array('id'=>'plans','name'=>'นัดหมาย', 'icon'=>'history');
$this->tabs_rigth[] = array('id'=>'notes','name'=>'Notes', 'icon'=>'comments-o');