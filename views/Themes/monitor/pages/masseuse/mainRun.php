	<div class="" style="margin: 10px;border-top:1px solid #4b4b4b;border-bottom:1px solid #4b4b4b;padding: 5px 0;">
		<h3>การทำงานของ พนง.บริการ</h3>
		<?php if( !empty($this->run['total']) ) { ?>
		<div class="fsm">ลำดับที่ 1 - <?=$this->run['total']?> จาก <?=$this->run['total']?></div>
		<?php }else{ ?>
		<div class="fsm">ไม่มีข้อมูลการทำงาน</div>
		<?php } ?>
	</div>
	<ul>
		<?php 
		foreach ($this->run['lists'] as $key => $value) { 
			$code = is_numeric($value['code'])
			? round($value['code'])
			: $value['code'];

			$name = !empty($value['nickname'])
			? $value['nickname']
			: $value['first_name'];

			$avatar = '<div class="avatar no-avatar lfloat mrm"><div class="initials">'.$code.'</div></div>';

			if( !empty($value['image_url']) ){
				$avatar = '<div class="avatar lfloat mrm"><img class="img" src="'.$value['image_url'].'"></div>';
			}

			// if(count($value['package']) == 1){
			// 	$t_start = date("H:i", strtotime($value['package'][0]['item_start_date']));
			// 	$t_end = date("H:i", strtotime($value['package'][0]['item_end_date']));
			// }
			// else{
			// 	$end = count($value['package']) - 1;
			// 	$t_start = date("H:i", strtotime($value['package'][0]['item_start_date']));
			// 	$t_end = date("H:i", strtotime($value['package'][$end]['item_end_date']));
			// }
			?>
			<li style="position: relative;margin: 10px">
				
				<div style="position: absolute;top: 50%;right: 0;text-align: right; transform: translateY(-50%);">
					<!-- <div class="fsm"><?=$t_start?> - <?=$t_end?></div> -->
					<div class="ui-status">กำลังทำงาน</div>
				</div>
				<div class="anchor clearfix"><?=$avatar?><div class="content"><div class="spacer"></div><div class="massages">
				<div>
					<span class="ui"><?=$code?></span>

				</div>
				<span>
					<?php 
					$package = '';
					$last_id = '';
					foreach ($value['package'] as $pack) {
						if( $last_id == $pack['pack_id'] ) continue;
						$last_id = $pack['pack_id'];
						$package .= !empty($package) ? "+" : '';
						$package .= $pack['pack_name'];
					}

					echo $package;
					?>
				</span>
			</div></div></div>
		</li>
		<?php } ?>
	</ul>