<?php
//print_r($this->tabletitle); die;

$title = array( 0 => 
	array(
	0 =>   array('key'=>'date', 'text'=>'วันที่นัดซ่อม', 'sort'=>'date_repair','rowspan'=>2)

		 , array('key'=>'name', 'text'=>'ข้อมูลรถ','rowspan'=>2)
		 , array('key'=>'content', 'text'=>'ชื่อลูกค้า','rowspan'=>2)
		 , array('key'=>'content', 'text'=>'พนักงาน','sort'=>'emp_id','rowspan'=>2)

		 , array('key'=>'qty', 'text'=>'รายการซ่อม', 'sort'=>'total_price','rowspan'=>2)
		 , array('key'=>'price', 'text'=>'ราคาซ่อม', 'sort'=>'total_list','rowspan'=>2)

		 , array('key'=>'status', 'text'=>'สถานะ', 'colspan'=> 4)
	),
	array(
	0 =>   array('key'=>'status', 'text'=>'นัดหมาย')
		 , array('key'=>'status', 'text'=>'กำลังซ่อม')
		 , array('key'=>'status', 'text'=>'ส่งมอบ')
		 , array('key'=>'status', 'text'=>'ยกเลิก')
	) 
	
);


$this->titleStyle = 'row-2';
$this->tabletitle = $title;
$this->getURL =  URL.'services/';