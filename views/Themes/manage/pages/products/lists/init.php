<?php


$title[] = array('key'=>'status', 'text'=>'รถยนต์รุ่น/Model');
$title[] = array('key'=>'name', 'text'=>'name', 'sort'=>'name');
$title[] = array('key'=>'qty', 'text'=>'ขนาดเครื่องยนต์');
$title[] = array('key'=>'qty', 'text'=>'ปีที่ผลิต MFY');
$title[] = array('key'=>'price', 'text'=>'ราคา');
//$title[] = array('key'=>'qty', 'text'=>'จอง');
$title[] = array('key'=>'qty', 'text'=>'คงเหลือ', 'sort'=>'qty');
$title[] = array('key'=>'date', 'text'=>'แก้ไขล่าสุด');
$title[] = array('key'=>'action', 'text'=>'Action');
// $title[] = array('key'=>'date', 'text'=>'Last update', 'sort'=>'updated');

$this->tabletitle = $title;
$this->getURL =  URL.'products/';