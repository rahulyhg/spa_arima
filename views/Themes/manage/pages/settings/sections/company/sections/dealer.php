<?php
$url = URL .'dealer/';
?>
<section class="setting-section">
	<table class="settings-table"><tbody>
		<tr>
			<th class="name">Name</th>
			<?php foreach ($this->paytype['lists'] as $key => $value) {
				echo '<th class="status">'.$value['name'].'</th>';
			}
			?>
			<th class="actions">Actions</th>

		</tr>

		<?php foreach ($this->data['lists'] as $key => $item) { ?>
		<tr>
			<td class="name"><a data-plugins="dialog" href="<?=$url?>edit/<?=$item['id'];?>" class="fwb"><?=$item['name']?></a></td>

			<?php 
			foreach ($this->paytype['lists'] as $key => $value) {

				$sel = '';

				foreach ($item['paytype'] as $val) {
					
					if( $value['id'] == $val['id'] ) {
						$sel = ' checked="1"';
						break;
					}
				}

				echo '<td class="status"><label class="checkbox"><input'.$sel.' class="" type="checkbox" name=""></label></td>';
			}
			?>

			<td class="actions whitespace">
				
				<div class="group-btn whitespace"><?php 
					
					echo '<a data-plugins="dialog" href="'.$url.'edit/'.$item['id'].'" class="btn"><i class="icon-pencil"></i></a>';

					echo '<a data-plugins="dialog" href="'.$url.'del/'.$item['id'].'" class="btn"><i class="icon-trash"></i></a>';

				?></div>

			</td>

		</tr>
		<?php } ?>
	</tbody></table>
</section>
<div class="clearfix mtl">
	<div class="lfloat">
	<span class="gbtn"><a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add"><i class="icon-plus mrs"></i><span>Add New</span></a>
	</span>
	</div>
</div>