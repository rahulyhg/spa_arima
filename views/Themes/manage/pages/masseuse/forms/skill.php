<?php 

$arr['title'] = 'ความสามารถ';

$th = '';
$tr = '';
$input = '';
foreach ($this->skill as $key => $value) {
		$th .= '<th class="status">'.$value['name'].'</th>';

		$check = '';
		foreach ($this->item['skill'] as $skill) {
			if( $skill['id'] == $value['id'] ){
				$check = ' checked';
				break;
			}
		}
		$input = '<label class="checkbox disabled"><input'.$check.' type="checkbox" class="disabled" disabled></label>';

		$tr .= '<td class="status">'.$input.'</td>';

}

$body = '<table width="100%" class="table-permit">'.

			'<thead>'.'<tr>'.$th.'</tr>'.'</thead>'.

			'<tbody>'.'<tr>'.$tr.'</tr>'.'</tbody>'.

		 '</table>';

$arr['body'] = $body;
$arr['is_close_bg'] = 1;

$arr['width'] = 650;


$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ปิด</span></a>';

$arr['button'] = '<a class="btn btn-red" href="'.URL.'masseuse/cancel/'.$this->item['id'].'" data-plugins="dialog"><i class="icon-ban mrs"></i><span class="btn-text">ยกเลิกคิว</span></a>';

echo json_encode($arr);
?>