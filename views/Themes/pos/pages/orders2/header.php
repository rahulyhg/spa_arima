<?php 



?><div ref="header" class="listpage2-header clearfix">

	<div ref="actions" class="listpage2-actions">
		<div class="clearfix mbs mtm">
			<ul class="lfloat">
				<li class="mt">
					<h2><i class="icon-file-text-o mrs"></i><span>รายรับประจำวัน</span></h2>
				</li>

				<li class="mt"><a class="btn js-refresh" data-plugins="tooltip" data-options="<?=$this->fn->stringify(array('text'=>'refresh'))?>"><i class="icon-refresh"></i></a></li>

				<li><label for="position" class="label">Date</label>
				<input ref="date" type="date" name="date" class="inputtext" value="<?=!empty($this->date) ? $this->date:'' ?>" /></li>

				<!-- <li><label for="position" class="label">Status</label>
				<select ref="selector" name="position" class="inputtext"><?php
					// foreach ($this->position as $key => $value) {
					// 	echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
					// }
				?></select></li> -->

				<li class="divider"></li>

			</ul>

			<ul class="lfloat" ref="actions">

				<li class="mt"><a data-plugins="dialog" href="<?=URL?>orders/add" class="btn btn-primary"><i class="icon-plus mrs"></i><span class="btn-text"><?=$this->lang->translate('Add New')?></span></a></li>

			</ul>
			
			<ul class="lfloat selection hidden_elem" ref="selection">
				<li><span class="count-value"></span></li>
				<li><a class="btn-icon"><i class="icon-download"></i></a></li>
				<li><a class="btn-icon"><i class="icon-trash"></i></a></li>
			</ul>

			<ul class="rfloat">
				<li style="margin-top: 8px">
					<div class="group-btn"><a class="btn active"><i class="icon-list"></i></a><a class="btn" href="<?=URL?>pos/orders?style=1"><i class="icon-television"></i></a></div>
				</li>
			</ul>

			<ul class="rfloat" ref="control">
				
				<!-- <li class="mt"><form class="form-search" action="#">
					<input class="inputtext search-input" type="text" id="search-query" placeholder="<?=$this->lang->translate('Search')?>" name="q" autocomplete="off">
					<span class="search-icon">
				 		 <button type="submit" class="icon-search nav-search" tabindex="-1"></button>
					</span>

				</form></li> -->

				<li class="mt" id="more-link"></li>

				
			</ul>


		</div>
		
	</div>

</div>