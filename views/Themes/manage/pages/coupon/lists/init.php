<?php

$url = URL. "coupon/";

$title = array(
	array(
	0 =>   array('key'=>'ID', 'text'=>'Code', 'sort'=>'code','rowspan'=>2)
		 , array('key'=>'name', 'text'=>'Package', 'rowspan'=>2)

		 , array('key'=>'date', 'text'=>'Expired Date', 'sort'=>'start_date', 'rowspan'=>2)
		 , array('key'=>'price', 'text'=>'Price', 'sort'=>'price', 'rowspan'=>2)

		 , array('key'=>'status', 'text'=>'จำนวน','colspan'=> 3)

		 , array('key'=>'status', 'text'=>'สถานะ','rowspan'=>2)
	),
	
	array(
	0=> array('key'=>'status', 'text'=>'ทั้งหมด')
	, array('key'=>'status', 'text'=>'ใช้ไปแล้ว')
	, array('key'=>'status', 'text'=>'คงเหลือ')
	),
);

$this->titleStyle = 'row-2';
$this->tabletitle = $title;
$this->getURL =  URL.'coupon/';