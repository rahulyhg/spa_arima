<?php

$url = URL .'customers/';


?><div class="pal"><div class="setting-header cleafix">

<div class="rfloat">

	<span class="gbtn"><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add_level"><i class="icon-plus mrs"></i><span>Add New</span></a></span>

</div>

<div class="setting-title">Customer Level</div>
</div>

<section class="setting-section">
	<table class="settings-table admin"><tbody>
		<tr>
			<th class="name">Level</th>
			<th class="actions">Action</th>

		</tr>

		<?php foreach ($this->data as $key => $item) { ?>
		<tr>
			<td class="name"><?=$item['name']?></td>

			<td class="actions whitespace">
				
				<span class="gbtn"><a data-plugins="dialog" href="<?=$url?>edit_level/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-pencil"></i></a></span>
				<span class='gbtn'><a data-plugins="dialog" href="<?=$url?>del_level/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-trash"></i></a></span>
					
			</td>

		</tr>
		<?php } ?>
	</tbody></table>
</section>
</div>