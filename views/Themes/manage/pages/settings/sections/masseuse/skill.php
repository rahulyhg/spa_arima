<?php

$url = URL .'employees/';


?><div class="pal">

<div class="setting-header cleafix">

<div class="rfloat">

	<a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add_skill"><i class="icon-plus mrs"></i><span><?=$this->lang->translate('Add New')?></span></a>

</div>

<div class="setting-title"><?=$this->lang->translate('Skill')?></div>
</div>

<section class="setting-section">
	<table class="settings-table admin">
		<thead>
			<tr>
				<th class="name"><?=$this->lang->translate('Name')?></th>
				<th class="type">ประเภท</th>
				<th class="actions"><?=$this->lang->translate('Action')?></th>

			</tr>
		</thead>
		<tbody data-ref="listbox">
		<?php foreach ($this->data as $key => $item) { ?>
		<tr data-id="<?=$item['id']?>">
			<td class="name">
				<a data-plugins="dialog" href="'.$url.'edit_skill/'.$item['id'].'" class="fcn fwb"><?=$item['name']?></a>
			</td>
			<td class="type">
				<select data-action="change" id="skill_type" name="skill_type" class="inputtext"><?php 

				echo '<option value="">-</option>';
				foreach ($this->type as $key => $value) {

					$sel = '';
					if( $value['id']==$item['type'] ){
						$sel  = ' selected';
					}

					echo '<option'.$sel.' value="'.$value['id'].'">'.$value['name'].'</option>';
				}	

				?></select>
			</td>

			<td class="actions whitespace">
				
				<div class="group-btn whitespace"><?php 
					
					echo '<a data-plugins="dialog" href="'.$url.'edit_skill/'.$item['id'].'" class="btn"><i class="icon-pencil"></i></a>';

					echo '<a data-plugins="dialog" href="'.$url.'del_skill/'.$item['id'].'" class="btn"><i class="icon-trash"></i></a>';

				?></div>
					
			</td>

		</tr>
		<?php } ?>
		</tbody>
	</table>
</section>
</div>
<script type="text/javascript">
	
	var $listbox = $('[data-ref=listbox]');
	$listbox.sortable({
		stop: function () {

			var ids = [];
			$.each($('[data-ref=listbox] [data-id]'), function() {
				ids.push( $(this).data('id') );
			});
			$.post(Event.URL + 'employees/sort_skill', {ids: ids});
		}
	});
	
	$listbox.find('[data-action=change]').change(function() {

		var $parent = $(this).closest('tr'), values = [];

		var fields = $parent.find(':input[id='+ $(this).attr('id') +']').serializeArray();
		
		var formData = new FormData();

		formData.append('id', $parent.data('id') );
		$.each(fields, function (index, field) {
			formData.append(field.name, field.value);
        });

		$.ajax({
			type: "POST",
			url: Event.URL + 'employees/update_skill',
			data: formData,
			dataType: 'json',
			processData: false,
    		contentType: false,
		});
	});

</script>