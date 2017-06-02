<?php

$taps = array();
$taps[] = array('id'=>'account', 'name'=>$this->lang->translate('Account'));
$taps[] = array('id'=>'basic', 'name'=>$this->lang->translate('Basic Information'));
$taps[] = array('id'=>'password', 'name'=>$this->lang->translate('Password'));

?><div id="mainContainer" class="clearfix" data-plugins="main">

	<div role="content">
		

		<div role="main">

			<div class="settings multi">
				<ul class="settingsAccordion">
				<?php foreach ($taps as $key => $value) { 

					$cls = '';
					if( $this->tap == $value['id'] ){
						$cls = ' openPanel';
					}
					?>
					<li class="settingsListItem<?=$cls?>">

						<a class="settingsListLink clearfix">
							<div class="rfloat">
								<i class="upimized icon-arrow-up"></i>
								<i class="downimized icon-arrow-down"></i>
							</div>

							<h3 class="settingsListItemLabel"><?=$value['name']?></h3>

							
						</a>
						<div class="content">
							<?php require "forms/{$value['id']}.php"; ?>
						</div>
					</li>
				<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('.settingsListLink').click( function () {
		
		var $parent = $(this).parent();

		if( $parent.hasClass('openPanel') ){
			$parent.removeClass('openPanel');
		}
		else{
			$parent.addClass('openPanel').siblings().removeClass('openPanel');
		}
	} )
</script>