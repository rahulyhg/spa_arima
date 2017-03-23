<?php

$a = array();
$a[] = array('label'=> 'รถยนต์รุ่น/model');
$a[] = array('label'=>'สี/color');
$a[] = array('label'=>'ขนาดเครื่องยนต์/cc');
$a[] = array('label'=>'ปีที่ผลิต MFY');
$a[] = array('label'=>'ราคาจำหน่ายสุทธิ/Net');
$a[] = array('label'=>'จำนวนเงินมัดจำ(จอง)'); // ราคา ประเภทการชำระเงิน
// $a[] = array('label'=>'ประเภทการชำระเงิน');

		
?><table class="table-info">

		<thead>
			<th colspan="2">รายละเอียดการจองรถ</th>
		</thead>
		<tbody><?php foreach ($a as $key => $value) { ?>
		<tr>
			<td class="label"><?=$value['label']?></td>
			<td class="data">เบอร์มือถือ</td>
		</tr>
		<?php } ?>
		</tbody>

</table>
<!-- end -->