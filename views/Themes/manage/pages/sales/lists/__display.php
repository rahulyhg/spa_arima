<div id="mainContainer" class="clearfix" data-plugins="main">

	<div role="content">

		<div role="toolbar">
			<div class="pvm phl">

				<ul class="ui-steps clearfix">
					<li class="anchor clearfix mg-anchor">
						<div class="lfloat mrm top-doc-logo"><div class="initials">MG</div></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">Sales</div></div></div>
					</li>
					<li>
						<label class="label">ยอดจอง</label>
						<span class="data"><a><?=$this->count[1]==0 ? '-': number_format($count[1] ,0) ?></a></span>
					</li>
					<li>
						<label class="label">ส่งมอบ</label>
						<span class="data"><a><?=$this->count[2]==0 ? '-': number_format($count[1] ,0) ?></a></span>
					</li>
					<li>
						<label class="label">ยกเลิก</label>
						<span class="data"><a>-</a></span>
					</li>
				</ul>
				
			</div>
		</div>

		<div role="main">

<?php foreach ($this->results as $value) { ?>
<div id="featured-products" class="featured-products">

	<?php  if ( !empty($value['name'])){ ?>
	<header class="featured-products_header pam">
		<h2><?=$value['name']?></h2>
	</header>
	<?php } ?>

	<table class="featured-products_table">
		<thead>
		<tr>
			<th class="name">Sales</th>
			<th class="nubmer">ยอดจอง</th>
			<th class="nubmer">ส่งมอบ</th>
			<th class="nubmer">ยกเลิก</th>
			<!-- <th class="nubmer">จำนวนลูกค้า</th>
			<th class="nubmer">นัดหมาย</th> -->
		</tr>
		</thead>
		<tbody>
		<?php 

		$count = array(1=>0,0,0);
		$total_booking = 0;
		foreach ( $value['items'] as $sale) { ?>
			<tr>
			<td class="name"><a href="<?=URL?>sales/<?=$sale['id']?>"><?=$sale['fullname']?></a></td>
			<td class="nubmer"><?=$sale['total_booking']==0 ? '-': number_format($sale['total_booking'],0) ?></td>
			<td class="nubmer">-</td>
			<td class="nubmer">-</td>
			<!-- <td class="nubmer">-</td>
			<td class="nubmer">-</td> -->
			</tr>
		<?php 
		$total_booking = $total_booking + $sale['total_booking'];
		} ?>
		</tbody>
		<tfoot>
			<tr>
				<th class="total-text">รวมทั้งหมด</th>
				<th class="nubmer"><?=$total_booking==0 ? '-': number_format($total_booking ,0) ?></th>
				<th class="nubmer">-</th>
				<th class="nubmer">-</th>
				<!-- <th><?=$count[2]==0 ? '-': number_format($count[2] ,0) ?></th>
				<th><?=$count[3]==0 ? '-': number_format($count[3] ,0) ?></th> -->
			</tr>
		</tfoot>
	</table>
</div>
<?php } ?>

		</div>
		<!-- end: main -->
	</div>
	<!-- end: content -->
</div>
<!-- end: container -->