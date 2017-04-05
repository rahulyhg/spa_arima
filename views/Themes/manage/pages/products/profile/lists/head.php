<div class="SettingCol-header"><div class="SettingCol-contentInner">
	<div class="clearfix">
		<ul class="clearfix lfloat SettingCol-headerActions">

			<li><a class="btn js-refresh"><i class="icon-refresh"></i></a></li>
			<li><h2><?=$this->item['name']?></h2></li>
			<li class="divider"></li>
			
			<?php if( !empty($this->permit['stocks']['add']) ){ ?>
			<li><a class="btn btn-blue" data-plugins="dialog" href="<?=URL?>products/add_item/<?=$this->item['id']?>"><i class="icon-plus mrs"></i><span>เพิ่มจำนวนสินค้า</span></a></li>
			<?php } ?>

		</ul>
		<ul class="rfloat SettingCol-headerActions clearfix">
			<li id="more-link"></li>
		</ul>

	
	</div>

	<div class="mtm clearfix">
		<ul class="lfloat SettingCol-headerActions clearfix">
			<li><label>สถานะ:</label> <select ref="selector" name="status" class="inputtext">
				<option value="">ทั้งหมด</option>
			<?php foreach ($this->status as $key => $value) {

				// selected="1" 
			 ?>
				<option value="<?=$value['id']?>"><?=$value['name']?></option>
			<?php } ?>
			</select></li>

		</ul>
		<ul class="rfloat SettingCol-headerActions clearfix">
			<li><form class="form-search" action="#">
				<input class="search-input inputtext" type="text" id="search-query" placeholder="ค้นหา" name="q" autocomplete="off">
				<span class="search-icon">
			 		 <button type="submit" class="icon-search nav-search" tabindex="-1"></button>
				</span>

			</form></li>
			
		</ul>
	</div>
	<!-- <div class="setting-description mtm uiBoxYellow pam">Manage your personal employee settings.</div> -->
</div></div>