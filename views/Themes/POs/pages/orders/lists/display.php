<?php


$this->skill = array();
/*
$this->skill[] = array('cls'=>'ID2 bl', 'text'=>'HR.', 'id'=>'hr', 'key'=>'vip');
$this->skill[] = array('cls'=>'status', 'text'=>'V.I.P.', 'id'=>'vip', 'total'=>0);*/

$this->skill[] = array('cls'=>'ID2 bl', 'text'=>'NO.', 'id'=>'2', 'key'=>'mas');
$this->skill[] = array('cls'=>'status', 'text'=>'นวดตัว', 'id'=>'2', 'total'=>0);

$this->skill[] = array('cls'=>'ID2 bl', 'text'=>'NO.', 'id'=>'4', 'key'=>'mas');
$this->skill[] = array('cls'=>'status', 'text'=>'นวดเท้า', 'id'=>'4', 'total'=>0);

$this->skill[] = array('cls'=>'ID2 bl', 'text'=>'NO.', 'id'=>'3', 'key'=>'mas');
$this->skill[] = array('cls'=>'status', 'text'=>'นวดหัว', 'id'=>'3', 'total'=>0);

$this->skill[] = array('cls'=>'ID2 bl', 'text'=>'NO.', 'id'=>'8', 'key'=>'mas');
$this->skill[] = array('cls'=>'status', 'text'=>'นวด OIL', 'id'=>'8', 'total'=>0);

$this->skill[] = array('cls'=>'ID2 bl', 'text'=>'NO.', 'id'=>'9', 'key'=>'mas');
$this->skill[] = array('cls'=>'status', 'text'=>'นวดหน้า', 'id'=>'9', 'total'=>0);

$this->skill[] = array('cls'=>'ID2 bl', 'text'=>'NO.', 'id'=>'5', 'key'=>'mas');
$this->skill[] = array('cls'=>'status', 'text'=>'แคะหู', 'id'=>'5', 'total'=>0);

$this->skill[] = array('cls'=>'ID2 bl', 'text'=>'NO.', 'id'=>'6', 'key'=>'mas');
$this->skill[] = array('cls'=>'status', 'text'=>'เล็บมือ', 'id'=>'6', 'total'=>0);

$this->skill[] = array('cls'=>'ID2 bl', 'text'=>'NO.', 'id'=>'7', 'key'=>'mas');
$this->skill[] = array('cls'=>'status', 'text'=>'เล็บเท้า', 'id'=>'7', 'total'=>0);

$this->skill[] = array('cls'=>'status bl', 'text'=>'SAUNA', 'id'=>'12', 'total'=>0);
$this->skill[] = array('cls'=>'status bl', 'text'=>'AKASURI', 'id'=>'13', 'total'=>0);
$this->skill[] = array('cls'=>'status bl', 'text'=>'อาบน้ำ', 'id'=>'11', 'total'=>0);
$this->skill[] = array('cls'=>'status bl', 'text'=>'DRINK', 'id'=>'drink', 'total'=>0);


$col = 0;
$th = '';
// $th .= '<th class="check-box"></th>';
$th .= '<th class="ID" data-col="'.$col.'">#</th>';
// $th .= '<th class="status" data-col="1"></th>';

$col++;
$th .= '<th class="name" data-col="'.$col.'">ข้อมูล</th>';

$col++;
$th .= '<th class="td_vip" data-col="'.$col.'">V.I.P.</th>';

foreach ($this->skill as $key => $value) {
	$col++;
	$th .= '<th class="'.$value['cls'].'" data-col="'.$col.'">'.$value['text'].'</th>';
}

$col++;
$th .= '<th class="num amount bl" data-col="'.$col.'">รวม</th>';

/*$col++;
$th .= '<th class="num pay" data-col="'.$col.'"></th>';*/


$tbody = '';

for ($i=1; $i <= 20; $i++) { 

	$number = sprintf("%03d",$i);

	$td = '';
	// $td .= '<td class="check-box"></td>';
	$td .= '<td class="ID">'.
		'<div class="clearfix phs">'. 
			'<label class="checkbox">'.
				'<input type="checkbox" value="01">'.
				'<span class="fwb mls">'.$number.'</span>'.
			'</label>'.
			
		'</div>'.
	'</td>';

	$td .= '<td class="name"><div class="pvs">'.	
		'<table>'.
			'<tr><td class="label">สมาชิก</td><td class="data">-</td></tr><tr>'.
			'<tr><td class="label">สถานะ</td><td class="data"><span class="ui-status">กำลังใช่บริการ</span></td></tr>'.
			'<tr><td class="label">เวลา</td><td class="data">9.10-11.10</td></tr><tr>'.
		'</table>'.
	'</div></td>';
	$td .= '<td class="td_vip">'.
		'<div class="unit">2.50 Hr.</div>'.
		'<div class="price-warp"><span class="ui-status float coupon">C</span><span class="price">9,999</span></div>'.
	'</td>';


	foreach ($this->skill as $key => $value) {

		$val = '';
		if( !isset($value['key']) ) $value['key'] = 'val';

		if( $value['key']=='mas' ){
			$val = '<ul>'.	
				'<li><span class="ui-status">PB101</span></li>'.
				// '<li><span class="ui-status">PB101</span></li>'.
			'</ul>';
		}
		else{
			$val .= '<div class="unit">2.50 Hr.</div>';

			$val .= '<div class="price-warp">'.
				'<span class="ui-status float percent">20%</span>'.
				// '<span class="ui-status float coupon">C</span>'.
				'<span class="price">9,999</span>'.
			'</div>';


		}

		$td .= '<td class="'.$value['cls'].'">'.$val.'</td>';
	}

	
	$td .= '<td class="num amount bl has-discount">'.
		'<span class="cost">1000</span>'.
		'<span class="discount">-1000</span>'.
		'<span class="total">1000</span>'.
	'</td>';

	$td .= '<td class="num pay">1000</td>';

	$tbody .= '<tr>'.$td.'</tr>';
}

$col = 1;
$tfoot = '';
$tfoot .= '<th class="name">ยอดรวม</th>';

$col++;
$tfoot .= '<th class="td_vip" data-col="'.$col.'">9,999</th>';

foreach ($this->skill as $key => $value) {
	$col++;

	if( $value['text']=='HR.' || $value['text']=='NO.' ){
		continue;
	}
	$tfoot .= '<th class="'.$value['cls'].'" data-col="'.$col.'">'.'9,999'.'</th>';
}
$tfoot .= '<th class="num amount bl">99,999</th>';


$arr['title'] = 

/*'<div class="clearfix">'.
	'<div class="lfloat">Orders</div>'.
	'<div class="rfloat">'.

		'<table><tbody><tr>'.
			'<td>'.
				'หน้า <ul class="ui-list-page">'.
					'<li>1</li>'.
					'<li class="active">2</li>'.
				'</ul>'.
			'</td>'.
			'<td class="pll"><a role="dialog-close" class="btn">ปิด</a></td>'.
		'</tr></tbody></table>'.

	'</div>'.
'</div>'.*/
'<div class="clearfix fsm fwn">
	<div class="lfloat">
		<table><tbody><tr>'.
			'<td><a class="btn js-refresh"><i class="icon-refresh"></i></a></td>'.
			'<td><input type="date" data-plugins="datepicker" /></td>'.
			
			'<td><a class="btn">แยกบิล</a></td>'.
			'<td><a class="btn">รวมบิล</a></td>'.
			'<td><a class="btn btn-red">ลบบิล</a></td>'.
			'<td><a class="btn btn-blue">จ่ายเงิน</a></td>'.
			'<td><a class="btn btn-blue">ดูบิล</a></td>'.
		'</tr></tbody></table>
	</div>'.
	
	'<div class="rfloat">'.

		'<table><tbody><tr>'.
			'<td width="220"><div class="form-search"><input type="text" name="q" class="inputtext input-search" act="inputsearch" placeholder="ค้นหา.."><button type="button" class="btn-search"><i class="icon-search"></i></button></div></td>'.
			'<td class="pll">'.
				'หน้า <ul class="ui-list-page">'.
					'<li>1</li>'.
					'<li class="active">2</li>'.
				'</ul>'.
			'</td>'.
			'<td class="pll"><a role="dialog-close" class="btn"><i class="icon-remove mrs"></i>ปิด</a></td>'.
		'</tr></tbody></table>'.

	'</div>'.
'</div>';

$arr['form'] = '<div class="model-2-warp">';

$arr['body'] = '<div class="" style="height: 600px;position: relative;overflow: hidden;" data-plugins="orderlists">'.
		

		// thead
		'<div role="thead" style="overflow-y: auto;position: absolute;left: 0;right: 0;top: 0;z-index: 10;">'.
			'<div style="padding-left: 20px;padding-right: 20px;"><table class="table-model-2">'.
				'<thead><tr>'.$th.'</tr></thead>'.
			'</table></div>'.
		'</div>'.
		// end: thead

		// tbody
		'<div role="tbody" style="overflow-y: auto;position: absolute;left: 0;right: 0;bottom: 0;top: 0;">'.
			'<div style="padding: 20px;"><table class="table-model-2">'.

				// '<thead><tr>'.$th.'</tr></thead>'.
				'<tbody ref="listbox">'.$tbody.'</tbody>'.

			'</table></div>'.


			// line
			'<div role="line" style="position: absolute;left: 0;top:0;z-index: 5;">'.
				'<div class="order-line" style="top: 34px;left: 289px;height: 130px;">'.
					'<span class="dot"></span>'.
					'<div class="label">'.
						'<div class="">V 3-5</div>'.
						'<div class="unit">2.50 Hr.</div>'.
						'<div class="price-warp">'.
							'<span class="ui-status float percent">10%</span>'.
							'<span class="price">9,999</span>'.
						'</div>'.
					'</div>'.

				'</div>'.

				'<div class="order-line" style="top: 32px;left: 1502px;height: 130px;">'.
					'<span class="dot"></span>'.
					'<div class="label">'.
						'<div class="price-warp">'.
							'<span class="price">9,999</span>'.
						'</div>'.
					'</div>'.
				'</div>'.
			'</div>'.

		'</div>'.
		// end: tbody

		// tfoot
		'<div role="tfoot" style="overflow-y: auto;position: absolute;left: 0;right: 0;bottom: 0;z-index: 10;">'.
			'<div style="padding-left: 20px;padding-right: 20px;padding-bottom: 20px;    background-color: #fff;"><table class="table-model-2">'.
				'<tfoot><tr>'.$tfoot.'</tr></tfoot>'.
			'</table></div>'.
		'</div>'.
		// end: tfoot


		
	
'</div>';
/*
$arr['button'] = '<span class="gbtn"><button type="submit" role="submit"  class="btn btn-blue btn-submit"><span class="btn-text">ดูบิล</span></button></span>';
$arr['bottom_msg'] = '<span class="gbtn"><a class="btn" role="dialog-close"><span class="btn-text">ปิด</span></a></span>';*/

$arr['width'] = 'full';
$arr['width'] = 1600;
// $arr['height'] = 'full';
echo json_encode($arr);