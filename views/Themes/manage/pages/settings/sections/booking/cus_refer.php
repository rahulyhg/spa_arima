<?php

$url = URL .'booking/';

?><div class="pal">

<div class="setting-header cleafix">

	<div class="rfloat">
		<span class="gbtn"><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add_cus_refer"><i class="icon-plus mrs"></i><span>เพิ่ม</span></a></span>
	</div>

	<div class="setting-title">แหล่งที่มา</div>
</div>

<section class="setting-section">
	<table class="settings-table admin"><tbody>
		<tr>
			<!-- <th class="ID">ID</th> -->
			<th class="name">ชื่อ</th>
			<!-- <th class="status"><i class="icon-lock mrs"></i>Lock</th>
			<th class="qty">Order</th>
			<th class="status">Enabled</th>
			<th class="status">Sample</th> -->
			<th class="actions">จัดการ</th>

		</tr>

		<?php foreach ($this->data as $key => $item) { ?>
		<tr>
			<!-- <td class="ID"><?=$item['id']?></td> -->
			<td class="name"><?=$item['name']?></td>

			<td class="actions whitespace">
				<span class="gbtn"><a data-plugins="dialog" href="<?=$url?>edit_cus_refer/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-pencil"></i></a></span>
				<span class='gbtn'><a data-plugins="dialog" href="<?=$url?>del_cus_refer/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-trash"></i></a></span>
			</td>

		</tr>
		<?php } ?>
	</tbody></table>
</section>

</div>