<?php

$oil = array();
$masseuse = array();
foreach ($this->lists['lists'] as $key => $value) { 

	if( in_array($value['pos_id'], array(5, 6)) ){
		$oil[] = $value;
	}
	else{
		$masseuse[] = $value;
	}
}

?>
<div class="queue-wrap" style="position: fixed;right: 0;left: 0;top: 0;bottom: 0">

	<div style="position: absolute;top: 0;bottom: 0;right: 26%;left:0px">
		<div style="position: absolute;top: 0;bottom: 0;width: 5px;background-color: #ccc;left: 60%"></div>

		<div style="position: absolute;width: 65%;left: 0;top: 0;bottom: 0;overflow-y: auto;background-color: #622524"><div class="tac">
			<div style="position: absolute;top: 15px;left: 0;right:0;text-align: center;font-size: 180%;color: #fff;text-shadow: 0 1px 0 #000">คิวพนง.บริการ นวดทั่วไป (<?=count($masseuse)?>)</div>
			<ul style="padding-top: 60px" class="ui-list ui-list-queue mini" ref="listsbox"><?php 

				foreach ($masseuse as $key => $value) { 

					$code = is_numeric($value['code'])
						? round($value['code'])
						: $value['code'];

					$name = !empty($value['nickname'])
						? $value['nickname']
						: $value['first_name'];


					$avatar = '<div class="avatar no-avatar" style="background-color:#da9595;color:#000;text-shadow:0 1px 0 rgba(255,255,255,.5)"><div class="initials">'.$code.'</div></div>';

					/*if( !empty($value['image_url']) ){
						$avatar = '<div class="avatar"><img class="img" src="'.$value['image_url'].'"></div>';
					}*/

				?><li data-id=""><div class="inner">
					<div class="number"><?= $code ?></div>
					<div class="box"><div class="box-inner clearfix" style="background-color: #000">
						
						<?=$avatar?>
						<div class="box-content">
							<!-- <h3>101</h3> -->
							<div class="name"><?=$name?></div>
						</div>
						
					</div></div>
				</div></li><?php 
				} 
			?></ul>
		</div></div>

		<!-- end: left -->
		<div style="position: absolute;width: 35%;right: 0;top: 0;bottom: 0;overflow-y: auto;background-color: #404040"><div class="tac">

			<div style="position: absolute;top: 15px;left: 0;right:0;text-align: center;font-size: 180%;text-shadow: 0 1px 0 #000;color: #fff;">คิวพนง.บริการ นวดออย (<?=count($oil)?>)</div>

			<ul style="padding-top: 60px" class="ui-list ui-list-queue mini" ref="listsbox"><?php 

				foreach ($oil as $key => $value) {

					// $code = $i;
					// $name = $i;
					$code = is_numeric($value['code'])
						? round($value['code'])
						: $value['code'];

					$name = !empty($value['nickname'])
						? $value['nickname']
						: $value['first_name'];


					$avatar = '<div class="avatar no-avatar"  style="background-color:#fff;color:#000;text-shadow:0 1px 0 rgba(255,255,255,.5)"><div class="initials">'.$code.'</div></div>';

					/*if( !empty($value['image_url']) ){
						$avatar = '<div class="avatar"><img class="img" src="'.$value['image_url'].'"></div>';
					}*/

				?><li data-id=""><div class="inner">
					<div class="number"><?= $code ?></div>
					<div class="box"><div class="box-inner clearfix" style="background-color: #000">
						
						<?=$avatar?>
						<div class="box-content">
							<!-- <h3>101</h3> -->
							<div class="name"><?=$name?></div>
						</div>
						
					</div></div>
				</div></li><?php 
				} 
			?></ul>
		</div></div>
			<!-- end: right -->
		
	</div>
	
	<div style="position: absolute;right: 0;width: 26%;top: 0;bottom: 0;background-color: #1f1f1f;border-right: 1px solid #4b4b4b;color: #fff">
		
		<div class="thedate" style="margin: 10px;" data-plugins="oclock" data-options="<?=$this->fn->stringify( array('lang'=>$this->lang->getCode() ) )?>">
			<div class="thedate-time" style="font-size: 250%">
				<div ref="time" class="time"></div>
			</div>
			<div class="thedate-date"><div ref="date" class="date"></div></div>
		</div>
		


		<div class="" style="margin: 10px;border-top:1px solid #4b4b4b;border-bottom:1px solid #4b4b4b;padding: 5px 0;">
			<h3>การทำงานของ พนง.บริการ</h3>
			<div class="fsm">ลำดับที่ 1 - <?=$this->run['total']?> จาก <?=$this->run['total']?></div>
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

				if(count($value['package']) == 1){
					$t_start = date("H:i", strtotime($value['package'][0]['item_start_date']));
					$t_end = date("H:i", strtotime($value['package'][0]['item_end_date']));
				}
				else{
					$end = count($value['package']) - 1;
					$t_start = date("H:i", strtotime($value['package'][0]['item_start_date']));
					$t_end = date("H:i", strtotime($value['package'][$end]['item_end_date']));
				}
			?>
			<li style="position: relative;margin: 10px">
				
				<div style="position: absolute;top: 50%;right: 0;text-align: right; transform: translateY(-50%);">
					<div class="fsm"><?=$t_start?> - <?=$t_end?></div>
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
						?>
					</span>
				</div></div></div>
			</li>
			<?php } ?>
		</ul>

	</div>
</div>

<!-- <div class="queue-alert">
	<div class="queue-alert-content">
		
		<div class="queue-alert-outer"><div class="queue-alert-inner"><span class="code">B16</span><span class="text">นวดออย</span></div></div>
		<div class="queue-alert-outer"><div class="queue-alert-inner"><span class="code">1</span><span class="text">นวดตัว</span></div></div>
		<div class="queue-alert-outer"><div class="queue-alert-inner"><span class="code">999</span><span class="text">นวดตัว+นวดเท้า</span></div></div>
	</div>
</div> -->

<script type="text/javascript">
	window.setTimeout('location.reload()', 3000);
</script>
