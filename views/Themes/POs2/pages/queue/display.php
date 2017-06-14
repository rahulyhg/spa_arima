<?php

$queue1 = '';
for ($i=1; $i <= 50; $i++) { 
	$queue1 .= '<li data-id="49" class="ui-sortable-handle"><div class="inner"><a>
		<div class="number">10</div>
		<div class="box"><div class="box-inner">
			
			<div class="avatar"><img class="img" src="http://localhost/spa_arima/public/uploads/1/87d2c0e7_e0acd9f437b592839e75d48a039c832f_a.jpg"></div>			<div class="box-content">
				<!-- <h3>101</h3> -->
				<div class="name">บาส</div>
			</div>
			
		</div></div>
	</a></div></li>';
}

$queue1 = '<ul class="ui-list ui-list-queue">'. $queue1.'</ul>';

$arr['form'] = '<div class="model-2-warp"></div>';
$arr['title'] = 

'<div class="clearfix fsm fwn">
	<div class="lfloat">
		<table class="model-2-table-actions"><tbody><tr>'.
			'<td><input type="date" data-plugins="datepicker" /></td>'.
			'<td><a class="btn js-refresh"><i class="icon-refresh"></i></a></td>'.
			'<td width="120"><div class="form-search"><input type="text" name="q" class="inputtext input-search" act="inputsearch" placeholder="ค้นหา.."><button type="button" class="btn-search"><i class="icon-search"></i></button></div></td>'.
		'</tr></tbody></table>
	</div>'.
	
	'<div class="rfloat">
		<table class="model-2-table-actions"><tbody><tr>'.
			'<td width="220"><input type="text" class="inputtext" act="inputsearch" placeholder="เข้าคิว.."></td>'.
			'<td><a class="btn btn-blue">Enter</a></td>'.
			'<td class="pll"><a role="dialog-close" class="btn">ปิด</a></td>'.
		'</tr></tbody></table>
	</div>'.
'</div>';
$arr['body'] = '<div class="model-2-body" style="min-height:550px">'.

	'<div style="position: absolute;top: 0;bottom: 0;width: 5px;background-color: #ccc;left: 60%"></div>'.
	'<div style="position: absolute; width: 60%; left: 0; top: 0; bottom: 0; overflow-y: auto;"><div class="pal">'.$queue1.'</div></div>'.
	'<div style="position: absolute; width: 40%; right: 0; top: 0; bottom: 0; overflow-y: auto;"><div class="pal">'.$queue1.'</div></div>'.

'</div>';




$arr['width'] = 'full';
// $arr['height'] = 'full';
echo json_encode($arr);
