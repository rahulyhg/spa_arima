<?php

$a = array();
$a[] = array('label'=> 'ค่ารถยนต์/Car price');
$a[] = array('label'=>'เงินดาวน์/Down payment');
$a[] = array('label'=>'ค่าจดทะเบียน/Registration Fee');
$a[] = array('label'=>'ค่ามัดจำป้ายแดง/Deposit red price');
$a[] = array('label'=>'ค่าเบี้ยประกันภัย/Insurance Premium');
$a[] = array('label'=>'ค่าอุปกรณ์ตกแต่ง/Accessory');
$a[] = array('label'=>'อื่นๆ/Other');

$a[] = array('label'=>'รวมค่าใช้จ่าย/Total Expense');
$a[] = array('label'=>'หัก เงินมัดจำ/Deposit');
$a[] = array('label'=>'หัก เงินค่ารถเก่า/User car trade-in');
$a[] = array('label'=>'อื่นๆ/Other');

$a[] = array('label'=>'รวมค่าใช้จ่ายทั้งสิ้น/Net total expense');

		
?><table class="table-info table-info-payment">

		<thead>
			<th colspan="2">เงื่อนไขการชำระเงิน/Payment Conditions</th>
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