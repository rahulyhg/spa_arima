<?php


$options = array(
	'id' => $this->id,
	'load_orders_url' => URL.'booking/lists?view_stype=bucketed',
	'load_create_url' => URL.'booking/create',
	'load_profile_url' => URL.'booking/profile',
	'URL' => URL.'booking/',
	// 'count' => $this->count
);

?><div id="mainContainer" class="clearfix" data-plugins="main">

<div id="booking" class="datalist-container" data-plugins="datalist" data-options="<?=$this->fn->stringify( $options )?>">

	<section class="datalist-left" role="left" data-width="350">
		<?php require 'left.php'; ?>
	</section>
	<!-- End: Left -->
	<div role="content" class="datalist-content has-empty">
		<div class="datalist-main-container" role="main">
			<div class="datalist-main" role="profile"></div>
			<div class="datalist-alert">
				<div class="datalist-loading">
					<div class="datalist-loading-icon loader-spin-wrap"><div class="loader-spin"></div></div>
					<div class="datalist-loading-text">Loading...</div> 
				</div>
			</div>
		</div>
		<!-- End: main -->
	</div>
	<!-- End: content -->
</div>

</div>
<!-- End Container -->