<?php


$arr['title'] = 

'<div class="clearfix fsm fwn">
	<div class="lfloat">
		<table><tbody><tr>'.
			'<td><a class="btn js-refresh"><i class="icon-refresh"></i></a></td>'.
			'<td width="220"><div class="form-search"><input type="text" name="q" class="inputtext input-search" act="inputsearch" placeholder="ค้นหา.."><button type="button" class="btn-search"><i class="icon-search"></i></button></div></td>'.
			'<td><a class="btn btn-blue">เพิ่ม</a></td>'.
		'</tr></tbody></table>
	</div>'.
	
	'<div class="rfloat">
		<table><tbody><tr>'.
			'<td class="pll"><a role="dialog-close" class="btn">ปิด</a></td>'.
		'</tr></tbody></table>
	</div>'.
'</div>';

$arr['form'] = '<div class="model-2-warp"></div>';

$arr['body'] = '<div class="model-2-body" style="min-height:550px">'.
	
'</div>';


$arr['width'] = 850;
// $arr['height'] = 'full';
echo json_encode($arr);