<?php


$this->steps = array();
$this->steps['sales'] = array('text'=>'ที่ปรึกษาการขาย','name'=>'sales');
$this->steps['customers'] = array('text'=>'ลูกค้า','name'=>'customers');
$this->steps['details'] = array('text'=>'รายละเอียดการจอง','name'=>'details');
$this->steps['deposit'] = array('text'=>'เงินมัดจำ(จอง)','name'=>'deposit');
$this->steps['payment'] = array('text'=>'เงื่อนไข<br>การซื้อ','name'=>'payment');
$this->steps['insurence'] = array('text'=>'ประกันภัย','name'=>'insurence');
$this->steps['accessory'] = array('text'=>'อุปกรณ์ตกแต่งเพิ่มเติม','name'=>'accessory');
$this->steps['conditions'] = array('text'=>'เงื่อนไข<br>การชำระเงิน','name'=>'conditions');

$arr['form'] = '<form class="newOrder_model form-booking" data-plugins="stepsform" data-options="'.
	$this->fn->stringify( array(
		'steps' => $this->steps,
		'index' => !empty($this->me['dep_is_sale']) && count($this->dealer)==1? 1:0, 
	) ).'" action="'.URL.'booking/save"></form>';

$section = '';
foreach ($this->steps as $key => $value) {
	$section .= '<div class="newOrder_inputs-section hidden_elem" data-section="'.$value['name'].'" steps-content="'.$value['name'].'">';
	require 'sections/'.$value['name'].'.php';
	$section .= '</div>';
}


$arr['body'] = '<div class="newOrder" data-plugins="bookingform">'.

	/* inputs */
	'<div class="newOrder_inputs">'.
		'<div class="newOrder_inputs-header mbl" steps-nav>'. $this->fn->stepList($this->steps,'owner', 0) .'</div>'.
		// end: newOrder_inputs-header

		'<div class="newOrder_inputs-main">'.
			'<div class="newOrder_inputs-content">'.
				'<input type="hidden" name="type_form" value="" />'.
				'<input type="hidden" name="cus[id]" id="cus_id" data-name="cus_id" class="disabled" disabled />'.
				'<input type="hidden" name="car[id]" id="car_id" data-name="car_id" class="disabled" disabled />'.

				$section.

			'</div>'.
			// end: newOrder_inputs-content

			'<div class="newOrder_inputs-footer clearfix">'.
	    		'<div class="lfloat"><a class="btn btn-link js-prev">กลับ</a></div>'.
				'<div class="rfloat">'.
					'<a class="btn btn-blue js-next btn-submit">'.
						'<span class="btn-text">ต่อไป</span>'.
						'<div class="loader-spin-wrap"><div class="loader-spin"></div></div>'.
					'</a>'.
				'</div>'.
			'</div>'.
			// end: newOrder_inputs-footer
		'</div>'.
		 // end: newOrder_inputs-main

	'</div>'.

'</div>';


$arr['title']= '<div class="clearfix">
	<div class="lfloat">สั่งจองรถยนต์</div>
	<fieldset id="book_page_fieldset" class="control-group">
	<div class="rfloat fsm fwn">
		<table><tr>
			<td><label for="book_page">เล่มที่</label></td>
			<td><input type="text" name="book[page]" id="book_page" class="inputtext input-number"></td>
			<td class="plm"><label for="book_number">เลขที่</label></td>
			<td><input type="text" name="book[number]" id="book_number" class="inputtext input-no"></td>
			<td><input type="date" name="book[date]" data-plugins="datepicker" class="inputtext"></td>
			<td class="pll"><a class="btn" role="dialog-close"><i class="icon-remove mrs"></i>ยกเลิก</a></td>
			
		</tr></table>
	</div>
	</fieldset>
</div>';

$arr['width'] = 950;
$arr['height'] = 'full';
$arr['overflowY'] = 'auto';


echo json_encode($arr);