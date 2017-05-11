<div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;overflow-y: hidden;">
		<div style="position: absolute;padding-top: 30px;padding-left: 30px;right: 0;left: 0;background-color: rgba(245,248,250,.98);z-index: 5;max-width: 700px;">
			<header class="memu-tab clearfix" style="max-width: 600px;">
				<a data-type="package" class="active">package</a>
				<a data-type="promotions" hdata-filter="promotions">Promotions</a>
			</header>
		</div>

		<div style="position: absolute;top: 0;left: 30px;right: 0;bottom: 0;overflow-y: auto;"><div style="padding-top: 65px;padding-bottom: 30px; padding-right: 30px">
		<table class="memu-table"><tbody>

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
</div>