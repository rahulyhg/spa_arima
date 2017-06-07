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
<div class="queue-wrap pal" style="padding-top:90px" data-plugins="jopQueue">

<div style="position: fixed;top:48px;
left: 0;right: 16px;background-color: rgba(245,248,250,.98);z-index: 100;"><div class="ptl pbs clearfix" style="padding-left: 50px;padding-right: 50px;padding-top: 40px">

		<form action="<?=URL?>pos/queue" method="post">
			<table>
				<tr>
					<td>
						<input type="date" name="date" class="inputtext js-date" style="background-color: #fff" value="<?=$this->date?>" data-lang="<?=$this->lang->getCode()?>">
					</td>
					<td>
						<input type="text" name="code" class="inputtext input-search" maxlength="100" placeholder="Check In" style="background-color: #fff" autofocus>
					</td>
					<td>
						<button class="btn btn-blue">Check In</button>
					</td>
					<td style="width: 100%">
					<?php if( !empty($masseuse) ) { ?>
						<a href="<?=URL?>masseuse/cancelAll<?=(isset($_REQUEST['date']) ? '?date='.$_REQUEST['date'] : '')?>" data-plugins="dialog" class="btn btn-red rfloat">Cancel All</a>
					<?php } ?>
					</td>
				</tr>
			</table>
		</form>


	</div>
</div>
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

	?><li data-id="<?=$value['job_id']?>"><div class="inner"><a href="<?=URL?>masseuse/skill/<?=$value['id']?><?=(isset($_REQUEST['date']) ? '?date='.$_REQUEST['date'] : '')?>" data-plugins="dialog">
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

<script type="text/javascript">
	
	$('.js-date').datepicker({
		lang: $('.js-date').data('lang'),
		onSelected: function ( date  ) {

			window.location = "<?=URL.'pos/queue'?>" + "?date=" + PHP.dateJStoPHP(date);
			// console.log( data, PHP.dateJStoPHP(data.date.selected) );
		}
	});
</script>