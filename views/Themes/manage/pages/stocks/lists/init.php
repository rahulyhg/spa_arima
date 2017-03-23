<?php


$title = array( 0 => 
	array(
	0 =>   array('key'=>'name', 'text'=>'Model', 'sort'=>'name','rowspan'=>2)
		 , array('key'=>'status', 'text'=>'สถานะ', 'colspan'=> 4)
	),
	array(
	0 =>   array('key'=>'status', 'text'=>'ยอดจอง')
		 , array('key'=>'status', 'text'=>'คงเหลือง')
		 , array('key'=>'status', 'text'=>'รวม')
		 , array('key'=>'status', 'text'=>'ต้องสั่งเพิ่ม')
	) 
	
);

$this->titleStyle = 'row-2';
$this->tabletitle = $title;
$this->getURL =  URL.'stocks/';