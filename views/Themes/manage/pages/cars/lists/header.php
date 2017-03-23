<div ref="header" class="listpage2-header clearfix">
	
	<div class="ptm">
		<ul class="ui-steps clearfix">
			<li class="anchor clearfix mg-anchor">
				<div class="lfloat mrm top-doc-logo"><div class="initials">MG</div></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname"><i class="icon-car"></i></div></div></div>
			</li>
			<!-- <li>
				<label class="label">ยอดจอง</label>
				<span class="data"><a>1</a></span>
			</li>
			<li>
				<label class="label">นัดหมาย</label>
				<span class="data"><a>1</a></span>
			</li> -->
		</ul>
	</div>

	<div ref="actions" class="listpage2-actions">
		<div class="clearfix mvm">
		<ul class="lfloat" ref="actions">

			<li><a class="btn js-refresh" data-plugins="tooltip" data-options="<?=$this->fn->stringify(array('text'=>'refresh'))?>"><i class="icon-refresh"></i></a></li>

			<li class="divider"></li>

			<li><a data-plugins="dialog" href="<?=URL?>customers/add" class="btn btn-primary"><i class="icon-plus mrs"></i><span class="btn-text">เพิ่ม</span></a></li>

		</ul>
		
		<ul class="lfloat selection hidden_elem" ref="selection">
			<li><span class="count-value"></span></li>
			<li><a class="btn-icon"><i class="icon-download"></i></a></li>
			<li><a class="btn-icon"><i class="icon-trash"></i></a></li>
		</ul>

		<ul class="rfloat" ref="control">
			<li><form class="form-search" action="#">
				<input class="inputtext search-input" type="text" id="search-query" placeholder="ค้นหา" name="q" autocomplete="off">
				<span class="search-icon">
			 		 <button type="submit" class="icon-search nav-search" tabindex="-1"></button>
				</span>

			</form></li>
			<li id="more-link"></li>
		</ul>
		</div>
		
	</div>

</div>