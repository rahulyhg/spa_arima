<?php

$discount = array();
// $discount[] = array('label'=>'ลบคูปอง','value'=>600, 'note'=>'');
// $discount[] = array('label'=>'เฮีย','value'=>1860, 'note'=>'');


?><div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;">


<div style="position: absolute;top: 0;left: 0; right: 100px;background-color: rgba(245,248,250,.98);z-index: 1">
<header class="clearfix" style="padding-top: 60px;padding-left: 30px;padding-right: 30px">
	<div class="lfloat"><h1 style="display: inline-block;"><i class="icon-line-chart mrs"></i><span>สรุปยอดรายรับ</span></h1>
	</div>
	<div class="tar fsm mbm">วันที่ <input style="display:inline-block;background-color: #fff" type="date" name="date" class="inputtext"></div>
</header>
</div>

<div style="position: absolute;top: 0;left: 30px;overflow-y: auto;bottom: 0;right: 0">

<div style="margin-right: 100px;padding-top: 100px">
	

<div class="mvm pbl" style="background-color: #fff;box-shadow:0 1px 3px rgba(0,0,0,.3); padding: 10px;border:1px solid rgba(0,0,0,.3);border-radius: 3px;">
	<table class="pos-summary-table">
		

	<tbody>
		<tr>
			<td class="name"><div class="hdr-text">1. <strong>ค่าห้อง VIP</strong></div></td>
			<td class="price"><div class="hdr-text"><?= number_format( $this->room['total_room_price'], 0)?></div></td>
		</tr>
	<?php 
	$n = 1;
	$total = $this->room['total_room_price'];
	$subtotal = 0;
	foreach ($this->lists['lists'] as $key => $value) { 

		$total += $value['total_balance'];
	$n++;
	?>
		
		<tr>
			<!-- <td class="ID"><?=$n?>.</td> -->
			<td class="name"><div class="hdr-text"><?=$n?>. <strong><?=$value['name']?></strong><?php

				if( !empty($value['note']) ){

					echo '<span class="note">'.$value['note'].'</span>';

				}

			?></div></td>
			<td class="price"><div class="hdr-text"><?= number_format( $value['total_balance'], 0)?></div></td>
		</tr>
	<?php } ?>
		<tr>
			<td class="name"><div class="hdr-text"><?=$n++?> <strong>ค่า DRINK</strong></div></td>
			<td class="price"><div class="hdr-text"><?= number_format( $this->revenue['sum_drink'], 0)?></div>
			<?php $total = $total+$this->revenue['sum_drink']; ?>
			</td>
		</tr>
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

		<?php if( $minus > 0 ) { ?>
		<tr>
			<td class="name"><div class="hdr-text"> - รวมหัก</div></td>
			<td class="price"><div class="hdr-text highlight"><?= number_format( $minus )?></div></td>
		</tr>
		<?php } ?>
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