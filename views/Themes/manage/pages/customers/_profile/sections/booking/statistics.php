<table class="table-info">
	<thead>
		<th colspan="2">ข้อมูลการใช้งาน</th>
	</thead>
	<tbody><?php 

	$a = array();
	$a[] = array('label'=>'วันที่ซื้อ');
	$a[] = array('label'=>'วันที่ซื้อ');
	$a[] = array('label'=>'เลขไมล์'); // เลข + วันที่

	foreach ($a as $key => $value) { ?>
	<tr>
		<td class="label"><?=$value['label']?></td>
		<td class="data"><?=$key?></td>
	</tr>
	<?php } ?>
	</tbody>
</table>
<!-- end -->