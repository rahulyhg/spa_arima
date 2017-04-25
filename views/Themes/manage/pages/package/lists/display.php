<div id="mainContainer" class="clearfix listpage2-container" data-plugins="main">

	<div role="content">
		<div role="main">


<div class="setting-main" role="main"><div class="pal">

<div class="setting-header cleafix">

	<div class="rfloat">
		<?php if( !empty($this->permit['package']['add']) ){ ?>
		<span class="gbtn"><a class="btn btn-blue" href="<?=URL?>package/add" data-pluging="dialog"><i class="icon-plus mrs"></i><span>Add New</span></a></span>
		<?php } ?>
	</div>

	<div class="setting-title"><?=$this->lang->translate('menu','Service Changes')?></div>
</div>
<!-- end: header -->

<section class="setting-section">
	<table class="settings-table admin"><tbody>
		<tr>
			<th class="name"><?=$this->lang->translate('Name')?></th>

			<th class="status"><?=$this->lang->translate('Time')?></th>
			<th class="price"><?=$this->lang->translate('Price')?></th>
			<th class="unit"></th>
			<th class="actions"><?=$this->lang->translate('Actions')?></th>
		</tr>

		<!-- <tr><td class="head" colspan="4"><?=$this->lang->translate('Package')?></td></tr> -->

		<tr>
			<td class="name"><h3>Admin</h3></td>
			
			<td class="status"></td>
			<td class="price"></td>
			<td class="unit"></td>
			<td class="actions">
				
				<div class="group-btn whitespace"><a class="btn"><i class="icon-pencil"></i></a><a class="btn"><i class="icon-ellipsis-v"></i></a>
				</div>
					
			</td>

		</tr>
			
	</tbody></table>
</section>
<!-- end: section -->

</div></div>
<!-- end: main -->


		</div>
		<!-- end: main -->
	</div>
	<!-- end: content -->
</div>
<!-- end: container -->
