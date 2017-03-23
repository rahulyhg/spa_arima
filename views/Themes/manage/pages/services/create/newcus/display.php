<div class="newOrder_newCus form-insert form-orders">

	<div class="newOrder_newCus-header mbl">
		<?= $this->fn->stepList($this->steps,'owner', 0); ?>
	</div>
	<form class="newOrder_newCus-content mbl js-submit" action="<?=URL?>services/save">
		<input type="hidden" name="type_form" value="" />
		<input type="hidden" name="cus[id]" id="cus_id" data-name="cus_id" class="disabled" disabled />
		<input type="hidden" name="car[id]" id="car_id" data-name="car_id" class="disabled" disabled />
		<?php foreach ($this->steps as $key => $value) {
			echo '<div class="newOrder_newCus-section" data-section="'.$value['name'].'">';
			require 'sections/'.$value['name'].'.php';
			echo '</div>';
		} ?>
	</form>
	
</div>