<?php 

require 'init.php';

?><div class="form-insert form-orders newOrder_info hidden_elem">
	
	<div class="mbl clearfix">
	<?php require 'sections/date.php'; ?>
	</div>

	<div id="settingsAccordion" class="settingsAccordion"><?php
	foreach ($list as $key => $value) {

		echo '<section id="order_'.$value['section'].'_fieldset" class="settingsForm is-active" data-section="'.$value['section'].'">';

		echo '<div class="settingsLabel clearfix">'; ?>

			<table class="settingsLabelTable"><tbody><tr>
				<th class="label"><h3><?=$value['label']?></h3></th>
				<td class="data"><div class="data-wrap"><?=$value['data']?></div></td>
				<td class="actions"><i class="icon-chevron-up up"></i><i class="icon-chevron-down down"></i></td>
			</tr></tbody></table>
		<?php 
		echo '</div>';
		echo '<div class="settingsContent">';
			require 'sections/'.$value['section'].'.php';
		echo '</div>';
		
		echo '</section>';
		
	}
	?></div>

	<div class="clearfix mtl">

		<div class="rfloat">
			<span class="gbtn radius"><button type="submit" class="btn btn-blue">Save</button></span>
		</div>
	</div>
</div>