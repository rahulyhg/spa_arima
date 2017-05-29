<div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;overflow-y: hidden;">
		<div style="position: absolute;padding-top: 50px;padding-left: 30px;right: 16px;left: 0;background-color: rgba(245,248,250,.98);z-index: 5;max-width: 700px;">
			<header class="memu-tab clearfix" style="max-width: 600px;">
				<a data-type="package" class="active">package</a>
				<a data-type="promotion" hdata-filter="promotions">Promotions</a>
			</header>
		</div>

		<div  style="position: absolute;top: 0;left: 30px;right: 0;bottom: 0;overflow-y: auto;">

		<div class="ui-effect-top" data-memu="promotion"><div class="memu-tab-content" style="padding-top: 100px;padding-bottom: 30px; padding-right: 30px">
			
			<table class="memu-table" role="menu"><tbody>
			<?php foreach ($this->promotions['lists'] as $key => $value) { ?>
				<tr data-type="promotion" data-id="<?=$value['id']?>">
					<td class="td_box"><div class="box"></div></td>
					
					<td class="name">
						<div class="checked"><div class="inner">
							<i class="icon-check"></i>
							<span class="countVal">1</span>
						</div></div>
						<span class="fwb"><?=$value['name']?></span>
					</td>
					

					<td class="price"><?= number_format($value['total_balance'], 0)?> ฿</td>
				</tr>
				<?php } ?>
			</tbody></table>
		</div></div>
		<!-- end: type promotions -->


		<div class="ui-effect-top active" data-memu="package"><div class="memu-tab-content" style="padding-top: 100px;padding-bottom: 30px; padding-right: 30px">
		<table class="memu-table" role="menu"><tbody>

			<?php foreach ($this->package['lists'] as $key => $value) { ?>
			<tr data-type="package" data-id="<?=$value['id']?>">
				<td class="td_box"><div class="box"></div></td>
				
				<td class="name">
					<div class="checked"><div class="inner">
						<i class="icon-check"></i>
						<span class="countVal">1</span>
					</div></div>
					<span class="fwb"><?=$value['name']?></span>
				</td>
				
				<td class="time"><?=$value['qty'];?></td>
				<td class="time"><?=$value['unit'];?></td>

				<td class="price"><?= number_format($value['price'], 0)?> ฿</td>
				
			</tr>
			<?php } ?>


		</tbody></table>

		</div></div>
		<!-- end: type package -->

		</div>
</div>