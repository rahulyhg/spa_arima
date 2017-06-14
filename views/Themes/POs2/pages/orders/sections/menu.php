<div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;overflow-y: hidden;">
		<div style="position: absolute;padding-top: 20px;padding-left: 30px;right: 18px;left: 0;background-color: rgba(0, 144, 195,.98);z-index: 5;max-width: 700px;">
			<header class="memu-tab clearfix" style="max-width: 600px;">
				<!-- <a data-type="promotion" hdata-filter="Set">Set Package</a> -->
				<a data-type="package" class="active">package</a>
			</header>
		</div>

		<div  style="position: absolute;top: 0;left: 30px;right: 0;bottom: 0;overflow-y: auto;">

		<div class="ui-effect-top" data-memu="promotion"><div class="memu-tab-content" style="padding-top: 70px;padding-bottom: 30px; padding-right: 30px">
			
			<table class="memu-table" role="menu"><tbody>
			<?php foreach ($this->promotions['lists'] as $key => $value) { ?>
				
			<?php } ?>
			</tbody></table>
		</div></div>
		<!-- end: type promotions -->


		<div class="ui-effect-top active" data-memu="package"><div class="memu-tab-content" style="padding-top: 70px;padding-bottom: 30px; padding-right: 30px">

			<ul class="ui-menu-items ui-list-v clearfix"><?php foreach ($this->package['lists'] as $key => $value) { ?>
			<li class="ui-menu-item" data-id="<?=$value['id']?>"><a class="inner clearfix"><div class="image" style=""><div class="gradient-overlay"></div></div><div class="text clearfix"><div class="title-block"><div class="category"></div><div class="title"><?=$value['name']?></div></div></div></a></li>
			<?php } ?></ul>

		</div></div>
		<!-- end: type package -->

		</div>
</div>