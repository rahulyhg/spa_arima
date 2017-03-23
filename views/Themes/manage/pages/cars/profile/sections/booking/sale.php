<?php

$a = array();
$a[] = array('label'=> 'ชื่อ');
$a[] = array('label'=>'เบอร์โทร');
		
?><table class="table-info">

		<thead>
			<th colspan="2">ที่ปรึกษาการขาย</th>
		</thead>
		<tbody><?php foreach ($a as $key => $value) { ?>
		<tr>
			<td class="label"><?=$value['label']?></td>
			<td class="data"><?=$key?></td>
		</tr>
		<?php } ?>
		</tbody>

</table>
<!-- end -->