<?php

$url = URL .'customers/';


?><div class="pal"><div class="setting-header cleafix">

<div class="rfloat">

	<a class="btn btn-blue" data-plugins="dialog" href="<?=$url?>add_level"><i class="icon-plus mrs"></i><span><?=$this->lang->translate('Add New')?></span></a>
</div>

<div class="setting-title"><?=$this->lang->translate('Customer Level')?></div>
</div>

<section class="setting-section">
	<table class="settings-table admin">

	<thead>
		<tr>
			<th class="name"><?=$this->lang->translate('Level')?></th>
			<th class="status"><?=$this->lang->translate('Discount')?> (%)</th>
			<th class="actions"><?=$this->lang->translate('Action')?></th>

		</tr>
	</thead>
	<tbody data-ref="listbox">
		<?php foreach ($this->data as $key => $item) { ?>
		<tr data-id="<?=$item['id']?>">
			<td class="name"><?=$item['name']?></td>

			<td class="status"><?=$item['discount']?> %</td>

			<td class="actions whitespace">
				
				<div class="group-btn whitespace"><?php 
					
					echo '<a data-plugins="dialog" href="'.$url.'edit_level/'.$item['id'].'" class="btn"><i class="icon-pencil"></i></a>';

					echo '<a data-plugins="dialog" href="'.$url.'del_level/'.$item['id'].'" class="btn"><i class="icon-trash"></i></a>';

				?></div>

			</td>

		</tr>
		<?php } ?>
	</tbody></table>
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
			$.post(Event.URL + 'customers/sort_level', {ids: ids});
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
			url: Event.URL + 'customers/update_level',
			data: formData,
			dataType: 'json',
			processData: false,
    		contentType: false,
		});
	});

</script>