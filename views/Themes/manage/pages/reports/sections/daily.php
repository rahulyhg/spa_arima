<div role="toolbar" class="pbs pas mbm">
	<form class="form-insert uiBoxWhite">
		<input type="date" name="date" data-plugins="datepicker" class="inputtext" value="<?=$this->date?>" >
		<button type="submit" class="btn btn-blue"><i class="icon-search"></i></button>
	</form>
</div>
<?php if( !empty($this->results['lists']) ) { ?>
<table class="table table-bordered" width="100%">
	<thead>
		<tr>
			<th class="tac">ลำดับ</th>
			<th class="tac">ชื่อลูกค้า</th>
			<th class="tac">สมาชิก</th>
			<th class="tac" class="tac">พนง.ผู้บริการ</th>
			<th class="tac">เวลาเริ่ม</th>
			<th class="tac">เวลาออก</th>
			<th class="tac">ห้อง/เตียง</th>
			<th class="tac">HR.</th>
			<th class="tac">VIP.</th>
			<?php 
			foreach ($this->package['lists'] as $key => $value) {
				if( !empty($value['skill']) ){
					echo '<th class="tac">NO.</th>';
				}
				echo '<th class="tac">'.$value['name'].'</th>';
			}
			?>
			<th class="tac">DRINK</th>
			<th class="tac">ยอดรวม</th>
		</tr>
	</thead>
	<tbody>
	<?php 

	$total = array(); 
	$total['balance'] = 0;
	$total['drink'] = 0;
	$total['qty'] = 0;
	$total['vip'] = 0;

	foreach ($this->results['lists'] as $value) { 
		$total['balance'] += $value['balance'];
		$total['drink'] += $value['drink'];
		$total['qty'] += $this->data[$value['id']]['qty'];
		$total['vip'] += $value['room_price'];
	?>
	<tr>
		<td class="tac"><?=$value['number']?></td>
		<td><?=(!empty($value['cus']) ? $value['cus']['fullname'] : '')?></td>
		<td><?=(!empty($value['cus']) ? $value['cus']['code'] : '')?></td>
		<td><?=$this->data['masseuse_name']?></td>
		<td class="tac"><?=date("H:i", strtotime($value['start_date']))?></td>
		<td class="tac"><?=date("H:i", strtotime($value['end_date']))?></td>
		<td class="tac">
			<?=(!empty($this->data[$value['id']]['rooms']) ? $this->data[$value['id']]['rooms'] : '-')?>
		</td>
		<td class="tac"><?=(!empty($this->data[$value['id']]['qty']) ? $this->data[$value['id']]['qty'] : '-')?></td>
		<td class="tac"><?=(!empty($value['room_price']) ? number_format($value['room_price'],0) : '-')?></td>

		<?php 
		// PACKAGE //
		foreach ($this->package['lists'] as $val) { 
			$total[$val['id']] = !empty($total[$val['id']]) ? $total[$val['id']] : 0;
			if( !empty($this->data[$value['id']][$val['id']]) ){

				$balance = $this->data[$value['id']][$val['id']]['balance'];
				$total[$val['id']] += $balance;

				if( !empty($val['skill']) ){
					?>
					<td class="tac">
						<?php 
						foreach ($this->data[$value['id']][$val['id']]['masseuse'] as $mas) {
							echo '<div>'.$mas.'</div>';
						}
						?>
					</td>
					<?php
				}
				?>
				<td class="tac"><?=number_format($balance,0)?></td>
				<?php 
			}
			else{

				if( !empty($val['skill']) ){
					echo '<td class="tac">-</td>';
				}
				echo '<td class="tac">-</td>';
			}
		} 
		//END PACKAGE //
		?>
		<td class="tac"><?=($value['drink'] != 0.00 ? number_format($value['drink'],0) : '-')?></td>
		<td class="tac"><?=number_format($value['balance'], 0)?></td>
	</tr>
	<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="6" class="tar"><?=$total['qty']?> ชม.</th>
			<th class="tac">ยอดรวม</th>
			<th colspan="2" class="tac"><?=$total['vip']?></th>
			<?php 
			foreach ($this->package['lists'] as $val) {
				$col = 1;
				if( !empty($val['skill']) ){
					$col = 2;
				}
				echo '<th class="tac" colspan="'.$col.'">'.(!empty($total[$val['id']]) ? number_format($total[$val['id']],0) : '-').'</th>';
			}
			?>
			<th class="tac"><?=number_format($total['drink'],0)?></th>
			<th class="tac"><?=number_format($total['balance'],0)?></th>
		</tr>
	</tfoot>
</table>
<?php }else{
	echo '<div class="uiBoxWhite tac fwb">ไม่พบข้อมูลการให้บริการของวันที '.$this->periodStr.'</div>';
	} ?>