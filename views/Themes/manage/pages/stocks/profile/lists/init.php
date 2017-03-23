<?php

$this->tabletitle = array();
$this->tabletitle[] = array('key'=>'name', 'text'=>'รถยนต์รุ่น/Model');

$this->tabletitle[] = array('key'=>'qty', 'text'=>'ปี');
$this->tabletitle[] = array('key'=>'price', 'text'=>'ราคา');

$this->tabletitle[] = array('key'=>'status', 'text'=>'จอง');
$this->tabletitle[] = array('key'=>'status', 'text'=>'คงเหลือ');
$this->tabletitle[] = array('key'=>'status', 'text'=>'รวม');
$this->tabletitle[] = array('key'=>'status', 'text'=>'สั่งเพิ่ม');
// 
// $this->tabletitle[] = array('key'=>'actions', 'text'=>'');

$this->getURL =  URL.'stocks/'.$this->item['id'].'?model='.$this->item['id'];