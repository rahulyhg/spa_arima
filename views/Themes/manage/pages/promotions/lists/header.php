<div ref="header" class="listpage2-header clearfix">

	<div ref="actions" class="listpage2-actions">
		<div class="clearfix mvm">

		<ul class="lfloat" ref="actions">
			<li class="mt">
				<h2><i class="icon-tags mrs"></i><span><?=$this->lang->translate('Promotions')?></span></h2>
			</li>

			<li class="mt"><a class="btn js-refresh" data-plugins="tooltip" data-options="<?=$this->fn->stringify(array('text'=>'refresh'))?>"><i class="icon-refresh"></i></a></li>

			<li><label for="position" class="label">Type</label>
			<select ref="selector" name="type" class="inputtext">
				<option value="">--- Select <?=$this->lang->translate("Type")?> ---</option>
			<?php
				foreach ($this->type as $key => $value) {
					echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
				}
			?></select></li>

			<li><label for="position" class="label">Status</label>
			<select ref="selector" name="status" class="inputtext">
				<option value="">--- Select <?=$this->lang->translate("Status")?> ---</option>
			<?php
				foreach ($this->status as $key => $value) {
					echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
				}
			?></select></li>

			<li class="divider"></li>

			<li class="mt"><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add"><i class="icon-plus mrs"></i><span><?=$this->lang->translate('Add New')?></span></a></li>

		</ul>
		
		<ul class="lfloat selection hidden_elem" ref="selection">
			<li><span class="count-value"></span></li>
			<li><a class="btn-icon"><i class="icon-download"></i></a></li>
			<li><a class="btn-icon"><i class="icon-trash"></i></a></li>
		</ul>

		<ul class="rfloat" ref="control">
			<li class="mt"><form class="form-search" action="#">
				<input class="inputtext search-input" type="text" id="search-query" placeholder="ค้นหา" name="q" autocomplete="off">
				<span class="search-icon">
			 		 <button type="submit" class="icon-search nav-search" tabindex="-1"></button>
				</span>

			</form></li>
			<li class="mt" id="more-link"></li>
		</ul>
		</div>
		
	</div>

</div>