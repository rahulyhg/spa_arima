<?php

require 'init.php';

?><div id="mainContainer" class="clearfix" data-plugins="main">

<form method="post" action="<?=URL?>products/save_item" data-plugins="carcreate" class="js-submit-form form-insert form-vertical">

	<?php // require 'left.php'; 

		if( !empty($this->item['id']) ){
			$title = 'เพิ่มสินค้า '.$this->item['name'];
		}
	?>

	<div role="content">
		
		<!-- End: toolbar -->
		<div role="toolbar">
			<div class="pal pbs"><h2><?=$title?></h2></div>
		</div>

		<div role="main" style="position: relative">

			<div style="position: absolute;left: 0;top: 0;bottom: 0;overflow-y: auto;width: 300px">
				
				<div class="pal">
					<?=$form->html();?>
				</div>

			</div>

			<div id="car-items" style="position: absolute;left: 300px;top: 0;bottom: 0;right: 0;overflow-y: auto;">
				<div class="pal" style="max-width: 720px;padding-top: 30px;padding-bottom: 20px;">
					<div class="ui-items-lists" role="listbox"></div>

					<div class="empty" style="max-width: 720px;">
				        <div class="empty-icon"><i class="icon-car"></i></div>
				        <div class="empty-title"><label for="count_value">ป้อนจำนวนสินค้า</label></div>
					</div>
				</div>
				
			</div>
			
		</div>
		<!-- end: main -->

		<!-- footer -->
		<div role="footer">
			<div class="pam clearfix" style="max-width: 1010px">
				<a class="lfloat btn" href="<?=URL?>products/<?=$this->item['id']?>">ยกเลิก</a>
				<button type="submit" class="rfloat btn btn-blue">Save</button>
			</div>
		</div>
	</div>
	<!-- end: content -->

</form>
<!-- end: form -->

</div>
<!-- end: #mainContainer -->