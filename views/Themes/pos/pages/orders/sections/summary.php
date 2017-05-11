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


?><div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;">


<div style="position: absolute;top: 0;left: 0; right: 100px;background-color: rgba(245,248,250,.98);z-index: 1">
<header class="clearfix" style="padding-top: 30px;padding-left: 30px;padding-right: 30px">
	<div class="lfloat"><h1 style="display: inline-block;"><i class="icon-line-chart mrs"></i><span>สรุปยอดรายรับ</span></h1>
	</div>
	<div class="tar fsm mbm">วันที่ <input style="display:inline-block;background-color: #fff" type="date" name="date" class="inputtext"></div>
</header>
</div>

<div style="position: absolute;top: 0;left: 30px;overflow-y: auto;bottom: 0;right: 0">

<div style="margin-right: 100px;padding-top: 70px">
	

<div class="mvm pbl">
	<table class="pos-summary-table">
		

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
			<td class="name"><div class="hdr-text"><?=$n?>. <strong><?=$value['label']?></strong><?php

				if( !empty($value['note']) ){

					echo '<span class="note">'.$value['note'].'</span>';

				}

			?></div></td>
			<td class="price"><div class="hdr-text"><?= number_format( $value['value'], 0)?></div></td>
		</tr>
	<?php } ?>
	</tbody>

	<tbody class="total">
		<tr>
			<th class="name"><div class="hdr-text">ยอดรวม</div></th>
			<th class="price"><div class="hdr-text highlight"><?= number_format($total)?></div></th>
		</tr>
	</tbody>

	<tbody class="minus">
	<?php 
		$minus = 0;
		foreach ($discount as $key => $value) { 
			$minus+= $value['value'];
		?>
		<tr>
			<td class="name"><div class="hdr-text"> - <?=$value['label']?></div></td>
			<td class="price"><div class="hdr-text"><?= number_format( $value['value'], 0)?></div></td>
		</tr>
		<?php } ?>

		<tr>
			<td class="name"><div class="hdr-text"> - รวมหัก</div></td>
			<td class="price"><div class="hdr-text highlight"><?= number_format( $minus )?></div></td>
		</tr>
	</tbody>


	<tbody class="subtotal">
		<tr>
			<th class="name"><div class="hdr-text">รวมทั้งหมด</div></th>
			<th class="price"><div class="hdr-text highlight"><?= number_format($total-$minus)?></div></th>
		</tr>
	</tbody>

	</table>

</div></div>


</div>

<div style="position: absolute;width: 100px;right: 20px;top: 40px;bottom: 30px;">

	<ul class="ui-list">
		<li class="mbm tac">
			<div class="gbtn radius">
				<a class="btn btn-blue" data-type="print"><i class="icon-print"></i></a>
			</div>
			<div class="mts des-text">Print</div>
		</li>

		<li class="mbm tac">
			<div class="gbtn radius">
				<a class="btn js-set-option" data-type="tipAmounts"><i class="icon-pencil"></i></a>
			</div>
			<div class="mts des-text">Edit</div>
		</li>

	</ul>

	<ul class="bottom" style="position: absolute;bottom: 0;left: 0;right: 0">
		
		<!-- <li class="mbm tac">
			<div class="gbtn radius">
				<a class="btn btn-red" data-type="print"><i class="icon-remove"></i></a>
			</div>
			<div class="mts des-text">Cancel</div>
		</li> -->
	</ul>
	
</div>

</div>