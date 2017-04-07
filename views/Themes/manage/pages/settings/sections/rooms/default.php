<div class="ui-roomsbox-container" data-plugins="listRoomsbox">

<div class="ui-roomsbox-header phl ptl" style="position: absolute;top:0;left: 0;right: 0;z-index: 100">

<div class="setting-header cleafix">

	<div class="rfloat">

		<div class="fsss fwb fcg">Lists Status:</div>
		<ul class="ui-lists-status"><?php 

			foreach ($this->status as $key => $value) {
				echo '<li><div class="ui-color lfloat mrm" style="background-color:'.$value['color'].'"></div>'.$value['name'].'</li>';
			}
		?></ul>
		
	</div>
	<div class="setting-title"><i class="icon-building-o mrs"></i>Rooms</div>
</div>

<hr class="setting-hr">

</div>

<div class="ui-roomsbox-wrap">

	<div class="" style="position: absolute;top: 92px;left: 0;right: 0;bottom: 0">
		<div class="ui-roomsbox-floor-wrap">
			<ul class="ui-roomsbox-floor" ref="actions">
			<?php 

			$floor = $this->data['max_floor'];

			for ($j=1; $j <= $floor; $j++) { ?>
				<li><a action-floor="<?=$j?>">ชั้น <?=$j?></a></li>
			<?php }?>
			</ul>

			<!-- <div class="mtm tar fsm">
				<a>เพิ่มชั้น</a>
			</div> -->
		</div>
		<div class="ui-roomsbox-rooms" ref="main"><div style="max-width: 720px;position: relative;">
			<?php for ($j=1; $j <= $floor; $j++) { ?>
			
			<div class="ui-list-roomsbox-wrap" data-floor="<?=$j?>">
			<ul class="ui-list ui-list-roomsbox">
				
				<?php foreach ($this->data['lists'] as $key => $value) { 
					if( $value['floor'] != $j ) continue;
					?>
				<li class="booking"><div class="inner">
					<span class="number"><?=$value['number']?></span>

					<div class="control fsm cleafix">
						<a class=""><i class="icon-pencil"></i></a><a class=""><i class="icon-plus"></i></a>
					</div>

					<div class="bedroom">
						<ul class="ui-list ui-list-bedroomsbox cleafix">
						<?php if( !empty($value['bed']) ){
							foreach ($value['bed'] as $val) { ?>
							<li></li>
							<?php } 
						}
						?>
						</ul>
					</div>

					<div class="status">
						<div class="ui-timer"><?=$value['timer']==0 ? '' : $value['timer']?></div>
						<div class="ui-status" style="background-color: <?=$value['status']['color']?>"><?=$value['status']['name']?></div>
					</div>
				</div></li>
				<?php } ?>

				<!-- <?php for ($i=0; $i < 6; $i++) { ?>
					<li class="booking"><div class="inner">
						<span class="number"><?=$j?>0<?=$i?></span>

						<div class="control fsm cleafix">
							<a class=""><i class="icon-pencil"></i></a><a class=""><i class="icon-plus"></i></a>
						</div>

						<div class="bedroom">
							<ul class="ui-list ui-list-bedroomsbox cleafix">
								<li></li>
								<li></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>

						<div class="status">
							<div class="ui-timer">3:10</div>
							<div class="ui-status">Booking</div>
						</div>
					</div></li>
				<?php }?> -->

				<li class="plus"><a class="inner" href="<?=URL?>rooms/add?floor=<?=$j?>" data-plugins="dialog">+</a></li>
			</ul>
			</div>
			<?php }?>
		</div></div>
	
	</div>

</div>


</div>

