<div class="queue-wrap" style="position: fixed;right: 0;left: 0;top: 0;bottom: 0">
	<div class="pal">
	<ul class="ui-list ui-list-queue" ref="listsbox">
	<?php for($i=0; $i<24; $i++) { ?>
		<li data-id="">
			<div class="inner">
				<div class="box">
					<div class="box-inner">
						<div class="box-content">
							<div class="name"><?=$i?></div>
						</div>
					</div>
				</div>
			</div>
		</li>
	<?php } ?>
	</ul>
	</div>
</div>