<?php

$url = URL .'promotions/';


?>
<div id="mainContainer" class="clearfix" data-plugins="main">

	<div role="content">
		<div role="main">


<div class="setting-main" role="main"><div class="pal">


	<div class="setting-header cleafix">

		<div class="rfloat">

			<span class="gbtn"><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add"><i class="icon-plus mrs"></i><span><?=$this->lang->translate('Add New')?></span></a></span>

		</div>

		<div class="setting-title"><i class="icon-cubes"></i> <?=$this->lang->translate('Promotions')?></div>
	</div>
	<!-- end: header -->

<section class="setting-section">
	<table class="settings-table admin"><tbody>
		<tr>

			<th class="status"><?=$this->lang->translate('Type')?></th>
			<th class="name"><?=$this->lang->translate('Name')?></th>
			<th class="qty"><?=$this->lang->translate('Quantity')?></th>
			<th class="date"><?=$this->lang->translate('Start Date')?></th>
			<th class="date"><?=$this->lang->translate('End Date')?></th>
			<th class="status"><?=$this->lang->translate('Status')?></th>
			<th class="actions"><?=$this->lang->translate('Action')?></th>
		</tr>

		<?php foreach ($this->data['lists'] as $key => $item) { ?>
		<tr>

			<td class="status"><?=$item['type']['name']?></td>
			<td class="name"><?=$item['name']?></td>
			<td class="qty"><?=$item['qty']?></td>
			<td class="date"><?=$item['start_date']?></td>
			<td class="date"><?=$item['end_date']?></td>
			<td class="status"><?=$item['status']['name']?></td>

			<td class="actions whitespace">
				
				<span class="gbtn"><a data-plugins="dialog" href="<?=$url?>edit/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-pencil"></i></a></span>
				<span class='gbtn'><a data-plugins="dialog" href="<?=$url?>del/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-trash"></i></a></span>
					
			</td>

		</tr>
		<?php } ?>
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