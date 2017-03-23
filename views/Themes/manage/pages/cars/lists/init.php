<?php


$title[] = array('key'=>'bookmark', 'text'=>'');
$title[] = array('key'=>'name', 'text'=>'ชื่อรถยนต์', 'sort'=>'pro_name');
$title[] = array('key'=>'status', 'text'=>'เลขทะเบียนรถยนต์', 'sort'=>'license_plate');
$title[] = array('key'=>'email', 'text'=>'ชื่อเจ้าของรถยนต์', 'sort'=>'cus_fullname');
$title[] = array('key'=>'email', 'text'=>'');
$title[] = array('key'=>'date', 'text'=>'ปรับปรุงล่าสุด', 'sort'=>'updated');

$this->tabletitle = $title;
$this->getURL =  URL.'cars/';