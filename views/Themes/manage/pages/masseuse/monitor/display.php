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
<div class="queue-wrap pal" style="padding-top:0px">


<div class="" style="position: relative;">
	<div style="position: absolute;top: 0;bottom: 0;width: 5px;background-color: #ccc;left: 58%"></div>

	<div class="row-fluid clearfix" >

		<div class="span7">
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

	?><li data-id="<?=$value['job_id']?>"><div class="inner"><a href="<?=URL?>masseuse/skill/<?=$value['id']?>" data-plugins="dialog">
		<div class="number"><?= $code ?></div>
		<div class="box"><div class="box-inner">
			
			<?=$avatar?>
			<div class="box-content">
				<!-- <h3>101</h3> -->
				<div class="name"><?=$name?></div>
			</div>
			
		</div></div>
	</div></a></li><?php 
	} 
?></ul>

		</div>
		<!-- end: span8 -->
		<div class="span5">

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

	?><li data-id="<?=$value['job_id']?>"><div class="inner"><a href="<?=URL?>masseuse/skill/<?=$value['id']?>" data-plugins="dialog">
		<div class="number"><?= $code ?></div>
		<div class="box"><div class="box-inner">
			
			<?=$avatar?>
			<div class="box-content">
				<!-- <h3>101</h3> -->
				<div class="name"><?=$name?></div>
			</div>
			
		</div></div>
	</div></a></li><?php 
	} 
?></ul>
		
		</div>
		<!-- end: span4 -->
	</div>

</div>
</div>
