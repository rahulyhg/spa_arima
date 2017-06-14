<div id="mainContainer" class="clearfix hasLeft" data-plugins="main">
	
	<div role="left" data-w-percent="50" style="background-color: #f5f5f5;box-shadow: 0 0 3px rgba(0,0,0,.3);color: #111">
	<?php require "sections/bill.php"; ?>
	</div>
	<div role="content">
		<div role="main" style="position: relative;">
			
			<div class="ui-effect-top" data-global="menu">
				<?php require "sections/menu.php"; ?>
			</div>

			<div class="ui-effect-top" data-global="pay">
				<?php require "sections/pay.php"; ?>
			</div>

			<div class="ui-effect-top" data-global="detail">
				<?php require "sections/detail.php"; ?>
			</div>
	
		</div>
	</div>

</div>