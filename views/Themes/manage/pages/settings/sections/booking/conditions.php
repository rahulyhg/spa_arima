<?php

$url = URL .'booking/';

?><div class="pal">

<div class="setting-header cleafix">

	<div class="rfloat">
		<span class="gbtn"><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add_condition"><i class="icon-plus mrs"></i><span>เพิ่ม</span></a></span>
	</div>

	<div class="setting-title">เงื่อนไขการชำระเงิน</div>

	<div class="pam uiBoxYellow mtm">
		<ul class="uiList uiListStandard">
			<li><strong>Income:</strong> ค่าจำนวนเงินบวกการจอง</li>
    		<li><strong>Lock:</strong> จะไม่นำค่าเงินไปคิดรวมกับค่าใช้จ่ายของการจอง</li>
		</ul>
	</div>
</div>

<section class="setting-section">
	<table class="settings-table admin"><tbody>
		<tr>
	
			<th class="name">เงื่อนไข</th>
			<th class="status">Income</th>
			<th class="status">Calculate</th>
			<th class="status"><i class="icon-lock mrs"></i>Lock</th>
			<th class="actions">จัดการ</th>

		</tr>

		<?php foreach ($this->data as $key => $item) { ?>
		<tr>
			
			<td class="name">
				<h3><?=$item['name']?></h3>
			</td>

			<td class="status"><label class="checkbox"><input disabled class="disabled" type="checkbox" name=""<?=!empty($item['income']) ?' checked="1"' :''?>></label></td>		
			<td class="status"><label class="checkbox"><input disabled class="disabled" type="checkbox" name=""<?=!empty($item['is_cal']) ?' checked="1"' :''?>></label></td>		
			<td class="status"><label class="checkbox"><input disabled class="disabled" type="checkbox" name=""<?=!empty($item['has_lock']) ?' checked="1"' :''?>></label></td>			
			
			<td class="actions whitespace">
				<span class="gbtn"><a data-plugins="dialog" href="<?=$url?>edit_condition/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-pencil"></i></a></span>
				<span class='gbtn'><a data-plugins="dialog" href="<?=$url?>del_condition/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-trash"></i></a></span>
			</td>

		</tr>
		<?php } ?>
	</tbody></table>
</section>

</div>