<div ref="header" class="listpage2-header clearfix">

	<div ref="actions" class="listpage2-actions">
		<div class="clearfix mbs mtm">

			<ul class="lfloat" ref="actions">
				<li class="mt">
					<h2><i class="icon-cubes mrs"></i><span><?=$this->lang->translate('Package')?></span></h2>
				</li>

				<li class="mt"><a class="btn js-refresh" data-plugins="tooltip" data-options="<?=$this->fn->stringify(array('text'=>'refresh'))?>"><i class="icon-refresh"></i></a></li>

				<li class="divider"></li>

				<li class="mt"><a class="btn btn-blue" data-plugins="dialog" href="<?=URL?>package/add"><i class="icon-plus mrs"></i><span><?=$this->lang->translate('Add New')?></span></a></li>

				<li class="mt"><a class="btn" data-plugins="dialog" href="<?=URL?>package/sort"><i class="icon-list mrs"></i><span>เรียงลำดับ</span></a></li>

			</ul>
			
			<ul class="lfloat selection hidden_elem" ref="selection">
				<li><span class="count-value"></span></li>
				<li><a class="btn-icon"><i class="icon-download"></i></a></li>
				<li><a class="btn-icon"><i class="icon-trash"></i></a></li>
			</ul>


			<ul class="rfloat" ref="control">
				
				<li class="mt" id="more-link"></li>
			</ul>
			
		</div>
		

		<div class="clearfix mts mbm">
			<ul class="lfloat" ref="actions">
				<li><label for="status" class="label">Status</label>
				<select ref="selector" name="status" class="inputtext">
					<!-- <option value="">--- <?=$this->lang->translate("All Status")?> ---</option> -->
				<?php
					foreach ($this->status as $key => $value) {
						echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
					}
				?></select></li>

				<li><label for="unit" class="label">Unit</label>
				<select ref="selector" name="unit" class="inputtext">
					<option value="">--- <?=$this->lang->translate("All Unit")?> ---</option>
				<?php
					foreach ($this->unit as $key => $value) {
						echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
					}
				?></select></li>


				<li><label for="skill" class="label">Skill</label>
				<select ref="selector" name="skill" class="inputtext">
					<option value="">--- <?=$this->lang->translate("All Skill")?> ---</option>
				<?php
					foreach ($this->skill as $key => $value) {
						echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
					}
				?></select></li>
				
			</ul>

			<ul class="rfloat" ref="control">
				<li class="mt"><form class="form-search" action="#">
					<input class="inputtext search-input" type="text" id="search-query" placeholder="<?=$this->lang->translate('Search')?>" name="q" autocomplete="off">
					<span class="search-icon">
				 		 <button type="submit" class="icon-search nav-search" tabindex="-1"></button>
					</span>

				</form></li>
			</ul>
		</div>
	</div>

</div>