<?php

if( empty($this->item) ){

	$time = $this->package['qty'];
	if( $this->package['unit']=='minute' ){
		$time = '0.'.$time;
	}

	$this->item['item_qty'] = $time;

	$this->item['item_discount'] = 0;
	$this->item['item_price'] = $this->package['price'];
	$this->item['item_balance'] = $this->package['price'];
	$this->item['item_note'] = '';

	$this->item['masseuse'][] = !empty( $this->package['masseuse']) ? $this->package['masseuse']: ''; 
}

/*[item_id] => 3
[item_created] => 2017-07-14 11:47:19
[item_updated] => 2017-07-14 14:57:03
[item_emp_id] => 0
[item_room_id] => 0
[item_bed_id] => 0
[item_room_price] => 0.00
[item_start_date] => 2017-07-14 11:47:19
[item_end_date] => 0000-00-00 00:00:00
[item_status] => 
[item_price] => 0.00
[item_qty] => 1.3
[item_total] => 600.00
[item_discount] => 0.00
[item_balance] => 600.00
[item_job_id] => 0
[pack_id] => 4
[pack_time] => 1
[pack_code] => A03
[pack_unit] => hour
[pack_name] => นวดเท้า
[pack_has_masseuse] => 1
[masseuse] => Array*/

$masseuse = '';
if( !empty($this->package['has_masseuse']) ){

	$masseuse = '<div class="masseuse clearfix mvm">
			<div class="mbs fsm fwb fc7">พนง.ผู้บริการ</div>
			
			<div class="list-masseuse-warp">
				
				<ul class="ui-list-masseuse" style="max-width: 550px"></ul>

				<div class="mvm ui-list-masseuse-add"><span class="gbtn"><a class="btn" data-control="change" data-type="plus_masseuse">+ เพิ่มหมอ</a></span></div>
			</div>
		
	</div>';
}


# body
$arr['body'] = '<div class="profile-menu" data-plugins="setmenu" data-options="'.$this->fn->stringify( 
	array(
		'date' => $this->date,
		'price' => intval($this->item['item_price']),
		'unit' => $this->package['unit'],
		'qty' => intval($this->item['item_qty']),
		'discount' => intval($this->item['item_discount']),

		'masseuse' => $this->item['masseuse'],
		'has_masseuse' => intval($this->package['has_masseuse']),
		'job_type' => ''
	) ).'">'.
	'<div class="price">
		

		<table><tbody><tr>
			<td>
				<div class="mbs fsm fwb fc7">ราคา</div>
				<input type="number" class="inputtext inputprice" data-name="total" value="'. round($this->package['price']).'" name="total">
			</td>
			<td>
				<div class="mbs fsm fwb fc7">ส่วนลด</div>
				<input type="number" class="inputtext inputprice" data-name="discount" value="" name="discount">
			</td>
			<td>
				<div class="mbs fsm fwb fc7">&nbsp;</div>
				<a class="btn btn-jumbo"><span>ใช้คูปอง</span></a>
			</td>
		</tr></tbody></table>
	</div>'.

	'<div class="qty mvm">
		<div class="mbs fsm fwb fc7">เวลา</div>
		<div class="table-sethour-warp">
			<table class="table-sethour">
				<tbody><tr>
					<td class="b"><span class="gbtn radius"><button type="button" class="btn js-set-qty" data-type="minus"><i class="icon-minus"></i></button></span></td>
					<td class="tac">'.	
						'<input type="text" class="inputtext tac inputhour" value="'.$this->item['item_qty'].'" data-name="hour" name="time">'.
						// <div class="input-number hidden_elem"><span class="value"></span><span class="unit">Hour</span></div>
						// <div class="fsm hidden_elem">Hour</div>
					'</td>
					<td class="b"><span class="gbtn radius"><button type="button" class="btn js-set-qty" data-type="plus"><i class="icon-plus"></i></button></span></td>
				</tr>
			</tbody></table>
		</div>
	</div>'.

	$masseuse.

	'<div class="note clearfix">
		<label class="mbs fsm fwb fc7">หมายเหตุ</label>
		<div class="note-wrap mtm">
			<textarea class="textinput" name="note">'. $this->fn->q('text')->textarea($this->item['item_note']).'</textarea>
		</div>
	</div>'.

'</div>';

# title
$arr['title']= '<div class="clearfix">'.
	$this->package['name'].

	( !empty($this->item['item_id'] ) 
		? '<a class="rfloat btn btn-red" data-plugins="dialog" href="'.URL.'orders/delItem/'.$this->item['item_id'].'"><i class="icon-remove"></i><span class="btn-text mls">ยกเลิกเมนูนี้</span></a>'
		: ''
	). 
'</div>';

# set form
$arr['form'] = '<form class="js-save-orderlist" action="'.URL.'orders/saveMenu">';
$arr['hiddenInput'][] = array('name'=>'number','value'=>$this->number);
$arr['hiddenInput'][] = array('name'=>'date','value'=>$this->date);
$arr['hiddenInput'][] = array('name'=>'package','value'=>$this->package['id']);

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="mls">ปิด</span></a>';

// 

// $arr['is_close_bg'] = 1;
$arr['width'] = 550;

echo json_encode($arr);