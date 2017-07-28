<?php 
$dayStr = date("d", strtotime($this->date));
$monthStr = $this->fn->q('time')->month( date("n", strtotime($this->date)), true );
$yearStr = date("Y", strtotime($this->date))+543;

$date = "{$dayStr} {$monthStr} {$yearStr}";

$page_total = ($this->results['total'] / 20);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
	<style type="text/css">
		@page {
			size: 8.5in 13in landscape;
			margin: 0mm; 
			height:50px;
			position:fixed;
			left:0px;
			bottom:0px;
			background-color:#000000;
			width:100%;
			z-index: 99;
		}
		.tac{
			text-align: center;
		}
		.tar{
			text-align: right;
		}
		table {
			border-collapse: collapse;
		}
		table, th, td {
			border: 1px solid black;
		}
		.rfloat{
			float: right;
		}
	</style>
	<script type="text/javascript">
		(function() {

			var beforePrint = function() {};

			var afterPrint = function() {
				window.top.close();
			};

			if (window.matchMedia) {
				var mediaQueryList = window.matchMedia('print');
				mediaQueryList.addListener(function(mql) {
					if (mql.matches) {
						beforePrint();
					} else {
						afterPrint();
					}
				});
			}

			window.onbeforeprint = beforePrint;
			window.onafterprint = afterPrint;

		}());
	</script>
</head>
<body onload="window.print();">
	<div class="tac">
		<span ><strong>รายงานรายรับประจำวัน</strong></span>
	</div>
	<div class="rfloat">
		<span><strong>ณ วันที่</strong> <?=$date?></span> 
		<span><strong>แผ่นที่</strong> 1/<?=ceil($page_total)?></span>
	</div>
	<br/>
	<table width="100%">
		<thead>
			<tr>
				<th class="tac">ลำดับ</th>
				<th class="tac">ชื่อลูกค้า</th>
				<th class="tac">สมาชิก</th>
				<th class="tac">พนง.ผู้บริการ</th>
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

			$page = 1;

			$total = array(); 
			$total['balance'] = 0;
			$total['drink'] = 0;
			$total['qty'] = 0;
			$total['vip'] = 0;
			$number = 0;
			$total_list = 0;

			foreach ($this->results['lists'] as $value) 
			{
				$total['balance'] += $value['balance'];
				$total['drink'] += $value['drink'];
				$total['qty'] += $this->data[$value['id']]['qty'];
				$total['vip'] += $value['room_price'];

				$room_price = round($value['room_price']);

				$starttime = "-";
				$endtime = "-";
				if( $value['start_date'] != "0000-00-00 00:00:00" ){
					$starttime = date("H:i", strtotime($value['start_date']));
				}
				if( $value['end_date'] != "0000-00-00 00:00:00" ){
					$endtime = date("H:i", strtotime($value['end_date']));
				}
				?>
				<tr>
					<td class="tac"><?=$value['number']?></td>
					<td><?=(!empty($value['cus']) ? $value['cus']['fullname'] : '')?></td>
					<td><?=(!empty($value['cus']) ? $value['cus']['code'] : '')?></td>
					<td><?=$this->data[$value['id']]['masseuse_name']?></td>
					<td class="tac"><?=$starttime?></td>
					<td class="tac"><?=$endtime?></td>
					<td class="tac"><?=(!empty($value['room_name']) ? $value['room_name'] : '-')?></td>
					<td class="tac"><?=(!empty($this->data[$value['id']]['qty']) ? $this->data[$value['id']]['qty'] : '-')?></td>
					<td class="tac"><?=(!empty($room_price) ? number_format($value['room_price'],0) : '-')?></td>

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
									<?php foreach ($this->data[$value['id']][$val['id']]['masseuse'] as $mas) {
										echo '<div>'.$mas.'</div>';
									} ?>
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
				<?php 
					$number++;
					$total_list++;
					if( $number == 20 && $total_list < $this->results['total'] ){
						$page++;
				?>
			</tbody>
				<tfoot>
					<tr>
						<th colspan="6" class="tar"><?=$total['qty']?> ชม.</th>
						<th class="tac">ยอดรวม</th>
						<th colspan="2" class="tac"><?=(!empty($total['vip']) ? $total['vip'] : '-')?></th>
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
			<div style="page-break-after: always"></div>
			<!-- End Table And Create New Table -->

			<div class="tac">
				<span ><strong>รายงานรายรับประจำวัน</strong></span>
			</div>
			<div class="rfloat">
				<span><strong>ณ วันที่</strong> <?=$date?></span> 
				<span><strong>แผ่นที่</strong> <?=$page?>/<?=ceil($page_total)?></span>
			</div>
			<br/>
			<table width="100%">
				<thead>
					<tr>
						<th class="tac">ลำดับ</th>
						<th class="tac">ชื่อลูกค้า</th>
						<th class="tac">สมาชิก</th>
						<th class="tac">พนง.ผู้บริการ</th>
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
					$number = 0;
				}
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="6" class="tar"><?=$total['qty']?> ชม.</th>
				<th class="tac">ยอดรวม</th>
				<th colspan="2" class="tac"><?=(!empty($total['vip']) ? $total['vip'] : '-')?></th>
				<?php 
				foreach ($this->package['lists'] as $val) {
					$col = 1;
					if( !empty($val['skill']) ){
						$col = 2;
					}
					echo '<th class="tac" colspan="'.$col.'">'.(!empty($total[$val['id']]) ? number_format($total[$val['id']],0) : '-').'</th>';
				}
				?>
				<th class="tac"><?=(!empty($total['drink']) ? number_format($total['drink'],0) : '-')?></th>
				<th class="tac"><?=number_format($total['balance'],0)?></th>
			</tr>
		</tfoot>
	</table>
</body>
</html>