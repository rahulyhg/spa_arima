<?php

$summary = array();
$summary[] = array('label'=>'ค่าห้อง VIP','value'=>2920, 'note'=>'');
$summary[] = array('label'=>'นวดตัว','value'=>90950, 'note'=>'');
$summary[] = array('label'=>'นวดเท้า','value'=>30550, 'note'=>'');
$summary[] = array('label'=>'นวดหัว','value'=>6150, 'note'=>'');
$summary[] = array('label'=>'นวด OIL','value'=>4200, 'note'=>'');
$summary[] = array('label'=>'นวดหน้า','value'=>6900, 'note'=>'');
$summary[] = array('label'=>'แคะหู','value'=>14350, 'note'=>'');
$summary[] = array('label'=>'เล็บมือ','value'=>2700, 'note'=>'');
$summary[] = array('label'=>'เล็บเท้า','value'=>2700, 'note'=>'');
$summary[] = array('label'=>'SAUNA','value'=>8500, 'note'=>'');
$summary[] = array('label'=>'AKASURI','value'=>1800, 'note'=>'');
$summary[] = array('label'=>'อาบน้ำ','value'=>300, 'note'=>'');
$summary[] = array('label'=>'DRINK','value'=>3761, 'sub'=> array(
		0=> 
		  array('label'=>'ในร้าน', 'value'=> 274)
		, array('label'=>'ในร้าน', 'value'=> 274)

	), 'note'=>'');

$discount = array();
$discount[] = array('label'=>'ลบคูปอง','value'=>600, 'note'=>'');
$discount[] = array('label'=>'เฮีย','value'=>1860, 'note'=>'');
?>
<div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;overflow-y: auto;">
<div style="max-width: 550px;margin-top: 30px;margin-left: 30px;">

	<header>
		<div class="tac">
			<h1>ใบสรุปยอดรายรับ</h1>
		</div>
		<div class="tar fsm mbm">วันที่ <?=date('Y-m-d')?></div>
	</header>

<div class="mvm pbl">
	<table class="pos-summary-table">
		<thead>
			<tr>
				<th class="name">รายการ</th>
				<th class="price">รวม</th>
			</tr>
		</thead>

	<tbody><?php 

	$n = 0;
	$total = 0;
	$subtotal = 0;
	foreach ($summary as $key => $value) { 

		$total += $value['value'];
	$n++;
	?>
		
		<tr>
			<!-- <td class="ID"><?=$n?>.</td> -->
			<td class="name"><?=$n?>. <strong><?=$value['label']?></strong><?php

				if( !empty($value['sub']) ){
					echo '<ul>';
					foreach ($value['sub'] as $val) {
						echo '';
					}
					echo '</ul>';
				}

				if( !empty($value['note']) ){

					echo '<div class="note">'.$value['note'].'</div>';

				}

			?></td>
			<td class="price"><?= number_format( $value['value'], 0)?></td>
		</tr>
	<?php } ?>
	</tbody>

	<tbody class="total">
		<tr>
			<th class="name">ยอดรวม</th>
			<th class="price"><div class="span-border"><?= number_format($total)?></div></th>
		</tr>
	</tbody>

	<tbody class="minus">
	<?php 
		foreach ($discount as $key => $value) { ?>
		<tr>
			<td class="name"> - <?=$value['label']?></td>
			<td class="price"><?= number_format( $value['value'], 0)?></td>
		</tr>
		<?php } ?>
	</tbody>


	<tbody class="subtotal">
		<tr>
			<th class="name">รวมทั้งหมด</th>
			<th class="price"><div class="span-border"><?= number_format($total)?></div></th>
		</tr>
	</tbody>

	</table>

</div>

</div>
</div>