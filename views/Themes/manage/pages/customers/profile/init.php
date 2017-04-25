<?php 

$this->tab = isset($this->tab)? $this->tab: '';

$this->tabs = array();
$this->tabs[] = array('id'=>'services','name'=>'ประวัติเข้ารับบริการ', 'icon'=>'handshake-o');

$this->tabs_right = array();
$this->tabs_right[] = array('id'=>'files','name'=>'Files', 'icon'=>'file-o');
$this->tabs_right[] = array('id'=>'plans','name'=>'นัดหมาย', 'icon'=>'history', 'active'=>1);
$this->tabs_right[] = array('id'=>'notes','name'=>'Notes', 'icon'=>'comments-o');