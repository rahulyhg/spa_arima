<div ref="header" class="listpage2-header clearfix">

	<div ref="actions" class="listpage2-actions">
		<div class="clearfix mbs mvm">
			
			<ul class="lfloat">
				<li>
					<h2><i class="icon-user-circle-o mrs"></i><span><?=$this->lang->translate('Masseuse')?></span></h2>
				</li>

				<li class="divider"></li>

			</ul>

			<ul class="lfloat" ref="actions">

				<li><a data-plugins="dialog" href="<?=URL?>masseuse/add" class="btn btn-primary"><i class="icon-plus mrs"></i><span class="btn-text"><?=$this->lang->translate('Add New')?></span></a></li>

				<!-- <li><a class="btn js-sort"><i class="icon-list mrs"></i><span>เรียงลำดับ</span></a></li> -->

			</ul>
			
			<ul class="lfloat selection hidden_elem" ref="selection">
				<li><span class="count-value"></span></li>
				<li><a class="btn-icon"><i class="icon-download"></i></a></li>
				<li><a class="btn-icon"><i class="icon-trash"></i></a></li>
			</ul>

			<ul class="rfloat more" ref="control">
				<li><label class="fwb fcg fsm" for="limit"></label>
				<select ref="selector" id="limit" name="limit" class="inputtext input-limit"><?php
					echo '<option value="20">20</option>';
					echo '<option value="50">50</option>';
					echo '<option value="100">100</option>';
					echo '<option selected value="200">200</option>';
				?></select><span id="more-link">กำลังโหลด...</span></li>
			</ul>
		</div>
		
		<div class="clearfix mts mbm">
			<ul class="lfloat" ref="actions">
				
				<li class="mt"><a class="btn js-refresh" data-plugins="tooltip" data-options="<?=$this->fn->stringify(array('text'=>'refresh'))?>"><i class="icon-refresh"></i></a></li>

				<li><label for="position" class="label">ตำแหน่งงาน</label>
				<select ref="selector" name="position" class="inputtext"><?php
					foreach ($this->position as $key => $value) {
						echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
					}
				?></select></li>

				<li><label for="position" class="label">การใช้งาน</label>
				<select ref="selector" name="display" class="inputtext"><?php
					echo '<option value="enabled">เปิด</option>';
					echo '<option value="disabled">ปิด</option>';
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