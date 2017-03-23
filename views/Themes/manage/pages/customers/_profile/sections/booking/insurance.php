<table class="table-info">
	<thead>
		<th colspan="2">ประกันภัย/Insurance</th>
	</thead>
	<tbody><?php 

	$a = array();
	$a[] = array('label'=>'บริษัท/Company Name');
	$a[] = array('label'=>'ประเภท/Praty'); // เลข + วันที่
	$a[] = array('label'=>'ทุนประกัน/Praty'); // เลข + วันที่
	$a[] = array('label'=>'ค่าเบี้ยประกัน/Premium'); // รุชื่อ / ไม่ระบุชื่อ
	foreach ($a as $key => $value) { ?>
	<tr>
		<td class="label"><?=$value['label']?></td>
		<td class="data"><?=$key?></td>
	</tr>
	<?php } ?>
	</tbody>
</table>
<!-- end -->