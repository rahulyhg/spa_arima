<div ref="header" class="listpage2-header clearfix">

	<div ref="actions" class="listpage2-actions">

		<div class="clearfix pvm">

		<ul class="lfloat" ref="title">
			<li class="mt">
				<h2><i class="icon-address-card-o mrs"></i><span><?=$this->lang->translate('Member')?></span></h2>
			</li>
		</ul>
		
		<ul class="lfloat" ref="actions">
			
			<li class="mt"><a class="btn js-refresh" data-plugins="tooltip" data-options="<?=$this->fn->stringify(array('text'=>'refresh'))?>"><i class="icon-refresh"></i></a></li>
			
			<!-- <li><label for="closedate" class="label">Close date</label>
			<select ref="closedate" name="closedate" class="inputtext">
				<option value="daily"><?=$this->lang->translate('Now')?></option>
				<option selected value="weekly"><?=$this->lang->translate('Weekly')?></option>
				<option value="monthly"><?=$this->lang->translate('Monthly')?></option>
				<option divider></option>
				<option value="latest"><?=$this->lang->translate('Lastest')?></option>
				<option divider></option>
				<option value="custom"><?=$this->lang->translate('Custom')?></option>
			</select></li> -->

			<li><label for="position" class="label">Status</label>
			<select ref="selector" name="status" class="inputtext"><?php
				echo '<option value="run">RUN</option>';
				echo '<option value="expired">EXPIRED</option>';
			?></select></li>
			

			<li class="divider"></li>

			<?php if( !empty($this->permit['customers']['add']) ) { ?>
            <li class="mt"><div class="rfloat"><a href="<?=URL?>customers/add" class="btn btn-blue" data-plugins="dialog"><i class="icon-plus mrs"></i><?=$this->lang->translate('Add New')?></a></div></li>
            <?php } ?>

		</ul>
		
		<ul class="lfloat selection hidden_elem" ref="selection">
			<li><span class="count-value"></span></li>
			<li><a class="btn-icon"><i class="icon-download"></i></a></li>
			<li><a class="btn-icon"><i class="icon-trash"></i></a></li>
		</ul>

		<ul class="rfloat" ref="control">
			<li class="mt"><form class="form-search" action="#">
				<input class="inputtext search-input" type="text" id="search-query" placeholder="<?=$this->lang->translate('search')?>" name="q" autocomplete="off">
				<span class="search-icon">
			 		 <button type="submit" class="icon-search nav-search" tabindex="-1"></button>
				</span>

			</form></li>
			<li class="mt" id="more-link"></li>
		</ul>
		</div>
		<!--  -->
		
	</div>

</div>