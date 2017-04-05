<?php require 'init.php'; ?>

<div id="mainContainer" class="clearfix" data-plugins="main">

	<div role="content">
		<?php require 'sections/toolbar.php'; ?>
		<!-- End: toolbar -->

		<div role="main">

		<div class="mhl">

		<div class="row-fluid clearfix">
			
			<div class="span8">
				<div class="row-fluid clearfix mvl">
					<div class="span4">
						<div class="ui-card u-boxShadow-2">
							<div class="ui-card_header">
						        <h3 class="ui-card_headerTitle">ยอดขาย</h3>
						        <div class="ui-card_headerDesc"><?=$this->date_str?></div>
						    </div>
						    <div class="ui-card_content">
						    	<div class="ui-card_number"><?=$this->total_finish['total']?></div>
						    </div>

						</div>
					</div>

					<div class="span4">
						<div class="ui-card u-boxShadow-2">
							<div class="ui-card_header">
						        <h3 class="ui-card_headerTitle">ยอดจอง</h3>
						        <div class="ui-card_headerDesc"><?=$this->date_str?></div>
						    </div>
						    <div class="ui-card_content">
						    	<div class="ui-card_number"><?=$this->total_booking['total']?></div>
						    </div>
						</div>
					</div>

					<div class="span4">
						<div class="ui-card u-boxShadow-2">
							<div class="ui-card_header">
						        <h3 class="ui-card_headerTitle">ถอนจอง</h3>
						        <div class="ui-card_headerDesc"><?=$this->date_str?></div>
						    </div>
						    <div class="ui-card_content">
						    	<div class="ui-card_number"><?=$this->total_cancel['total']?></div>
						    </div>
						</div>
					</div>
				</div>

				<div class="row-fluid clearfix mvl">
					

					<div class="span4">
						<div class="ui-card u-boxShadow-2">
							<div class="ui-card_header">
						        <h3 class="ui-card_headerTitle">ลูกค้าใหม่</h3>
						        <div class="ui-card_headerDesc"><?=$this->date_str?></div>
						    </div>
						    <div class="ui-card_content">
						    	<div class="ui-card_number"><?=$this->total_customers['total']?></div>
						    </div>
						</div>
					</div>

					<div class="span4">
						<div class="ui-card u-boxShadow-2">
							<div class="ui-card_header">
						        <h3 class="ui-card_headerTitle">เข้าใช้บริการ</h3>
						        <div class="ui-card_headerDesc"><?=$this->date_str?></div>
						    </div>
						    <div class="ui-card_content">
						    	<div class="ui-card_number"><?=$this->total_services['total']?></div>
						    </div>
						</div>
					</div>
				</div>
				<!-- end: row-fluid -->

				<div class="row-fluid clearfix mvl">

					<div class="span4">
						<div class="ui-card u-boxShadow-2">
							<div class="ui-card_header">
						        <h3 class="ui-card_headerTitle">รถยนต์คงเหลือ</h3>
						        <div class="ui-card_headerDesc"><?=$this->date_str?></div>
						    </div>
						    <div class="ui-card_content">
						    	<div class="ui-card_number"><?=$this->total_products['sum_balance']?></div>
						    </div>
						</div>
					</div>

					<div class="span4">
						<div class="ui-card u-boxShadow-2">
							<div class="ui-card_header">
						        <h3 class="ui-card_headerTitle">รถยนต์ที่ต้องสั่งเพิ่ม</h3>
						        <div class="ui-card_headerDesc"><?=$this->date_str?></div>
						    </div>
						    <div class="ui-card_content">
						    	<div class="ui-card_number"><?=$this->total_products['sum_ordertotal']?></div>
						    </div>
						</div>
					</div>
				</div>
				<!-- end: row-fluid -->

				<div class="clearfix mvl">
					<div class="ui-card u-boxShadow-2">
						<div class="ui-card_header">
					        <h3 class="ui-card_headerTitle">พนักงานขาย</h3>
					        <div class="ui-card_headerDesc"><?=$this->date_str?></div>
					    </div>
					    <div class="ui-card_content">
					    	<div class="ui-card_tableWrap">
					    	<table class="ui-card_table">

					    		<thead>
					    		<tr>
					    			<th rowspan="2" class="name">ชื่อ</th>
					    			<th colspan="3">สถานะ</th>
					    		</tr>
					    		<tr>
					    			<th class="status">ยอดจอง</th>
					    			<th class="status">ยอดขาย</th>
					    			<th class="status">ถอนจอง</th>
					    		</tr>
					    		</thead>
					    		<tbody>
					    		<?php foreach ($this->total_sale['lists'] as $key => $value) { ?>
					    		<tr>
					    			<td class="name"><a href="<?=URL?>sales/<?=$value['id']?>"><?=$value['fullname']?></a></td>
					    			<td class="status"><?=$value['total_booking']==0 ? '-': number_format($value['total_booking'],0)?></td>
					    			<td class="status"><?=$value['total_finish']==0 ? '-': number_format($value['total_finish'],0)?></td>
					    			<td class="status"><?=$value['total_cancel']==0 ? '-': number_format($value['total_cancel'],0)?></td>
					    		</tr>
					    		<?php } ?>
					    		</tbody>
					    	</table>
					    	</div>
					    </div>
					</div>

				</div>

			</div>
			<!-- end: span8 -->
			<div class="span4">

				<div class="ui-card u-boxShadow-2 mvl bg-green">
					<div class="ui-card_header clearfix">
						<a class="rfloat" href="<?=URL?>reports?type=income">More info <i class="icon-arrow-circle-right"></i></a>
						<h3 class="ui-card_headerTitle">ยอดขายรถยนต์</h3>
						<div class="ui-card_headerDesc"><?=$this->date_str?></div>
					</div>
					<div class="ui-card_content">
				    	<div class="ui-card_number"><?=number_format($this->total_finish['total_net_price'] + $this->total_finish['total_pro_price'])?> ฿</div>
					</div>
				</div>

				<div class="ui-card u-boxShadow-2 mvl bg-blue">
					<div class="ui-card_header clearfix">
						<a class="rfloat" href="<?=URL?>reports?type=income">More info <i class="icon-arrow-circle-right"></i></a>
				        <h3 class="ui-card_headerTitle">ยอดรับเงินจอง + เงินดาวน์</h3>
				        <div class="ui-card_headerDesc"><?=$this->date_str?></div>
				    </div>
				    <div class="ui-card_content">
				    	<div class="ui-card_number"><?=number_format($this->total_price['total_net_price'])?> ฿</div>
				    </div>
				</div>

				<div class="ui-card u-boxShadow-2 mvl bg-orange">
					<div class="ui-card_header clearfix">
						<a class="rfloat" href="<?=URL?>reports?type=income">More info <i class="icon-arrow-circle-right"></i></a>
				        <h3 class="ui-card_headerTitle">ยอดรับเงินซื้อสด</h3>
				        <div class="ui-card_headerDesc"><?=$this->date_str?></div>
				    </div>
				    <div class="ui-card_content">
				    	<div class="ui-card_number"><?=number_format($this->total_cash['total_net_price'] + $this->total_cash['total_pro_price'])?> ฿</div>
				    </div>
				</div>

				<div class="ui-card u-boxShadow-2 mvl bg-purple">
					<div class="ui-card_header clearfix">
						<a class="rfloat" href="<?=URL?>reports?type=income">More info <i class="icon-arrow-circle-right"></i></a>
				        <h3 class="ui-card_headerTitle">ยอดรอรับเงินสดจากลูกค้า</h3>
				        <div class="ui-card_headerDesc"><?=$this->date_str?></div>
				    </div>
				    <div class="ui-card_content">
				    	<div class="ui-card_number"><?=number_format($this->total_wait['total_pro_price'] - $this->total_wait['total_net_price'])?> ฿</div>
				    </div>
				</div>

				<div class="ui-card u-boxShadow-2 mvl bg-red">
					<div class="ui-card_header clearfix">
						<a class="rfloat" href="<?=URL?>reports?type=income">More info <i class="icon-arrow-circle-right"></i></a>
				        <h3 class="ui-card_headerTitle">ยอดรอรับเงินไฟแนนซ์</h3>
				        <div class="ui-card_headerDesc"><?=$this->date_str?></div>
				    </div>
				    <div class="ui-card_content">
				    	<div class="ui-card_number"><?=number_format($this->total_booking['total_finance'])?> ฿</div>
				    </div>
				</div>
			</div>
			<!-- end: span4 -->
		</div>
		<!-- en: row -->

		</div>
		<!-- end: pal -->
		
		</div>
		<!-- end: main -->

	</div>
	<!-- end: content -->

</div>
<!-- end: mainContainer -->
