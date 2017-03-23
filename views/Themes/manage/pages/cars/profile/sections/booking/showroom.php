<?php

$a = array();
$a[] = array('label'=>'วันที่จอง');
$a[] = array('label'=> 'บริษัท');


?><table class="table-info">

		<tbody><?php foreach ($a as $key => $value) { ?>
		<tr>
			<td class="label"><?=$value['label']?></td>
			<td class="data">เบอร์มือถือ</td>
		</tr>
		<?php } ?>
		</tbody>

</table>
<!-- end -->