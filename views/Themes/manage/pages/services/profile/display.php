<?php 

require 'init.php';

?><form class="form-insert form-orders" action="<?=URL?>orders/send/">

	<div class="datalist-main-header">
		<div class="clearfix">
			<div class="rfloat">
		        <a title="Close" class="btn js-cancel"><i class="icon-remove mrs"></i>ปิด</a>
		    </div>

			<div class="title">
				<h2><i class="icon-file-text-o mrs"></i>Services</h2>
			</div>
		</div>
		<!-- <div class="mts"><?php require 'sections/date.php'; ?></div> -->
	</div>
	<!-- slipPaper-header -->

	<div class="datalist-main-content">
		<div id="settingsAccordion" class="settingsAccordion"><?php
		foreach ($list as $key => $value) {

			echo '<section id="order_'.$value['section'].'_fieldset" class="settingsForm" data-section="'.$value['section'].'">';

			echo '<div class="settingsLabel clearfix">'; ?>

				<table class="settingsLabelTable"><tbody><tr>
					<th class="label"><h3><?=$value['label']?></h3></th>
					<td class="data"><?=$value['data']?></td>
					<td class="actions"></td>
				</tr></tbody></table>
			<?php 
			echo '</div>';
			echo '<div class="settingsContent">';
				require 'sections/'.$value['section'].'.php';
			echo '</div>';
			
			echo '</section>';
			
		}
		?></div>
	</div>
	<!-- end: datalist-main-content -->

</form>
<!-- end: slipPaper -->