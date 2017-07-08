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
			<th class="tac">No.</th>
			<th class="tac">ชื่อ</th>
			<?php 
			for($i=$start; $i<=$end; $i++){
				echo '<th class="tac">'.intval($i).'</th>';
			}
			?>
			<th>รวม</th>
			<th>ครั้งละ <?=$this->item['skill'][0]['price']?></th>
			<th>ลายเซ็น</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($this->results['lists'] as $key => $value) { $total = 0;  ?>
		<tr>
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
				$price = $total * $this->item['skill'][0]['price'];
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
<?php }
else{
	echo '<div class="fwb tac">ไม่พบข้อมูล แผนก'.$this->item['name'].'</div>';
	} ?>