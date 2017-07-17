<?php


$title = array(
	0 =>   
	  array('key'=>'ID', 'text'=>$this->lang->translate('Code'), 'sort'=>'code')
	, array('key'=>'name', 'text'=>'ชื่อ','sort'=>'first_name')
	// , array('key'=>'status', 'text'=>'ชื่อเล่น' )
	, array('key'=>'express', 'text'=>'ข้อมูลการติดต่อ' )

	, array('key'=>'status', 'text'=>'สถานะ' )
	, array('key'=>'date', 'text'=>'วันหมดอายุ' )
	, array('key'=>'date', 'text'=>'เข้าใช้บริการล่าสุด' , 'sort'=>'updated')
	 // , array('key'=>'date', 'text'=>$this->lang->translate('Last Update'))
	
);

// $this->titleStyle = 'row-2';

$this->tabletitle = $title;
$this->getURL =  URL.'customers/';