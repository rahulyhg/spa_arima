<?php

$url = URL .'employees/';


?><div class="pal">

<div class="setting-header cleafix">

<div class="rfloat">

	<span class="gbtn"><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add_department"><i class="icon-plus mrs"></i><span>เพิ่ม</span></a></span>

</div>

<div class="setting-title">แผนก</div>
</div>

<section class="setting-section">
	<table class="settings-table admin"><tbody>
		<tr>
			<th class="name">ชื่อ</th>

			<?php foreach ($this->role as $key => $value) { ?>
				<th class="status"><?=$value['name']?></th>
			<?php } ?>

			<th class="actions">จัดการ</th>

		</tr>

		<?php foreach ($this->data as $key => $item) { ?>
		<tr>
			<td class="name">
				<h3><?=$item['name']?></h3>
				<?php if( !empty($item['notes']) ){ ?>
				<div class="fsm fcg"><?=$item['notes']?></div>
				<?php } ?>
			</td>

			<?php 
			foreach ($this->role as $role) {

				$ck = '';
				if( !empty($item['access']) ){
					$access = json_decode($item['access'], true);
					if( in_array($role['id'], $access) ){
						$ck = ' checked="1"';
					}
				}
				
				echo '<td class="status"><label class="checkbox"><input'.$ck.' disabled class="disabled" type="checkbox" name=""></label></td>';
			} 
			?>

			<td class="actions whitespace">
				
				<span class="gbtn"><a data-plugins="dialog" href="<?=$url?>edit_department/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-pencil"></i></a></span>
				<span class="gbtn"><a data-plugins="dialog" href="<?=$url?>edit_permit/<?=$item['id']?>?type=department" class="btn btn-no-padding"><i class="icon-check-square-o"></i></a></span>
				<span class='gbtn'><a data-plugins="dialog" href="<?=$url?>del_department/<?=$item['id'];?>" class="btn btn-no-padding"><i class="icon-trash"></i></a></span>
					
			</td>

		</tr>
		<?php } ?>
	</tbody></table>
</section>
</div>