<?php




$arr['title'] = 

'<div class="clearfix">'.
	
	'ใบสรุปยอดรายรับ'.
	'<div class="rfloat fsm fwn">'.
		'<input type="date" plugin="datepicker" />'.
	'</div>'.
'</div>';

$arr['form'] = '<div class="" data-plugins="summaryOfDaily">';

$arr['body'] = '<div style="min-height: 450px">'.
	'<table class="table-standard border-black">

	<tbody data-ref="listbox"></tbody>
	<tfoot>
		<tr class="total">
			<td colspan="2" class="label">ยอดรวม</td>
			<td class="price" data-ref="total"></td>
		</tr>
	</tfoot>

	</table>'.
'</div>'.
	
'';


$arr['button'] = '<button type="submit" role="dialog-close" class="btn"><span class="btn-text">'.$this->lang->translate('Close').'</span></button>';
// $arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';

$arr['width'] = 550;
echo json_encode($arr);