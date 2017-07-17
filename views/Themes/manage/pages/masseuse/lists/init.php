<?php
//print_r($this->tabletitle); die;


$skill = array();
foreach ($this->skill as $key => $value) {
	$skill[] = array('key'=>'status', 'text'=>$value['name']);
}

$title = array( 0 => 
	array(
	0 =>   array('key'=>'ID', 'text'=>'เบอร์', 'sort'=>'code_order','rowspan'=>2)

		 , array('key'=>'name', 'text'=>'ชื่อ-นามสกุล', 'sort'=>'first_name','rowspan'=>2)
		 , array('key'=>'status', 'text'=>'ชื่อเล่น','rowspan'=>2)

		 , array('key'=>'status', 'text'=>'ความสามารถในการบริการ','colspan'=> count($skill))

		 , array('key'=>'date', 'text'=>'ทำงานล่าสุด', 'sort'=>'updated','rowspan'=>2)
		 , array('key'=>'status', 'text'=>'การใช้งาน','rowspan'=>2)
	),
	$skill
	
);


$this->titleStyle = 'row-2';
$this->tabletitle = $title;

$this->getURL =  URL.'masseuse/';