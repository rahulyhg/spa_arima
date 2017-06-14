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

// print_r($masseuse); die;

?>
<div class="queue-wrap" style="position: fixed;right: 0;left: 0;top: 0;bottom: 0">


	<div style="position: absolute;top: 0;bottom: 0;width: 5px;background-color: #ccc;left: 60%"></div>

	

		<div style="position: absolute;width: 60%;left: 0;top: 0;bottom: 0;overflow-y: auto;"><div class="pal tac">
<ul class="ui-list ui-list-queue" ref="listsbox"><?php 

	foreach ($masseuse as $key => $value) { 

		$code = is_numeric($value['code'])
			? round($value['code'])
			: $value['code'];

		$name = !empty($value['nickname'])
			? $value['nickname']
			: $value['first_name'];


		$avatar = '<div class="avatar no-avatar"><div class="initials">'.$code.'</div></div>';

		if( !empty($value['image_url']) ){
			$avatar = '<div class="avatar"><img class="img" src="'.$value['image_url'].'"></div>';
		}

	?><li data-id="<?=$value['job_id']?>"><div class="inner">
		<div class="number"><?= $code ?></div>
		<div class="box"><div class="box-inner">
			
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
		<div style="position: absolute;width: 40%;right: 0;top: 0;bottom: 0;overflow-y: auto;"><div class="pal tac">
<ul class="ui-list ui-list-queue" ref="listsbox"><?php 

	foreach ($oil as $key => $value) { 

		$code = is_numeric($value['code'])
			? round($value['code'])
			: $value['code'];

		$name = !empty($value['nickname'])
			? $value['nickname']
			: $value['first_name'];


		$avatar = '<div class="avatar no-avatar"><div class="initials">'.$code.'</div></div>';

		if( !empty($value['image_url']) ){
			$avatar = '<div class="avatar"><img class="img" src="'.$value['image_url'].'"></div>';
		}

	?><li data-id="<?=$value['job_id']?>"><div class="inner">
		<div class="number"><?= $code ?></div>
		<div class="box"><div class="box-inner">
			
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
<script type="text/javascript">
	
	window.setTimeout('location.reload()', 3000);
	
</script>
