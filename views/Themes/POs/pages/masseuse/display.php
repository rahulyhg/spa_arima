<?php


$arr['form'] = '<div class="model-2-warp" data-plugins="setqueue"></div>';
$arr['title'] = 

'<div class="clearfix fsm fwn">
	<div class="lfloat">
		<table class="model-2-table-actions"><tbody><tr>'.
			// '<td><a class="btn js-refresh"><i class="icon-refresh"></i></a></td>'.
			'<td><input type="hidden" data-name="date" /></td>'.
			// '<td width="320"><div class="form-search"><input type="text" name="q" class="inputtext input-search" act="inputsearch" placeholder="ค้นหา.."><button type="button" class="btn-search"><i class="icon-search"></i></button></div></td>'.
		'</tr></tbody></table>
	</div>'.
	
	'<div class="rfloat">
		<table class="model-2-table-actions"><tbody><tr>'.
			'<td width="220"><input type="text" class="inputtext" act="inputqueue" placeholder="เข้าคิว.." autofocus></td>'.
			'<td><a class="btn btn-blue">Check In</a></td>'.
			'<td class="pll"><a role="dialog-close" class="btn">ปิด</a></td>'.
		'</tr></tbody></table>
	</div>'.
'</div>';
$arr['body'] = '<div class="model-2-body" style="min-height:550px">'.

	'<div style="position: absolute;top: 0;bottom: 0;width: 5px;background-color: #ccc;left: 60%"></div>'.
	'<div style="position: absolute; width: 60%; left: 0; top: 0; bottom: 0; overflow-y: auto;"><div class="pal tac"><ul class="ui-list ui-list-queue" data-ref="massager"></ul></div></div>'.
	'<div style="position: absolute; width: 40%; right: 0; top: 0; bottom: 0; overflow-y: auto;"><div class="pal tac"><ul class="ui-list ui-list-queue" data-ref="oil"></ul></div></div>'.

'</div>';

$arr['width'] = 'full';
// $arr['height'] = 'full';
echo json_encode($arr);
