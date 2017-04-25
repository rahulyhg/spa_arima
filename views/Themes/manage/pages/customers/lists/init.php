<?php


// $title[] = array('key'=>'date', 'text'=>'เพิ่มเมื่อ', 'sort'=>'created');

// $title[] = array('key'=>'name', 'text'=>'ชื่อ-นามสกุล', 'sort'=>'first_name');
// $title[] = array('key'=>'email', 'text'=>'');
// $title[] = array('key'=>'status', 'text'=>'จำนวนรถ');
// $title[] = array('key'=>'status', 'text'=>'จำนวนการจอง');
// $title[] = array('key'=>'status', 'text'=>'จำนวนยกเลิกจอง');

$title = array( 0 => 
	array(
	0 =>   array('key'=>'date', 'text'=>$this->lang->translate('Created'), 'sort'=>'created','rowspan'=>2)

		 , array('key'=>'name', 'text'=>$this->lang->translate('Full Name'),'sort'=>'first_name','rowspan'=>2)
		 , array('key'=>'email', 'text'=>$this->lang->translate('Contact'),'rowspan'=>2)
	)
	
);

$this->titleStyle = 'row-2';

$this->tabletitle = $title;
$this->getURL =  URL.'customers/';