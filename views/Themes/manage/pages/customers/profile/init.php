<?php 

$this->tab = isset($this->tab)? $this->tab: '';

$this->tabs = array();
$this->tabs[] = array('id'=>'car','name'=>'รถ', 'icon'=>'car');
$this->tabs[] = array('id'=>'repair','name'=>'ประวัติการซ่อม', 'icon'=>'wrench');

$this->tabs_right = array();
$this->tabs_right[] = array('id'=>'files','name'=>'Files', 'icon'=>'file-o');
$this->tabs_right[] = array('id'=>'plans','name'=>'นัดหมาย', 'icon'=>'history');
$this->tabs_right[] = array('id'=>'notes','name'=>'Notes', 'icon'=>'comments-o');