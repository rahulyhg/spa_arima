<div ref="header" class="listpage2-header clearfix">

	<div ref="actions" class="listpage2-actions">

		<div class="clearfix ptm">
			<ul class="lfloat" ref="title">
				<li class="anchor clearfix mg-anchor">
					<div class="lfloat mrm top-doc-logo"><?=!empty( $this->system['title'] ) ? $this->system['title']:'';?></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">Booking</div></div></div>
				</li>
			</ul>

			<ul class="lfloat listpage2-actions_status">
				<li class="item"><label class="label">จอง</label><div class="data">4</div></li>
				
				<li class="item"><label class="label">ถอนจอง</label><div class="data">-</div></li>

				<li class="item"><label class="label">ส่งหมอบ</label><div class="data">-</div></li>
				<li class="item"><label class="label">รวมทั้งหมด</label><div class="data"><a>3</a></div></li>

			</ul>

			<ul class="rfloat" style="margin-top: 4px">
				<li class="mt">
					<span class="group-btn">
						<a href="<?=URL?>booking/create" class="btn btn-blue" data-plugins="dialog"><i class="icon-plus mrs"></i>เพิ่มการจอง</a>
						<!-- <a class="btn btn-blue"><i class="icon-ellipsis-v"></i></a> -->
					</span>
				</li>
				<!-- <li class="divider"></li>
				<li class="mt">
					<a href="<?=URL?>booking/create" class="btn" _data-plugins="dialog"><i class="icon-upload mrs"></i>Export</a>
					<a href="<?=URL?>booking/create" class="btn" _data-plugins="dialog"><i class="icon-download mrs"></i>Import</a>
					<a href="<?=URL?>booking/create" class="btn" _data-plugins="dialog"><i class="icon-print mrs"></i>Print</a>
				</li> -->
			</ul>

		</div>
		<div class="clearfix pbm mts">

		<ul class="lfloat" ref="actions">
			
			<li class="mt"><a class="btn js-refresh" data-plugins="tooltip" data-options="<?=$this->fn->stringify(array('text'=>'refresh'))?>"><i class="icon-refresh"></i></a></li>
			
			<li><label for="closedate" class="label">Close date</label>
				<select ref="closedate" name="closedate" class="inputtext">
					<option value="daily">วันนี้</option>
					<option selected value="weekly">สัปดาห์นี้</option>
					<option value="monthly">เดือนนี้</option>
					<option value="custom">กำหนดเอง</option>
				</select>

			</li>

			<li>
				<label for="sale" class="label">พนักงานขาย</label>
				<select id="sale" name="sale" class="inputtext" ref="selector"><?php 
					echo '<option value="">ทั้งหมด</option>';
					foreach ($this->sales as $key => $value) {
						echo '<option value="'.$value['id'].'">'.$value['fullname'].'</option>';
					}
				?></select>
			</li>

			<li>
				<label for="status" class="label">สถานะ</label>
				<select id="status" name="status" class="inputtext" ref="selector"><?php 
					echo '<option value="">-</option>';
					foreach ($this->status as $key => $value) {
						echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
					}
				?></select>
			</li>

			<!-- <li class="divider"></li> -->

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