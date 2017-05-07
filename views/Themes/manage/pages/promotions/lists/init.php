<?php

$url = URL. "promotions/";

$title = array(
	0 =>   //array('key'=>'ID', 'text'=>'Name', 'sort'=>'code')

	array('key'=>'name', 'text'=>'Name', 'sort'=>'first_name'),
	array('key'=>'type', 'text'=>'Type'),
	array('key'=>'price', 'text'=>'Discount'),
	array('key'=>'date', 'text'=>'Time'),
	array('key'=>'status', 'text'=>'Status'),

	// array('key'=>'phone', 'text'=>'เบอร์โทร'),
	// array('key'=>'note', 'text'=>'หมายเหตุ'),	
);

$this->tabletitle = $title;
$this->getURL =  URL.'promotions/';