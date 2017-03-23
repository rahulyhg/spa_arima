<?php


$this->steps = array();
$this->steps['owner'] = array('text'=>'ข้อมูลลูกค้า','name'=>'owner');
$this->steps['car'] = array('text'=>'ข้อมูลรถ','name'=>'car');
$this->steps['sender'] = array('text'=>'ผู้ส่งซ่อม','name'=>'sender');
$this->steps['items'] = array('text'=>'รายการซ่อม','name'=>'items');
$this->steps['plans'] = array('text'=>'นัดหมาย','name'=>'plans');

$arr['form'] = '<form class="newOrder_model" data-plugins="serviceform" data-options="'.
	$this->fn->stringify( array(
		'steps' => $this->steps,
		'is_step' => 'owner', 
	) ).'" action="'.URL.'services/save"></form>';

$section = '';
foreach ($this->steps as $key => $value) {
	$section .= '<div class="newOrder_inputs-section hidden_elem" data-section="'.$value['name'].'">';
	require 'sections/'.$value['name'].'.php';
	$section .= '</div>';
}

$search = '';
require 'sections/search.php';


$arr['body'] = '<div class="newOrder">'.

	/* search  */
	'<div class="newOrder_search" role="search"><div class="newOrder_searchWrap">'. $search .'</div></div>'. // hidden_elem

	/* inputs */
	'<div class="newOrder_inputs form-insert form-orders">'.
		'<div class="newOrder_inputs-header mbl" role="steplist">'. $this->fn->stepList($this->steps,'owner', 0) .'</div>'.
		// end: newOrder_inputs-header

		'<div class="newOrder_inputs-main form-orders">'.
			'<div class="newOrder_inputs-content">'.
				'<input type="hidden" name="type_form" value="" />'.
				'<input type="hidden" name="cus[id]" id="cus_id" data-name="cus_id" class="disabled" disabled />'.
				'<input type="hidden" name="car[id]" id="car_id" data-name="car_id" class="disabled" disabled />'.

				$section.

			'</div>'.
			// end: newOrder_inputs-content

			'<div class="newOrder_inputs-footer clearfix">'.
	    		'<div class="lfloat"><a class="btn btn-link js-prev">กลับ</a></div>'.
				'<div class="rfloat">
					<a class="btn btn-blue js-next">ต่อไป</a>
				</div>'.
			'</div>'.
			// end: newOrder_inputs-footer
		'</div>'.
		 // end: newOrder_inputs-main

	'</div>'.

'</div>';


$arr['title']= '<div class="clearfix">
	<div class="lfloat">บริการ</div>
	<div class="rfloat fsm fwn">
		<input type="date" name="service[date]" data-plugins="datepicker" class="inputtext">
		<a class="btn" role="dialog-close"><i class="icon-remove mrs"></i>ยกเลิก</a>
	</div>
</div>';
$arr['width'] = 860;
$arr['height'] = 'full';
$arr['overflowY'] = 'auto';

/*$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';*/

echo json_encode($arr);