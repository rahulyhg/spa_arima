<?php

$url = URL .'stations/';
$title = "สถานี";

?><div style="max-width: 760px;">

<div class="cleafix">
	<a class="rfloat btn btn-blue" data-plugins="dialog" href="<?=$url?>add"><i class="icon-plus mrs"></i><span>เพิ่ม</span></a>
	<div class="setting-title"><?=$title?></div>
</div>

<!-- <div class="setting-description">เปลี่ยนการตั้งค่าบัญชีพื้นฐานของคุณ</div> -->

<section class="setting-section">
	<table class="settings-table admin"><tbody>
		<tr>
			<th class="name">ชื่อ</th>
			<!-- <th class="status">สถานะ</th> -->
			<th class="actions"></th>

		</tr>

		<?php foreach ($this->data['lists'] as $key => $item) { ?>
		<tr>
			<td class="name">
				<span class="fwb fcb"><?=$item['name']?></span>
				<div class="fcg"></div>
			</td>
			
			<td class="actions">
				<span class="group-btn" style="width:107px;">
					<a data-plugins="dialog" href="<?=$url?>edit/<?=$item['id'];?>" class="btn">แก้ไข</a><a data-plugins="dialog" href="<?=$url?>del/<?=$item['id'];?>" class="btn">ลบ</a>
				</span>
				
			</td>

		</tr>
		<?php } ?>
	</tbody></table>
</section>

</div>