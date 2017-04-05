<?php 



$this->tab = isset($this->tab)? $this->tab: '';

$this->tabs = array();
$this->tabs[] = array('id'=>'services','name'=>'รายการซ่อมทั้งหมด', 'icon'=>'address-book-o');


$this->tabs_right = array();
$this->tabs_right[] = array('id'=>'files','name'=>'Files', 'icon'=>'file-o');
$this->tabs_right[] = array('id'=>'plans','name'=>'นัดหมาย', 'icon'=>'history');
$this->tabs_right[] = array('id'=>'notes','name'=>'Notes', 'icon'=>'comments-o');