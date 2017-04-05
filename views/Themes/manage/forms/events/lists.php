<?php 



$invite = array();
$invite[] = array('id'=>'employees','name'=>'พนักงาน','icon'=>'user-circle-o');
$invite[] = array('id'=>'customers','name'=>'ลูกค้า','icon'=>'address-card-o');


$arr['title']= $this->item['title'];

// $date_start = date('j/m/Y', strtotime($this->item['start'])).' เวลา '.date('H:i', strtotime($this->item['start']));



// Set Deteil 
$arr['summary'] = '';
$arr['summary'] .= '<div class="pbs">';
$arr['summary'] .= '<div class="mvs"><i class="icon-clock-o mrs"></i>'.$this->fn->q('time')->str_event_date($this->item['start'], $this->item['end'], true).'</div>';

if( !empty($this->item['text']) ){
	$arr['summary'] .= '<div class="mvs"><i class="icon-info-circle mrs"></i><span class="fsm">'.$this->item['text'].'</span></div>';
}
$arr['summary'] .= '</div>';


$body = '';
// Set User Invite
foreach ($invite as $key => $value) {
	
	if( empty($this->item['invite'][$value['id']]) ) continue;
	$body .= '<div class="mbm">';


	$body .= '<div class="mbs"><span class="fwb"><i class="icon-'.$value['icon'].' mrs"></i>'.$value['name'].'</span></div>';


	$li = '';
	foreach ($this->item['invite'][$value['id']] as $key => $value) {
		$li .= $this->fn->q('listbox')->li_anchor( 
		array(
			'text' => '<a href="'.URL.$value['type'].'/'.$value['id'].'" target="_blank">'.$value['text'].'</a>'
		), array(
			'addClass' => 'ui-item ui-bucketed',
			'size' => 24
		) );
	}

	$body .= '<ul class="ui-list ui-list-users">'. $li .'</ul>';

	$body .= '</div>';
}

$arr['button'] = '';

if( !empty($this->item['permit']['del']) ){
	if( !empty($this->permit['events']['del']) || $this->item['emp_id']==$this->me['id'] ){
		$arr['button'] .= '<a class="btn btn-red" href="'.URL.'events/del/'.$this->item['id'].'" data-plugins="dialog">ลบ</a>';
	}
}


$arr['body'] = $body;
$arr['height'] = 350;
$arr['is_close_bg'] = 1;


// $arr['bottom_msg'] .= '<a class="btn" role="dialog-close"><span class="btn-text">ปิด</span></a>';

$arr['button'] .= '<a class="btn btn-green" href="'.URL.'events/edit/'.$this->item['id'].'" data-plugins="dialog"><i class="icon-pencil mrs"></i><span class="btn-text">แก้ไข</span></a>';

echo json_encode($arr);
?>