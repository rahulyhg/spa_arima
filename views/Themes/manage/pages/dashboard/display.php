<?php require 'init.php'; ?>

<div id="mainContainer" class="clearfix" data-plugins="main">

	<div role="content">
		<?php require 'sections/toolbar.php'; ?>
		<!-- End: toolbar -->

		<div role="main">

		<div class="mhl">

		<div class="row-fluid clearfix">
			
			<div class="span8">
				
				<!-- end: row-fluid -->
				<?php require 'sections/table-receipt.php'; ?>
				
				<!-- end: row-fluid -->

			</div>
			<!-- end: span8 -->
			<div class="span4">

				<div class="ui-card u-boxShadow-2 mvl bg-orange">
					<div class="ui-card_header clearfix">
	
						<h3 class="ui-card_headerTitle">สรุปยอดรายรับ</h3>
						<div class="ui-card_headerDesc"><?=$this->date_str?></div>
					</div>
					<div class="ui-card_content">
				    	<div class="ui-card_number"><?=number_format($this->revenue['sum_balance'])?> ฿</div>
					</div>
				</div>

				<div class="ui-card u-boxShadow-2 mvl bg-red">
					<div class="ui-card_header clearfix">

						<h3 class="ui-card_headerTitle">ยอดจอง</h3>
						<div class="ui-card_headerDesc"><?=$this->date_str?></div>
					</div>
					<div class="ui-card_content">
				    	<div class="ui-card_number"><?=number_format($this->booking['total'])?> คน</div>
					</div>
				</div>
				
				<div class="ui-card u-boxShadow-2 mvl bg-purple">
					<div class="ui-card_header clearfix">

						<h3 class="ui-card_headerTitle">ยอดเข้าใช้บริการ</h3>
						<div class="ui-card_headerDesc"><?=$this->date_str?></div>
					</div>
					<div class="ui-card_content">
				    	<div class="ui-card_number"><?=number_format($this->service[0]['total_customer'])?> คน</div>
					</div>
				</div>
				
				<div class="ui-card u-boxShadow-2 mvl">
					<div class="ui-card_header clearfix">
						<a class="rfloat" href="<?=URL?>customers">More info <i class="icon-arrow-circle-right"></i></a>
						<h3 class="ui-card_headerTitle">จำนวนสมาชิก</h3>
						
					</div>
					<div class="ui-card_content">
						<div class="ui-card_number">
							<span class="ui-status" style="background-color: rgb(11, 195, 57);">RUN</span> <?=number_format($this->customers['total_run'])?>
						</div>
						<div class="ui-card_number">
							<span class="ui-status" style="background-color: rgb(219, 21, 6);">EXPIRED</span> <?=number_format($this->customers['total_expired'])?>
						</div>
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
