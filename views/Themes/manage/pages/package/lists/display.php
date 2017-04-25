<?php

$url = URL .'package/';


?>
<div id="mainContainer" class="clearfix" data-plugins="main">

	<div role="content">
		<div role="main">


<div class="setting-main" role="main"><div class="pal">


	<div class="setting-header cleafix">

		<div class="rfloat">

			<span class="gbtn"><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add"><i class="icon-plus mrs"></i><span><?=$this->lang->translate('Add New')?></span></a></span>

		</div>

		<div class="setting-title"><i class="icon-cubes"></i> <?=$this->lang->translate('Package')?></div>
	</div>
	<!-- end: header -->

<section class="setting-section">
	<table class="settings-table admin"><tbody>
		<tr>

			<th class="status"><?=$this->lang->translate('Code')?></th>
			<th class="name"><?=$this->lang->translate('Name')?></th>
			<th class="status"><?=$this->lang->translate('Price')?></th>
			<th class="status"><?=$this->lang->translate('Type')?></th>
			<th class="actions"><?=$this->lang->translate('Action')?></th>
		</tr>

		<?php foreach ($this->data['lists'] as $key => $item) { ?>
		<tr>

			<td class="status"><?=$item['code']?></td>
			<td class="name"><?=$item['name']?></td>
			<td class="status"><?=$item['price']?></td>
			<td class="status"><?=( !empty($item['is_time']) ? 'Per Time' : 'On Time' )?></td>

			<td class="actions whitespace">
				
				<span class="gbtn"><a data-plugins="dialog" href="<?=$url?>edit/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-pencil"></i></a></span>
				<span class='gbtn'><a data-plugins="dialog" href="<?=$url?>del/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-trash"></i></a></span>
					
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