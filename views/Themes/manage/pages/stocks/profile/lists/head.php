<div class="SettingCol-header"><div class="SettingCol-contentInner">
	<div class="clearfix">
		<ul class="clearfix lfloat SettingCol-headerActions">

			<li><a class="btn js-refresh"><i class="icon-refresh"></i></a></li>
			<li><h2><?=$this->item['name']?></h2></li>
			<li class="divider"></li>
			
			<li><a class="btn btn-blue" href="<?=URL?>products/create?model_id=<?=$this->item['id']?>"><i class="icon-plus mrs"></i><span>เพิ่มสินค้าใหม่</span></a></li>

		</ul>
		<ul class="rfloat SettingCol-headerActions clearfix">
			<li id="more-link"></li>
		</ul>

	
	</div>

	<div class="mtm clearfix">
		
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