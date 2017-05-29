<?php

/*$income = array();
$income[] = array('label'=>'ค่าห้อง V.I.P.','value'=>600, 'note'=>'');*/
// $income[] = array('label'=>'ค่าห้อง V.I.P.','value'=>600, 'note'=>'');



$discount = array();
/*$discount[] = array('label'=>'ลบคูปอง','value'=>600, 'note'=>'');
$discount[] = array('label'=>'เฮีย','value'=>1860, 'note'=>'');
*/

?>
<table class="pos-summary-table">
		
	<tbody>
	<?php 
	$n = 0;
	$subtotal = 0;
	foreach ($this->income as $key => $value) { 

		$n++;
		$subtotal += $value['total'];
	?>
		<tr>
			<!-- <td class="ID"><?=$n?>.</td> -->
			<td class="name"><div class="hdr-text"><?=$n?>. <strong><?=$value['name']?></strong><?php

				if( !empty($value['note']) ){

					echo '<span class="note">'.$value['note'].'</span>';

				}

			?></div></td>
			<td class="price"><div class="hdr-text"><?= number_format( $value['total'], 0)?></div></td>
		</tr>
	<?php } ?>
	</tbody>

	<tbody class="total">
		<tr>
			<th class="name"><div class="hdr-text">ยอดรวม</div></th>
			<th class="price"><div class="hdr-text highlight"><?= number_format($subtotal)?></div></th>
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
			<th class="price"><div class="hdr-text highlight"><?= number_format($subtotal-$minus)?></div></th>
		</tr>
	</tbody>
</table>
