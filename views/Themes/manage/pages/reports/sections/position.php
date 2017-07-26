<?php 
$start = date("d", strtotime($this->start_date));
$end = date("d", strtotime($this->end_date));

$sum = array();
$total_time=0; 
$total_price=0;

if( !empty($this->data) ){
	?>
	<table class="table table-bordered" width="100%">
		<thead>
			<tr>
				<th class="id">ลำดับ</th>
				<th class="tac">No.</th>
				<th class="tac">ชื่อ</th>
				<?php 
				for($i=$start; $i<=$end; $i++){
					echo '<th class="tac">'.intval($i).'</th>';
				}
				?>
				<th>รวม</th>
				<th>ครั้งละ <?=$this->item['wage_price']?></th>
				<th>ลายเซ็น</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=0; foreach ($this->results['lists'] as $key => $value) { $total = 0; $i++;  ?>
			<tr>
				<td><?=$i?></td>
				<td class="tac"><?=$value['code']?></td>
				<td class="tac"><?=$value['nickname']?></td>
				<?php 
				for($i=$start; $i<=$end; $i++){

					$day = sprintf("%02d",$i);
					$time = !empty($this->data[$value['id']][$day]) ? $this->data[$value['id']][$day] : 0;
					echo '<td class="tac">'.(!empty($time) ? number_format($time, 1) : '-').'</td>';

					$sum[$day] = !empty($sum[$day]) ? $sum[$day]+$time : $time;

					$total += $time;
				}
				?>
				<td class="tar">
					<?php 
					echo number_format($total,1);
					$total_time += $total;
					?>
				</td>
				<td class="tar">
					<?php 
					$price = $total * $this->item['wage_price'];
					$total_price += $price;

					echo number_format($price,1);
					?>
				</td>
				<td></td>
			</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th></th>
				<th>รวม</th>
				<?php 
				for($i=$start; $i<=$end; $i++){
					$day = sprintf("%02d",$i);
					echo '<th class="tar">'.(!empty($sum[$day]) ? number_format($sum[$day],1) : '-' ).'</th>';
				}
				?>
				<th class="tar"><?=number_format($total_time, 1)?></th>
				<th class="tar"><?=number_format($total_price, 1)?></th>
				<th></th>
			</tr>
		</tfoot>
	</table>

	<div class="pas">
		<div class="tac">
			<label class="label">ไม่พบหมอ : </label>
			<span class="fwb"><?=($this->data['null']) ? $this->data['null'] : 0?> ชม.</span>
			<label class="label">รวมเป็นเงิน : </label>
			<span class="fwb">
				<?php 
				$total_empty = $this->data['null'] * $this->item['skill'][0]['price'];
				echo number_format($total_empty,1);
				?>
			</span>
		</div>
		<div class="uiBoxWhite tac">
			<label>รวมเป็นเงินทั้งหมด : </label>
			<span class="fwb"><?=number_format($total_empty+$total_price,1)?></span>
		</div>
	</div>

	<?php }
	else{
		echo '<div class="fwb tac">ไม่พบข้อมูล แผนก'.$this->item['name'].'</div>';
	} ?>

	<div class="rfloat">
	<a href="<?=URL?>reports/lists/masseuse?period=<?=$this->period?>&month=<?=$this->month?>" class="btn btn-blue">กลับ</a>
	</div>