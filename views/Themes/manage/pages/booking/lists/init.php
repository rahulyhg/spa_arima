<?php

$title = array( 0 => 
	array(
	0 =>   array('key'=>'date', 'text'=>'วันที่จอง', 'sort'=>'date','rowspan'=>2)

		 , array('key'=>'name', 'text'=>'ชื่อลูกค้า','sort'=>'cus_id','rowspan'=>2)
		 , array('key'=>'email', 'text'=>'Model','sort'=>'model_id','rowspan'=>2)
		 , array('key'=>'content', 'text'=>'รุ่นรถยนต์','sort'=>'pro_id','rowspan'=>2)
		 , array('key'=>'content', 'text'=>'พนักงานขาย','sort'=>'sale_id','rowspan'=>2)

		 , array('key'=>'status', 'text'=>'สถานะ', 'colspan'=> 3)
	),
	array(
	0 =>   array('key'=>'status', 'text'=>'จอง')
		 , array('key'=>'status', 'text'=>'ถอนจอง')
		 , array('key'=>'status', 'text'=>'ส่งหมอบ')
	) 
	
);

$this->titleStyle = 'row-2';
$this->tabletitle = $title;
$this->getURL =  URL.'booking/';