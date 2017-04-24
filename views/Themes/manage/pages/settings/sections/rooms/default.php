<?php

$url = URL .'rooms/';


?><div class="pal">

<div class="setting-header cleafix">

<div class="rfloat">

	<span class="gbtn"><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add"><i class="icon-plus mrs"></i><span><?=$this->lang->translate('Add New')?></span></a></span>

</div>

<div class="setting-title"><?=$this->lang->translate('Room')?></div>
</div>

<section class="setting-section">
	<table class="settings-table admin"><tbody>
		<tr>
			<th class="name"><?=$this->lang->translate('Number')?></th>
			<th class="status"><?=$this->lang->translate('Floor')?></th>
			<th class="status"><?=$this->lang->translate('Price')?></th>
			<th class="status"><?=$this->lang->translate('Status')?></th>
			<th class="actions"><?=$this->lang->translate('Action')?></th>

		</tr>

		<?php foreach ($this->data['lists'] as $key => $item) { ?>
		<tr>
			<td class="name"><h3><?=$item['number']?></h3></td>
			<td class="status"><?=$item['floor']?></td>
			<td class="status"><?=$item['price']?></td>
			<td class="status"><div class="btn" style="background-color: <?=$item['status']['color']?>;color:white"><?=$item['status']['name']?></div></td>

			<td class="actions">
	
				<div class="group-btn whitespace">
					<a data-plugins="dialog" href="<?=$url?>edit/<?=$item['id'];?>" class="btn"><i class="icon-pencil"></i></a>
					<a data-plugins="dialog" href="<?=$url?>del/<?=$item['id'];?>" class="btn"><i class="icon-trash"></i></a>
				</div>
					
			</td>

		</tr>
		<?php } ?>
	</tbody></table>
</section>
</div>