<?php 

$url = URL.'accessory/';

?><div data-load="<?=URL?>settings/accessory" class="SettingCol offline">

<div class="SettingCol-header"><div class="SettingCol-contentInner">
	<div class="clearfix">
		<ul class="clearfix lfloat SettingCol-headerActions">

			<li><a class="btn js-refresh"><i class="icon-refresh"></i></a></li>
			<li><h2><i class="icon-check-square-o mrs"></i><span>ชุดเแต่ง</span></h2></li>
			<?php if( !empty($this->permit['accessory']['add']) ){  ?>
			<li class="divider"></li>
			<li><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add"><i class="icon-plus mrs"></i><span>เพิ่ม</span></a></li>
			<?php } ?>
		</ul>
		<ul class="rfloat SettingCol-headerActions clearfix">
			<li id="more-link"><span class="mhs">1-50<span class="mhs">จาก</span>301</span><span class="prev disabled fcg"><i class="icon-angle-left"></i></span><a class="next"><i class="icon-angle-right"></i></a></li>
		</ul>

	
	</div>

	<div class="mtm clearfix">
		<ul class="lfloat SettingCol-headerActions clearfix">
			<li><label>รุ่น:</label> <select ref="selector" name="model" class="inputtext">
				<option value="">ทั้งหมด</option>
			<?php foreach ($this->model as $key => $value) {

				// selected="1" 
			 ?>
				<option value="<?=$value['id']?>"><?=$value['name']?></option>
			<?php } ?>
			</select></li>

			<li><label>ร้าน:</label> <select ref="selector" name="store" class="inputtext">
				<option value="">ทั้งหมด</option>
			<?php foreach ($this->store as $key => $value) {

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

<div class="SettingCol-main">
	<div class="SettingCol-tableHeader"><div class="SettingCol-contentInner">
		<table class="settings-table admin"><thead><tr>
			<th class="name" data-col="0">ชื่อ</th>
			<th class="status" data-col="1">รุ่น</th>
			<th class="number" data-col="2">ราคาต่ำสุด</th>
			<th class="number" data-col="3">ราคารสูงสุด</th>
			<th class="actions" data-col="4"></th>
		</tr></thead></table>
	</div></div>
	<div class="SettingCol-contentInner">
	<div class="SettingCol-tableBody"></div>
	<div class="SettingCol-tableEmpty empty">
		<div class="empty-loader">
			<div class="empty-loader-icon loader-spin-wrap"><div class="loader-spin"></div></div>
			<div class="empty-loader-text">กำลังโหลด...</div>
		</div>
		<div class="empty-error">
			<div class="empty-icon"><i class="icon-link"></i></div>
			<div class="empty-title">การเชื่อมต่อเกิดข้อผิดพลาด</div>
		</div>

		<div class="empty-text">
			<div class="empty-icon"><i class="icon-users"></i></div>
			<div class="empty-title">ไม่พบผลลัพธ์</div>
		</div>
	</div>
	</div>
</div>

</div>