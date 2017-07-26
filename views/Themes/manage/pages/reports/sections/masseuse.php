<?php 

/* Set Month Thai */
$m[] = array('id'=>1, 'name'=>'มกราคม');
$m[] = array('id'=>2, 'name'=>'กุมภาพันธ์');
$m[] = array('id'=>3, 'name'=>'มีนาคม');
$m[] = array('id'=>4, 'name'=>'เมษายน');
$m[] = array('id'=>5, 'name'=>'พฤษภาคม');
$m[] = array('id'=>6, 'name'=>'มิถุนายน');
$m[] = array('id'=>7, 'name'=>'กรกฎาคม');
$m[] = array('id'=>8, 'name'=>'สิงหาคม');
$m[] = array('id'=>9, 'name'=>'กันยายน');
$m[] = array('id'=>10, 'name'=>'ตุลาคม');
$m[] = array('id'=>11, 'name'=>'พฤศจิกายน');
$m[] = array('id'=>12, 'name'=>'ธันวาคม');

$p[] = array('id'=>1, 'name'=>'1 - 10');
$p[] = array('id'=>2, 'name'=>'11 - 20 ');
$p[] = array('id'=>3, 'name'=>'21 - สิ้นเดือน');

$period = "?period=".$this->period."&month=".$this->month;
?>
<form method="get">
<div role="toolbar" class="pbs pas mbm rfloat">
	<button type="submit" class="btn btn-blue"><i class="icon-search"></i></button>
</div>
<div role="toolbar" class="pbs pas mbm rfloat uiBoxWhite">
	<select class="" name="period">
		<?php foreach ($p as $key => $value) {
			$sel = "";
			if( $value['id'] == $this->period ){
				$sel = ' selected="1"';
			}
			echo '<option'.$sel.' value="'.$value['id'].'">'.$value['name'].'</option>';
		}?>
	</select>
</div>
<div role="toolbar" class="pbs pas mbm rfloat uiBoxWhite">
	<select class="" name="month">
		<?php foreach ($m as $key => $value) {
			$selm = "";
			if( $value['id'] == $this->month ){
				$selm = ' selected="1"';
			}
			echo '<option'.$selm.' value="'.$value['id'].'">'.$value['name'].' '.(date("Y")+543).'</option>';
		}?>
	</select>
</div>
</form>
<div>
	<table class="table table-bordered" width="100%">
		<thead>
			<tr class="tac">
				<th>ลำดับ</th>
				<th>รายการ</th>
				<th>รายได้</th>
				<th>ค่าจ้างหมอ</th>
				<th>อัตรา %</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$i = 0;
			$total = 0;
			$wage = 0;
			$total_parttime = 0;
			$wage_parttime = 0;
			foreach ($this->results['lists'] as $key => $value) { $i++;

				if( empty($value['wage_price']) ) continue;

				$total += $value['total_balance'];
				$wage += $value['total_wage'];
				$total_parttime += $value['parttime']['total_balance'];
				$wage_parttime += $value['parttime']['total_wage'];
				?>
				<tr>
					<td class="tac"><?=$i?></td>
					<td class="tal">
						<a href="<?=URL?>reports/masseuse/<?=$value['id']?><?=$period?>">แผนก <?=$value['name']?></a>
					</td>
					<td class="tac"><?=(!empty($value['total_balance']) ? $value['total_balance'] : '-')?></td>
					<td class="tar"><?=(!empty($value['total_wage']) ? $value['total_wage'] : '-')?></td>
					<td class="tar">
						<?php 
						if( !empty($value['total_balance']) && $value['total_wage'] ){
							$persent = ($value['total_wage'] * 100)/$value['total_balance'];
							echo number_format($persent,2);
						}
						else{
							echo "-";
						}
						?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2" class="tac"></th>
					<th class="tac"><?=number_format($total,2);?></th>
					<th class="tac"><?=number_format($wage,2);?></th>
					<th class="tac"></th>
				</tr>
				<tr>
					<th colspan="2" class="tac"></th>
					<th class="tac">หัก 10%</th>
					<th class="tac">
						<?php
						$persent = 0;
						if( !empty($total_parttime) ){
							$persent = ($total_parttime * 10) / 100;
							echo number_format($persent,2);
						}
						else{
							echo "-";
						}
						?>
					</th>
					<th class="tac"></th>
				</tr>
				<tr>
					<th></th>
					<th class="tac">รวม</th>
					<th class="tac"><?=number_format($total,2)?></th>
					<th class="tac">
						<?php
						$total_wage = $wage-$persent;
						echo number_format($total_wage, 2);
						?>
					</th>
					<th class="tac">
						<?php 
						if( !empty($total) OR !empty($total_wage) ){
							echo number_format($total_wage * 100 / $total, 2);
						}
						else{
							echo "-";
						}
						?>
					</th>
				</tr>
			</tfoot>
		</table>
	</div>