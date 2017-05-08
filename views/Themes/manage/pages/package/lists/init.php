<?php

$url = URL. "package/";

$title = array(
	0 =>   //array('key'=>'ID', 'text'=>'Name', 'sort'=>'code')

	array('key'=>'name', 'text'=>'Name', 'sort'=>'first_name'),
	array('key'=>'qty', 'text'=>'Quantity'),
	array('key'=>'unit', 'text'=>'Unit'),
	array('key'=>'price', 'text'=>'Price'),
	array('key'=>'status', 'text'=>'Status'),

	// array('key'=>'phone', 'text'=>'เบอร์โทร'),
	// array('key'=>'note', 'text'=>'หมายเหตุ'),	
);

$this->tabletitle = $title;
$this->getURL = $url;