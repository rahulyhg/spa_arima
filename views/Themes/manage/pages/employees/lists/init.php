<?php
//print_r($this->tabletitle); die;

$title = array(
	0 =>   
	  array('key'=>'name', 'text'=>'ชื่อ-นามสกุล', 'sort'=>'first_name')

	, array('key'=>'status', 'text'=>'แผนก', 'sort'=>'nickname')
	, array('key'=>'status', 'text'=>'ตำแหน่ง', 'sort'=>'nickname')

	, array('key'=>'phone', 'text'=>'เบอร์โทร')
	, array('key'=>'phone', 'text'=>'Line ID')
	, array('key'=>'date', 'text'=>'เข้าใช้งานล่าสุด')
	
);


$this->tabletitle = $title;

$this->getURL =  URL.'employees/';