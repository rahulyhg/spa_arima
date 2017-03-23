<?php

$a = array();
$a[] = array('label'=>'ชื่อรถยนต์', 'key' => 'pro_name');
$a[] = array('label'=>'เลขทะเบียนรถยนต์', 'key' => 'license_plate');
$a[] = array('label'=>'ยีห้อ', 'key' => 'brand_name');
$a[] = array('label'=>'รุ่น', 'key' => 'model_name');
$a[] = array('label'=>'VIN Number', 'key' => 'item_vin');
$a[] = array('label'=>'รหัสเครื่องยนต์', 'key' => 'item_engine');

// $a[] = array('label'=>'สถานภาพการสมรส', 'key' => 'fullname');

?>
<section class="mbl">
	<header class="clearfix">
		<h2 class="title">ข้อมูลรถยนต์เบื้องต้น</h2>
		<a data-plugins="dialog" href="<?=URL?>cars/edit_basic/<?=$this->item['id']?>" class="btn-icon btn-edit"><i class="icon-pencil"></i></a>
	</header>
	
	<table cellspacing="0"><tbody><?php

	foreach ($a as $key => $value) {
		
		if( empty($this->item[ $value['key'] ]) ) continue;

		
		if($value['key']=='birthday'){
			$val =  $this->fn->q('time')->birthday($this->item[ $value['key'] ]);
		}
		else{
			$val = $this->item[ $value['key'] ];
		}
		echo '<tr>'.
			'<td class="label">'.$value['label'].'</td>'.
			'<td class="data">'.$val.'</td>'.
		'</tr>';
	}
	?></tbody></table>
					
</section>