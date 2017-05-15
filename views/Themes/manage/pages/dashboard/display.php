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

				<div class="ui-card u-boxShadow-2 mvl bg-green">
					<div class="ui-card_header clearfix">
						<a class="rfloat" href="<?=URL?>reports?type=income">More info <i class="icon-arrow-circle-right"></i></a>
						<h3 class="ui-card_headerTitle">สรุปยอดรายรับ</h3>
						<div class="ui-card_headerDesc"><?=$this->date_str?></div>
					</div>
					<div class="ui-card_content">
						<?php $sum_price = !empty($this->revenue['sum_price']) ? $this->revenue['sum_price']:0;?>
						<?php $sum_discount = !empty($this->revenue['sum_discount']) ? $this->revenue['sum_discount']:0;?>
				    	<div class="ui-card_number"><?=number_format($sum_price-$sum_discount)?> ฿</div>
					</div>
				</div>

				<div class="ui-card u-boxShadow-2 mvl bg-green">
					<div class="ui-card_header clearfix">
						<a class="rfloat" href="<?=URL?>reports?type=income">More info <i class="icon-arrow-circle-right"></i></a>
						<h3 class="ui-card_headerTitle">ยอดขาย</h3>
						<div class="ui-card_headerDesc"><?=$this->date_str?></div>
					</div>
					<div class="ui-card_content">
						<?php $sum_price = !empty($this->revenue['sum_price']) ? $this->revenue['sum_price']:0;?>
						<?php $sum_discount = !empty($this->revenue['sum_discount']) ? $this->revenue['sum_discount']:0;?>
				    	<div class="ui-card_number"><?=number_format($sum_price-$sum_discount)?> ฿</div>
					</div>
				</div>

				<div class="ui-card u-boxShadow-2 mvl bg-green">
					<div class="ui-card_header clearfix">
						<a class="rfloat" href="<?=URL?>reports?type=income">More info <i class="icon-arrow-circle-right"></i></a>
						<h3 class="ui-card_headerTitle">ยอดจอง</h3>
						<div class="ui-card_headerDesc"><?=$this->date_str?></div>
					</div>
					<div class="ui-card_content">
				    	<div class="ui-card_number"><?=number_format($this->booking['total'])?> ฿</div>
					</div>
				</div>
				
				<div class="ui-card u-boxShadow-2 mvl bg-green">
					<div class="ui-card_header clearfix">
						<a class="rfloat" href="<?=URL?>reports?type=income">More info <i class="icon-arrow-circle-right"></i></a>
						<h3 class="ui-card_headerTitle">ยอดเข้าใช้บริการ</h3>
						<div class="ui-card_headerDesc"><?=$this->date_str?></div>
					</div>
					<div class="ui-card_content">
				    	<div class="ui-card_number"><?=number_format($this->service['total_customer'])?> ฿</div>
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
