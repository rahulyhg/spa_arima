<div class="phl ptl" style="position: absolute;top:0;left: 0;right: 0">

<div class="setting-header cleafix">

	<div class="rfloat">

		<div>
			<div class="fsss fwb fcg">Lists Status:</div>
			<ul class="ui-lists-status">
				<li><div class="ui-color lfloat mrm" style="background-color:#F44336"></div>Booking</li>
				<li><div class="ui-color lfloat mrm" style="background-color:#F44336"></div>Booking</li>
			</ul>
		</div>
	</div>
	<div class="setting-title"><i class="icon-building-o mrs"></i>Rooms</div>
</div>

<hr class="setting-hr">

</div>



<div class="ui-roomsbox-wrap">

	<div class="" style="position: absolute;top: 92px;left: 0;right: 0;bottom: 0">
		<div class="ui-roomsbox-floor-wrap">
			<ul class="ui-roomsbox-floor">
			<?php for ($j=1; $j <= 4; $j++) { ?>
				<li><a>ชั้น <?=$j?></a></li>
			<?php }?>
			</ul>

			<!-- <div class="mtm tar fsm">
				<a>เพิ่มชั้น</a>
			</div> -->
		</div>
		<div class="ui-roomsbox-rooms"><div style="max-width: 720px;">
			<?php for ($j=1; $j <= 4; $j++) { ?>
			
			<ul class="ui-list ui-list-roomsbox" data-room="<?=$j?>">
				

				<?php for ($i=0; $i < 6; $i++) { ?>
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
				<?php }?>

				<li class="plus pts"><a class=""><i class="icon-plus"></i><span>เพิ่มห้อง</span></a></li>
			</ul>
			<?php }?>
		</div></div>
	
	</div>

</div>


