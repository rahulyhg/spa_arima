<div class="profile-resume">
	<?php

	$a = array();
	$a[] = array('label'=>'Model', 'key'=> 'model_name');
	$a[] = array('label'=>'รุ่น', 'key' => 'name');
	$a[] = array('label'=>'ขนาดเครื่องยนต์', 'key' => 'cc');
	$a[] = array('label'=>'ปีที่ผลิต', 'key' => 'mfy');
	$a[] = array('label'=>'ราคาขาย', 'key' => 'price');
	$a[] = array('label'=>'คงเหลือ', 'key' =>'balance');

	?>
	<section class="mbl">
		<header class="clearfix">
			<h2 class="title">ข้อมูลสินค้า</h2>
		</header>

		<table cellspacing="0"><tbody><?php

			foreach ($a as $key => $value) {

				if( empty($this->item[ $value['key'] ]) ) continue;
				$val = $this->item[ $value['key'] ];
				echo '<tr>'.
				'<td class="label">'.$value['label'].'</td>'.
				'<td class="data">'.$val.'</td>'.
				'</tr>';
			}
			?>
		</tbody></table>

	</section>
</div>