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