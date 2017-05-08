
<div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;overflow-y: hidden;">
		<div style="position: absolute;padding-top: 30px;padding-left: 30px;right: 0;left: 0;background-color: rgba(245,248,250,.98);z-index: 5;max-width: 700px;">
			<header class="memu-tab clearfix" style="max-width: 600px;">
				<a class="active">package</a>
				<a hdata-filter="promotions">Promotions</a>
			</header>
		</div>

		<div style="position: absolute;top: 0;left: 30px;right: 0;bottom: 0;overflow-y: auto;"><div style="padding-top: 65px;padding-bottom: 30px; max-width: 600px;">
		<table class="memu-table"><tbody>

			<?php foreach ($this->package['lists'] as $key => $value) {

				$unit_time = 'TIME';
				$timer = $value['timer'];
				if ( empty($value['is_time']) ){

					if( $value['timer']>=60 ){
						$timer = $timer/60; 
						$unit_time = 'HOUR';
					}
					else{
						$unit_time = 'MINUTSE';
					}
				}

			?>
			<tr>
				<td class="td_box"><div class="box"></div></td>
				
				<td class="name">
					<div class="checked"><div class="inner">
						<i class="icon-check"></i>
						<span class="countVal">1</span>
					</div></div>
					<span class="fwb"><?=$value['name']?></span>
				</td>
				
				<td class="time"><?php

				

				echo $timer;

				?></td>
				<td class="time"><?php

				echo $unit_time;

				?></td>

				<td class="price"><?= number_format($value['price'], 0)?> ฿</td>
			</tr>
			<?php } ?>


		</tbody></table>
		</div></div>
</div>