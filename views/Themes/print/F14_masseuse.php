<?php 
$start = date("d", strtotime($this->start_date));
$end = date("d", strtotime($this->end_date));
$year = date("Y", strtotime($this->start_date))+543;

$sum = array();
$total_time=0; 
$total_price=0;
$number_total = 0;
$page = 1;
$page_total = $this->results['total'] / 50;
$total_page = round($page_total)==0 ? 1 : round($page_total);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<style type="text/css">
		@page {
			size: 8.5in 13in;
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
		.tal{
			text-align: left;
		}
		table {
			border-collapse: collapse;
			/*font-size:16pt;*/
		}
		.table-bordered {
			border: 1px solid black;
		}
		.table-bordered > thead > tr > th,
		.table-bordered > tbody > tr > th,
		.table-bordered > tfoot > tr > th,
		.table-bordered > thead > tr > td,
		.table-bordered > tbody > tr > td,
		.table-bordered > tfoot > tr > td {
			border: 1px solid black;
		}
		.pull-right{
			float: right;
		}
		.pull-left{
			float: left;
		}
		.text-center{
			text-align: center;
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
	<div>
		<span class="pull-left"><strong>แผนก<?=$this->item['name']?></strong></span>
		<span class="pull-right"><strong>แผ่นที่ </strong><?=$page?>/<?=$total_page?></span>
	</div>
	<div class="text-center"><strong>ประจำวันที่ <?=$this->periodStr.' '.$year?></strong></div>
	<div>
		<table class="table-bordered" width="100%">
			<thead>
				<tr>
					<th class="tac" width="2%">No.</th>
					<th class="tac" width="15%">ชื่อ</th>
					<?php 
					for($i=$start; $i<=$end; $i++){
						echo '<th class="tac fwb" width="5%">'.intval($i).'</th>';
					}
					?>
					<th width="10%">รวม</th>
					<th width="10%"><?=$this->item['name']?></th>
					<th width="13%">ผู้รับเงิน</th>
				</tr>
			</thead>
			<tbody>
				<?php $number=0; foreach ($this->results['lists'] as $key => $value) { $total = 0;  ?>
				<tr>
					<td class="tac"><?=$value['code']?></td>
					<td class="tac"><?=(!empty($value['nickname']) ? $value['nickname'] : $value['first_name'])?></td>
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
				<?php 
				$number++;
				$number_total++;
				if( $number == 50 && $number_total < $this->results['total'] ){ 
					$page++;
				?>
			</tbody>
			<tfoot>
				<tr>
					<th></th>
					<th></th>
					<?php 
					for($z=$start; $z<=$end; $z++){
						$day = sprintf("%02d",$z);
						$sum_day = !empty($sum[$day]) ? number_format($sum[$day],1) : '-';
						echo '<th class="tar"><strong>'.$sum_day.'</strong></th>';
						$sum[$day] = 0;
					}
					?>
					<th class="tar"><?=(!empty($total_time) ? number_format($total_time,1) : '-')?></th>
					<th class="tar"><?=(!empty($total_price) ? number_format($total_price,1) : '-')?></th>
					<th></th>
				</tr>
			</tfoot>
		</table>
		<!-- End Page -->

		<div style="page-break-after: always"></div>

		<!-- New Page -->
		<div>
			<span class="pull-left"><strong>แผนก<?=$this->item['name']?></strong></span>
			<span class="pull-right"><strong>แผ่นที่ </strong><?=$page?>/<?=round($page_total)?></span>
		</div>
		<div class="text-center"><strong>ประจำวันที่ <?=$this->periodStr.' '.$year?></strong></div>
		<table class="table-bordered" width="100%">
			<thead>
				<tr>
					<th class="tac" width="2%">No.</th>
					<th class="tac" width="15%">ชื่อ</th>
					<?php 
					for($i=$start; $i<=$end; $i++){
						echo '<th class="tac fwb" width="5%">'.intval($i).'</th>';
					}
					?>
					<th width="10%">รวม</th>
					<th width="10%"><?=$this->item['name']?></th>
					<th width="13%">ผู้รับเงิน</th>
				</tr>
			</thead>
				<?php 
				$total = 0;
				$total_price = 0;
				$total_time = 0;
				}
				#End if 
			} 
			#End Loop
			?>
			</tbody>
			<tfoot>
				<tr>
					<th></th>
					<th></th>
					<?php 
					for($z=$start; $z<=$end; $z++){
						$day = sprintf("%02d",$z);
						$sum_day = !empty($sum[$day]) ? number_format($sum[$day],1) : '-';
						echo '<th class="tar"><strong>'.$sum_day.'</strong></th>';
					}
					?>
					<th class="tar"><?=(!empty($total_time) ? number_format($total_time,1) : '-')?></th>
					<th class="tar"><?=(!empty($total_price) ? number_format($total_price,1) : '-')?></th>
					<th></th>
				</tr>
			</tfoot>
		</table>
	</div>
</body>
</html>