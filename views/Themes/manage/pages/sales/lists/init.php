<?php

$title[] = array('key'=>'name', 'text'=>'Sales', 'sort'=>'name');
$title[] = array('key'=>'content', 'text'=>'ตำแหน่ง','sort'=>'pos_name');
$title[] = array('key'=>'status', 'text'=>'ยอดจอง');
$title[] = array('key'=>'status', 'text'=>'ยอดขาย');
$title[] = array('key'=>'status', 'text'=>'ยกเลิก');


$this->tabletitle = $title;
$this->getURL =  URL.'sales/';