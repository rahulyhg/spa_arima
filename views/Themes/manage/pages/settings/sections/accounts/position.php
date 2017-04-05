<?php

$url = URL .'employees/';


?><div class="pal"><div class="setting-header cleafix">

<div class="rfloat">

	<span class="gbtn"><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add_position"><i class="icon-plus mrs"></i><span>เพิ่ม</span></a></span>

</div>

<div class="setting-title">ตำแหน่ง</div>
</div>

<section class="setting-section">
	<table class="settings-table admin"><tbody>
		<tr>
			<th class="name">ชื่อ</th>
			<th class="actions">จัดการ</th>

		</tr>

		<?php foreach ($this->data as $key => $item) { ?>
		<tr>
			<td class="name"><a><?=$item['name']?></a></td>

			<td class="actions whitespace">
			<?php if( $this->me['dep_is_admin'] == 1 ) { ?>
				<span class="gbtn"><a data-plugins="dialog" href="<?=$url?>edit_position/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-pencil"></i></a></span>
				<span class="gbtn"><a data-plugins="dialog" href="<?=$url?>edit_permit/<?=$item['id']?>?type=position" class="btn btn-no-padding"><i class="icon-check-square-o"></i></a></span>
				<span class='gbtn'><a data-plugins="dialog" href="<?=$url?>del_position/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-trash"></i></a></span>
			<?php } else {
				?>
				<span class='gbtn'><div class="btn btn-no-padding btn-red"><i class="icon-lock"></i></div></span>
				<?php
				} ?>
			</td>

		</tr>
		<?php } ?>
	</tbody></table>
</section>
</div>