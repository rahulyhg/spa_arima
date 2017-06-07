<?php

$arr['title'] = 'ความสามารถ';

$body = '<div class="">
		 <div><span class="fwb">ลำดับคิว : </span>'.$this->job['job_sequence'].'</div>
		 <div><span class="fwb">เวลาเข้างาน : </span>'.$this->fn->q('time')->live($this->time['clock_start_date']).'</div>';

		 if( $this->time['clock_end_date'] != '0000-00-00 00:00:00' ){
		 	$body .= '<div><span class="fwb">เวลาออกงาน : </span>'.$this->fn->q('time')->live($this->time['clock_end_date']).'</div>';
		 }

$body .= '</div>';

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

$body .= '<table width="100%" class="table-permit pvm">'.

			'<thead>'.'<tr>'.$th.'</tr>'.'</thead>'.

			'<tbody>'.'<tr>'.$tr.'</tr>'.'</tbody>'.

		 '</table>';

$arr['body'] = $body;
$arr['is_close_bg'] = 1;

$arr['width'] = 650;

$date = '';
if( isset($_REQUEST['date']) ){
	$date = '?date='.$_REQUEST['date'];
}

$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ปิด</span></a>';

$arr['button'] = '<a class="btn btn-red" href="'.URL.'masseuse/cancel/'.$this->item['id'].$date.'" data-plugins="dialog"><i class="icon-ban mrs"></i><span class="btn-text">ยกเลิกคิว</span></a>';

echo json_encode($arr);
?>