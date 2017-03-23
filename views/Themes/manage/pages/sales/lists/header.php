<?php 

$url = URL.'sales/';

?>
<div ref="header" class="listpage2-header clearfix">

	<div ref="actions" class="listpage2-actions">

		<div class="clearfix pvm">

		<ul class="lfloat" ref="title">
			<li class="anchor clearfix mg-anchor">
				<div class="lfloat mrm top-doc-logo"><div class="initials">MG</div></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">Sales</div></div></div>
			</li>
		</ul>
		
		<ul class="lfloat" ref="actions">
			
			<li class="mt"><a class="btn js-refresh" data-plugins="tooltip" data-options="<?=$this->fn->stringify(array('text'=>'refresh'))?>"><i class="icon-refresh"></i></a></li>
			
			<li><label for="closedate" class="label">ตำแหน่งงาน</label>
			<select ref="selector" name="position" class="inputtext">
               <option value="">-</option>
				<?php 
                                foreach ($this->position as $key => $value) {
				$s = '';
				if( isset($_GET['position']) ){

					if( $_GET['position']==$value['id'] ){
						$s = ' selected="1"';
					}
				}
			 ?>
				<option<?=$s?> value="<?=$value['id']?>"><?=$value['name']?></option>
			<?php } ?>
			</select>

			</li>
			

			<li class="divider"></li>

            <li class="mt"><div class="rfloat"><a data-plugins="dialog" href="<?=$url?>add" class="btn btn-blue" _data-plugins="dialog"><i class="icon-plus mrs"></i>เพิ่ม</a></div>
            
            </li>

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