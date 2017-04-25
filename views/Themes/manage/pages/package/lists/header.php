<div ref="header" class="listpage2-header clearfix">

	<div ref="actions" class="listpage2-actions">

		<div class="clearfix pvm">
		
		<ul class="lfloat" ref="actions">
			
			<li class="mt"><a class="btn js-refresh" data-plugins="tooltip" data-options="<?=$this->fn->stringify(array('text'=>'refresh'))?>"><i class="icon-refresh"></i></a></li>
			
			<li><label for="closedate" class="label">Close date</label>
			<select ref="closedate" name="closedate" class="inputtext">
				<option value="daily">วันนี้</option>
				<option selected value="weekly">สัปดาห์นี้</option>
				<option value="monthly">เดือนนี้</option>
				<option divider></option>
				<option value="latest">ล่าสุด</option>
				<option divider></option>
				<option value="custom">กำหนดเอง</option>
			</select></li>

			<?php if( !empty($this->permit['customers']['add']) ) { ?>
			<li class="divider"></li>
            <li class="mt"><div class="rfloat"><a href="<?=URL?>customers/add" class="btn btn-blue" data-plugins="dialog"><i class="icon-plus mrs"></i>เพิ่ม</a></div></li>
            <?php } ?>

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
		<!--  -->
		
	</div>

</div>