<?php

require 'init.php';

?><div id="mainContainer" class="profile clearfix" data-plugins="main"><div id="customer-profile">

	<?php require 'left.php'; ?>

	<div role="content" class="has-toolbar">
		
		<div role="toolbar">
		<?php include "sections/toolbar.php"; ?>
		</div>
		<!-- End: toolbar -->

		<div role="main" class="profile-content">
			<?php include "sections/cars.php"; ?>
		</div>
		<!-- end: main -->

	</div>
	<!-- end: content -->

</div></div>