<?php


require 'data.php';

$this->options = array(
	'limit' => 20,
	'sort' => 'number',
	'dir' => 'ASC',
	'has_item' => 1
);

$title = array( 0 => 
	array(
	0 =>   array('key'=>'check-box', 'text'=>'<label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="all"></label>','rowspan'=>2)

		, array('key'=>'ID', 'text'=>'ลำดับ','rowspan'=>2)

		, array('key'=>'name', 'text'=>'ข้อมูล','rowspan'=>2)
		 // , array('key'=>'status', 'text'=>'ชื่อเล่น', 'sort'=>'nickname','rowspan'=>2)

		, array('key'=>'bl', 'text'=>'รายรับแต่ละแผนก','colspan'=> count($this->skill))

		, array('key'=>'balance', 'text'=>'ยอดรวม','rowspan'=>2)
	),
	$this->skill
	
);


$this->titleStyle = 'row-2';
$this->tabletitle = $title;

$this->getURL =  URL.'pos/orders2/';