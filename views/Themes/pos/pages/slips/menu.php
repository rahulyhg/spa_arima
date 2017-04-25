
<div style="padding-top: 30px;max-width: 600px;padding-left: 30px">
		<header class="memu-tab clearfix">
			<a class="active">package</a>
			<a hdata-filter="promotions">Promotions</a>
		</header>
		<table class="memu-table"><tbody>
			<?php foreach ($this->package['lists'] as $key => $value) { ?>
			<tr>
				<td class="td_box"><div class="box"></div></td>
				<td class="ID"><?=$value['code']?></td>
				<td class="name fwb"><?=$value['name']?></td>
				
				<td class="time"><?php

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

				echo $timer;

				?></td>
				<td class="time"><?php

				echo $unit_time;

				?></td>

				<td class="price"><?= number_format($value['price'], 0)?> ฿</td>
			</tr>
			<?php } ?>
		</tbody></table>
	
</div>