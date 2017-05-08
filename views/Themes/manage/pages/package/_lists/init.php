<?php


// $title[] = array('key'=>'date', 'text'=>'เพิ่มเมื่อ', 'sort'=>'created');

// $title[] = array('key'=>'name', 'text'=>'ชื่อ-นามสกุล', 'sort'=>'first_name');
// $title[] = array('key'=>'email', 'text'=>'');
// $title[] = array('key'=>'status', 'text'=>'จำนวนรถ');
// $title[] = array('key'=>'status', 'text'=>'จำนวนการจอง');
// $title[] = array('key'=>'status', 'text'=>'จำนวนยกเลิกจอง');

$title = array( 0 => 
	array(
	0 =>   array('key'=>'date', 'text'=>'เพิ่มเมื่อ', 'sort'=>'created','rowspan'=>2)

		 , array('key'=>'name', 'text'=>'ชื่อ-นามสกุล','sort'=>'first_name','rowspan'=>2)
		 , array('key'=>'email', 'text'=>'ข้อมูลการติดต่อ','rowspan'=>2)
		 , array('key'=>'status', 'text'=>'จำนวน', 'colspan'=> 3)
	),
	array(
	0 =>   array('key'=>'status', 'text'=>'รถ')
		 , array('key'=>'status', 'text'=>'การจอง')
		 , array('key'=>'status', 'text'=>'ยกเลิกจอง')
	) 
	
);

$this->titleStyle = 'row-2';

$this->tabletitle = $title;
$this->getURL =  URL.'package/';