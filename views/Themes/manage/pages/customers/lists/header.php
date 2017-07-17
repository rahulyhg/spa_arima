<div ref="header" class="listpage2-header clearfix">

	<div ref="actions" class="listpage2-actions">

		<div class="clearfix mvm">
		
		<ul class="lfloat" ref="title">
			<li><h2><i class="icon-address-card-o mrs"></i><span><?=$this->lang->translate( 'Member' )?></span></h2></li>

			<li class="divider"></li>
		</ul>

		<ul class="lfloat">
			<?php if( !empty($this->permit['customers']['add']) ) { ?>
            <li><div class="rfloat"><a href="<?=URL?>customers/add" class="btn btn-blue" data-plugins="dialog"><i class="icon-plus mrs"></i><?=$this->lang->translate('Add New')?></a></div></li>
            <?php } ?>
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
				echo '<option selected value="50">50</option>';
				echo '<option value="100">100</option>';
				echo '<option value="200">200</option>';
			?></select><span id="more-link">กำลังโหลด...</span></li>
		</ul>

		</div>
		<!--  -->

		<div class="clearfix mvm">

			<ul class="lfloat" ref="actions">
				<li class="mt"><a class="btn js-refresh" data-plugins="tooltip" data-options="<?=$this->fn->stringify(array('text'=>'refresh'))?>"><i class="icon-refresh"></i></a></li>
				
				<li><label for="position" class="label">สถานะ</label>
				<select ref="selector" name="level" class="inputtext"><?php
					echo '<option value="">ทั้งหมด</option>';
					foreach ($this->level as $key => $value) {
						echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
					}
				?></select></li>

				<li><label for="position" class="label">วันหมดอายุ</label>
				<select ref="selector" name="status" class="inputtext"><?php
					echo '<option value="run">ใช้งาน</option>';
					echo '<option value="expired">หมดอายุ</option>';
				?></select></li>


			</ul>

			<ul class="rfloat">
				<li><label for="position" class="label">ค้นหา</label><form class="form-search" action="#">
					<input class="inputtext search-input" type="text" id="search-query" placeholder="ค้นหา" name="q" autocomplete="off">
					<span class="search-icon"><button type="submit" class="icon-search nav-search" tabindex="-1"></button></span>
				</form></li>
				
			</ul>

		</div>
		
	</div>

</div>