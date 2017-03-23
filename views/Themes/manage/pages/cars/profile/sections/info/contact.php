<?php

$a = array();
$a[] = array('label'=>'ชื่อเจ้าของรถยนต์', 'key' => 'cus_fullname');
$a[] = array('label'=>'เบอร์ติดต่อ', 'key' => 'cus_phone');
$a[] = array('label'=>'Line ID', 'key' => 'cus_lineID');
$a[] = array('label'=>'email', 'key' => 'cus_email');
$a[] = array('label'=>'ที่อยู่ปัจจุบัน', 'key' => 'cus_address');
$a[] = array('label'=>'จังหวัด', 'key' => 'cus_city_name');
$a[] = array('label'=>'รหัสไปรษณีย์', 'key'=> 'cus_zip');

?>
<section class="mbl">
	<header class="clearfix">
		<h2 class="title">ข้อมูลเจ้าของรถยนต์</h2>
		<a data-plugins="dialog" href="<?=URL?>cars/edit_contact/<?=$this->item['id']?>" class="btn-icon btn-edit"><i class="icon-pencil"></i></a>
	</header>
	
	<table cellspacing="0"><tbody><?php

	foreach ($a as $key => $value) {
		
		if( empty($this->item[ $value['key'] ]) ) continue;

		echo '<tr>'.
			'<td class="label">'.$value['label'].'</td>'.
			'<td class="data">'.$this->item[ $value['key'] ].'</td>'.
		'</tr>';
	}
	?></tbody></table>
					
</section>