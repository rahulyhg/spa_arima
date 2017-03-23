<div class="pal"><div class="setting-header cleafix">

<div class="rfloat">

	<span class="gbtn"><a class="btn btn-blue" href="<?=URL?>items/add/<?=$this->item['id']?>"><i class="icon-plus mrs"></i><span>Add Car New</span></a></span>

</div>

<div class="setting-title"><?=$this->item['name']?></div>
</div>

<section class="setting-section">

	<table class="settings-table admin"><tbody>
		<tr>
			<th class="email">เลขตัวถัง (VIN)</th>
			<th class="name">เลขเครื่องยนต์</th>
			<th class="status">สี</th>
			<th class="email">ปรับปรุง</th>
			<th class="actions">Actions</th>
		</tr>

		<?php foreach ($this->item['items'] as $key => $item) { ?>
		<tr>
			<td class="email"><?=$item['vin']?></td>

			<td class="name"><?=$item['engine']?></td>

			<td class="status"><ul class="ui-lists-color"><li style="background-color:<?=$item['color_primary']?>"></li></ul><?=$item['color_name']?></td>

			<td class="email"><?=$this->fn->q('time')->live( $item['updated'] )?></td>
			
			<td class="actions">

				<span class="gbtn"><a data-plugins="dialog" href="<?=URL?>items/edit/
				<?=$item['id']?>" class="btn btn-no-padding"><i class="icon-pencil"></i></a></span>
				<span class='gbtn'><a data-plugins="dialog" href="<?=URL?>items/del/
				<?=$item['id']?>" class="btn btn-no-padding"><i class="icon-trash"></i></a></span>

			</td>
		</tr>
		<?php } ?>
	</tbody></table>
</section>
</div>