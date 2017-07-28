<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
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
			font-size:16pt;
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
		th, td {
			padding: 15px;
		}
		p{ font-size: 22pt; }
	</style>
</head>
<!-- onload="window.print();" -->
<body onload="window.print();">
	<div align="center">
		<p><strong>ใบเปรียบเทียบรายได้กับค่าจ้างหมอเปอร์เซ็นต์ ร้านอะริมะ</strong></p>
		<p><strong>ประจำวันที่ <?=$this->periodStr?></strong></p>
	</div>
	<table width="100%" align="center" class="table-bordered">
		<thead>
			<tr class="tac">
				<th width="10%">ลำดับ</th>
				<th width="35%">รายการ</th>
				<th width="20%">รายได้</th>
				<th width="20%">ค่าจ้างหมอ</th>
				<th width="15%">อัตรา %</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$i = 0;
			$total = 0;
			$wage = 0;
			$total_parttime = 0;
			$wage_parttime = 0;
			foreach ($this->results['lists'] as $key => $value) {

				if( empty($value['wage_price']) ) continue;
				$i++;

				$total += $value['total_balance'];
				$wage += $value['total_wage'];
				$total_parttime += $value['parttime']['total_balance'];
				$wage_parttime += $value['parttime']['total_wage'];
				?>
				<tr>
					<td class="tac"><?=$i?></td>
					<td class="tal">แผนก <?=$value['name']?></td>
					<td class="tac"><?=(!empty($value['total_balance']) ? $value['total_balance'] : '-')?></td>
					<td class="tar"><?=(!empty($value['total_wage']) ? number_format($value['total_wage'],2) : '-')?></td>
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
		</table>
		<table width="100%" align="center">
			<tr>
				<td width="10%"></td>
				<td width="35%"></td>
				<td width="20%" class="tac"><?=number_format($total,2);?></td>
				<td width="20%" class="tar"><?=number_format($wage,2);?></td>
				<td width="15%"></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td class="tac"><I><U>หัก</U></I> 10%</td>
				<td class="tac">
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
				</td>
				<td></td>
			</tr>
		</table>
		<table width="100%" align="center" class="table-bordered">
			<tbody>
				<tr>
					<th class="tac" width="10%"></th>
					<th class="tac" width="35%">รวม</th>
					<th class="tac" width="20%"><?=number_format($total,2)?></th>
					<th class="tac" width="20%">
						<?php
						$total_wage = $wage-$persent;
						echo number_format($total_wage, 2);
						?>
					</th>
					<th class="tac" width="15%">
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
			</tbody>
		</table>
	</body>
</html>
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