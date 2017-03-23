<div ref="header" class="listpage2-header clearfix">
	
	<div ref="actions" class="listpage2-actions">
		<div class="clearfix mvm">
		<ul class="lfloat" ref="actions">

			<li><a class="btn js-refresh" data-plugins="tooltip" data-options="<?=$this->fn->stringify(array('text'=>'refresh'))?>"><i class="icon-refresh"></i></a></li>

			<li class="divider"></li>

			<?php if( $this->me['dep_is_admin'] == 1 ){ ?>
			<li><a data-plugins="dialog" href="<?=URL?>sales/add" class="btn btn-primary"><i class="icon-plus mrs"></i><span class="btn-text">Add New</span></a></li>
			<?php } ?>

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