<?php 

$this->tab = isset($this->tab)? $this->tab: '';

$this->tabs = array();
$this->tabs[] = array('id'=>'car','name'=>'ประวัติรถยนต์', 'icon'=>'car');
$this->tabs[] = array('id'=>'booking','name'=>'ประวัติการจอง', 'icon'=>'address-book-o');
$this->tabs[] = array('id'=>'repair','name'=>'ประวัติการซ่อม', 'icon'=>'wrench');

$this->tabs_right = array();
$this->tabs_right[] = array('id'=>'files','name'=>'Files', 'icon'=>'file-o');
$this->tabs_right[] = array('id'=>'plans','name'=>'นัดหมาย', 'icon'=>'history', 'active'=>1);
$this->tabs_right[] = array('id'=>'notes','name'=>'Notes', 'icon'=>'comments-o');