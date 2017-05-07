<?php
//print_r($this->tabletitle); die;


$skill = array();
foreach ($this->skill as $key => $value) {
	$skill[] = array('key'=>'status', 'text'=>$value['name']);
}

$title = array( 0 => 
	array(
	0 =>   array('key'=>'ID', 'text'=>'เบอร์', 'sort'=>'code','rowspan'=>2)

		 , array('key'=>'name', 'text'=>'ชื่อ-นามสกุล', 'sort'=>'first_name','rowspan'=>2)
		 , array('key'=>'status', 'text'=>'ชื่อเล่น', 'sort'=>'nickname','rowspan'=>2)

		 , array('key'=>'status', 'text'=>'ความสามารถในการบริการ','colspan'=> count($skill))

		 , array('key'=>'phone', 'text'=>'เบอร์โทร','rowspan'=>2)
		 , array('key'=>'note', 'text'=>'หมายเหตุ','rowspan'=>2)
	),
	$skill
	
);


$this->titleStyle = 'row-2';
$this->tabletitle = $title;

$this->getURL =  URL.'masseuse/';