<?php

$discount = array();
// $discount[] = array('label'=>'ลบคูปอง','value'=>600, 'note'=>'');
// $discount[] = array('label'=>'เฮีย','value'=>1860, 'note'=>'');


?>
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
