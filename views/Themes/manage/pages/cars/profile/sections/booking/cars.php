<table class="table-info">
	<thead>
		<th colspan="2">ข้อมูลรถ</th>
	</thead>
	<tbody><?php 

	$a = array();
	$a[] = array('label'=> 'หมายเลขเจ้าของรถ');
	$a[] = array('label'=>'หมายเลขทะเบียนรถ'); // เลข + วันที่ลงทะเบียนป้าย
	$a[] = array('label'=>'แบรนด์');
	$a[] = array('label'=>'Model');
	$a[] = array('label'=>'รุ่น');
	$a[] = array('label'=>'VIN');
	$a[] = array('label'=>'หมายเลขเครื่อง');
	$a[] = array('label'=>'สี');
	$a[] = array('label'=>'ขนาดเครื่องยนต์');
	$a[] = array('label'=>'ปีที่ผลิต MFY');
	foreach ($a as $key => $value) { ?>
	<tr>
		<td class="label"><?=$value['label']?></td>
		<td class="data"><?=$key?></td>
	</tr>
	<?php } ?>
	</tbody>

</table>
<!-- end -->