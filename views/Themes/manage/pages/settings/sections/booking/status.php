<?php

$url = URL .'booking/';

?><div class="pal">

<div class="setting-header cleafix">

	<div class="rfloat">
		<span class="gbtn"><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add_status"><i class="icon-plus mrs"></i><span>เพิ่ม</span></a></span>
	</div>

	<div class="setting-title">สถานะการจอง</div>
</div>

<section class="setting-section">
	<table class="settings-table admin"><tbody>
		<tr>
			<!-- <th class="ID">ID</th> -->
			<th class="name">สถานะ</th>
			<!-- <th class="status"><i class="icon-lock mrs"></i>Lock</th> -->
			<!-- <th class="qty">Order</th> -->
			<!-- <th class="status">Enabled</th> -->
			<th class="status">ตัวอย่าง</th>
			<!-- <th class="actions">จัดการ</th> -->

		</tr>

		<?php foreach ($this->data as $key => $item) { ?>
		<tr>
			<!-- <td class="ID"><?=$item['id']?></td> -->
			<td class="name"><?=$item['name']?></td>
			
			<!-- <td class="status"><label class="checkbox"><input disabled="1" type="checkbox" name="is_lock"<?=!empty($item['is_lock']) ?' checked="1"' :''?>></label></td> -->
			<!-- <td class="qty tac"><?php // $item['status_order']?></td> -->
			<!-- <td class="status"><label class="checkbox"><input disabled="1"  type="checkbox" name=""<?=!empty($item['enable']) ?' checked="1"' :''?>></label></td> -->
			<td class="status">
				<span class="btn btn-status" style="min-width:120px;<?= !empty($item['color']) ?"background-color:{$item['color']};color:#fff":''; ?>"><?=$item['name']?></span>
			</td>

			<!-- <td class="actions whitespace">
				<span class="gbtn"><a data-plugins="dialog" href="<?=$url?>edit_status/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-pencil"></i></a></span>
				<span class='gbtn'><a data-plugins="dialog" href="<?=$url?>del_status/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-trash"></i></a></span>
			</td> -->

		</tr>
		<?php } ?>
	</tbody></table>
</section>

</div>