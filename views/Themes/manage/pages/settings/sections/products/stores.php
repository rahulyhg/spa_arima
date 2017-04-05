<?php

$url = URL .'stores/';


?><div class="pal">

<div class="setting-header cleafix">
	<div class="rfloat">
		<?php if( !empty($this->permit['stores']['add']) ){  ?>
		<span class="gbtn"><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add"><i class="icon-plus mrs"></i><span>เพิ่ม</span></a></span>
		<?php } ?>
	</div>

	<div class="setting-title">ตัวแทนจำหน่ายชุดแต่ง</div>
</div>

<section class="setting-section">
	<table class="settings-table admin"><tbody>
		<tr>
			<th class="name">ชื่อ</th>
			<!-- <th class="total">Total</th> -->
			<th class="actions">จัดการ</th>

		</tr>

		<?php foreach ($this->data['lists'] as $key => $item) { ?>
		<tr>
			<td class="name"><?=$item['name']?></td>

			<!-- <td class="total"><?=$item['total_item']?></td> -->
			
			<td class="actions whitespace">

				<?php if( !empty($this->permit['stores']['edit']) ){  ?>
				<span class="gbtn"><a data-plugins="dialog" href="<?=$url?>edit/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-pencil"></i></a>
				</span>
				<?php } ?>

				<?php if( !empty($this->permit['stores']['del']) ){  ?>
				<span class='gbtn'><a data-plugins="dialog" href="<?=$url?>del/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-trash"></i></a></span>
				<?php } ?>
				
			</td>

		</tr>
		<?php } ?>
	</tbody></table>
</section>
</div>