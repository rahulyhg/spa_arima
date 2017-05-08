<?php

$startDate = '';
if( !empty($this->item['start_date']) ){
	if( $this->item['start_date'] != '0000-00-00 00:00:00' ){
		$startDate = $this->item['start_date'];
	}
}
elseif( isset($_REQUEST['date']) ){
	$startDate = $_REQUEST['date'];
}

$endDate = '';
if( !empty($this->item['end_date']) ){
	if( $this->item['end_date'] != '0000-00-00 00:00:00' ){
		$endDate = $this->item['end_date'];
	}
}

$title = $this->lang->translate('Promotions');

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert pal form-promotion');


$form   ->field("pro_name")
        ->label($this->lang->translate('Name'))
        ->addClass('inputtext')
        ->required(true)
        ->autocomplete("off")
        ->value( !empty($this->item['name']) ? $this->item['name']:'' );

/*
'<div class="sidetip">'.
	'<p data-name="pro_type" data-value="percent">ลดราคาจากผลรวมทั้งหมด เป็นเปอร์เซนต์<p>'.
	'<p data-name="pro_type" data-value="amount">ลดราคาจากผลรวมทั้งหมด เป็นจำนวนเงิน<p>'.
	'<p data-name="pro_type" data-value="item">ลดราคาต่อชิ้น<p>'.
'<div>'*/  

$form 	->field("pro_type")
		->label( $this->lang->translate('Discount') . ' ' .$this->lang->translate("Type"))
		->select( $this->type, 'id', 'name', false )
		->addClass('inputtext js-change')
		->value( !empty($this->item['type']['id'])? $this->item['type']['id']:'' )
		->sidetip( array(
			'keys' => array(
				'name' => 'pro_type',
				'value' => 'id',
				'text' => 'note'
			),
			'options' => $this->type,
		) );

$form   ->field("pro_discount")
        ->label( $this->lang->translate('Discount'). ' ' .$this->lang->translate("Value") )
        ->addClass('inputtext')
        ->autocomplete("off")
        ->type('number')
        ->value( !empty($this->item['discount']) ? round($this->item['discount']):'' )
        ->note( 'จำนวนส่วนลด' );

$ck = '';
$qty = '';
if( !empty($this->item['has_qty']) ){
	$ck = ' checked="1"';
	$qty = 'value="'.$this->item['qty'].'"';
}

$form 	->field("pro_qty")
		->text( '<div class="openset">'.
			'<label class="checkbox mbs"><input type="checkbox"'.$ck.' name="has_qty" class="js-openset" value="1"><span>Set Quantity</span></label>'.
			'<div class="content" data-name="has_qty">'.
				'<input id="pro_qty" class="inputtext" autocomplete="off" type="number" name="pro_qty" '.$qty.'>'.
			'</div>'.
			// '<div class="note"></div>'.
			// '<div class="notification"></div>'.
		'</div>' )
		->note( 'กำหนดเมื่อเลือกสินค้าครบจำนวนหรือมากกว่า จะสามารถใช้โปรโมชั่นนี้' );

if( !empty($this->item['end']) ){
	if( $this->item['end']=='0000-00-00 00:00:00' ){
		$this->item['end'] = '';
	}
}

$ck_start = '';
if( !empty($this->item['has_time']) ){
	$ck_start = ' checked="1"';
}

$form 	->field("pro_time")
		// ->label($this->lang->translate('Set Time'))
		->text( '<div class="openset">'.

		'<label class="checkbox mbs"><input type="checkbox"'.$ck_start.' name="has_time"  class="js-openset" value="1"><span>Set Time</span></label>'.

		'<div class="content" data-name="has_time" data-plugins="setdate" data-options="'.$this->fn->stringify( array(

			'startDate' => $startDate,
			'endDate' => $endDate,

			'allday' => true,
			'endtime' => !empty($this->item['has_enddate']) ? true : false,
			// 'time' => 'disabled',

			'str' => array(
				$this->lang->translate('Start'),
				$this->lang->translate('End'),
				$this->lang->translate('All day'),
				$this->lang->translate('End Time'),
			),

			'lang' => $this->lang->getCode()

		) ).'"></div>'.

	'</div>' )
		->note( 'กำหนดวันเริ่มและวันสิ้นสุดของโปรโมชั่น' );

/*$form   ->field("pro_status")
        ->label($this->lang->translate('Status'))
        ->select( $this->status )
        ->addClass('inputtext')
        ->value( !empty($this->item['status']) ? $this->item['status']: '' );

*/
$formDetail = $form->html();


$optionsInvite = array(
	'url' => URL.'promotions/invite',
);

if( !empty( $this->item['invite'] ) ){
	$optionsInvite['invite'] = $this->item['invite'];
}

$ck_join = '';
if( !empty($this->item['is_join']) ){
	$ck_join = ' checked="1"';
}

// 
$form = new Form();
	$form = $form->create()->elem('div')->addClass('form-insert');

	$form 	->field("invite")
			// ->label( $this->lang->translate('Package') )
			->text( '<div class="openset">'.

'<label class="checkbox mbs"><input type="checkbox"'.$ck_join.' name="is_join" class="js-openset" value="1"><span>Set Package</span></label>'.
'<div class="mts mbm pam uiBoxYellow fsm">กำหนดสินค้าที่ร่วมรายการ *หากไม่กำหนดจะถือว่าใช่ได้กับสินค้าทุกชนิด</div>'.

'<div class="content" data-name="is_join" style="position: relative;margin-right: -20px;height: 347px;"  data-plugins="invite" data-options="'.$this->fn->stringify($optionsInvite).'">'.

'<div class="ui-invite-content">'.

'<div class="ui-invite-header" ref="header">'.

		'<div ref="actions">'.
	'<div class="form-search"><input type="text" name="q" class="inputtext input-search" act="inputsearch"><button type="button" class="btn-search"><i class="icon-search"></i></button></div>'.

	/*'<table class="table-search form-search" ref="actions"><tr>'.
		'<td></td>'.
		'<td class="td-input"></td>'.
		// '<td></td>'.
	'<tr></table>'.*/
	
	'<header class="ui-invite-listsbox-header clearfix">'.
		'<div class="lfloat ui-invite-actions">'.
			/*'<select class="inputtext" act="selector" name="objects">'.
				'<option>ทั้งหมด</option>'.
				'<option value="employees">พนักงาน</option>'.
				'<option value="customers">ลูกค้า</option>'.
			'</select>'.*/
		'</div>'.
		'<div class="rfloat"><a class="js-selected-all">เลือกทั้งหมด</a></div>'.
	'</header>'.

	'</div>'.
'</div>'.

'<div class="ui-invite-listsbox has-loading">'.
	'<ul class="ui-list ui-list-user ui-list-checked" ref="listsbox"></ul>'.
	'<a class="ui-more btn">โหลดเพิ่มเติม</a>'.
	'<div class="ui-alert">'.
		'<div class="ui-alert-loader">
			<div class="ui-alert-loader-icon loader-spin-wrap"><div class="loader-spin"></div></div>
			<div class="ui-alert-loader-text">กำลังโหลด...</div> 
		</div>

		<div class="ui-alert-error">
			<div class="ui-alert-error-icon"><i class="icon-exclamation-triangle"></i></div>
			<div class="ui-alert-error-text">ไม่สามารถเชื่อมต่อได้</div> 
		</div>

		<div class="ui-alert-empty">
			<div class="ui-alert-empty-text">ไม่มีไฟล์ <a class="js-upload">เพิ่มไฟล์ใหม่</a></div> 
		</div>'.
	'</div>'.
'</div>'.	

'</div>'.
// end: ui-invite-content

'<div class="ui-invite-selected">'.
	'<header class="ui-invite-selected-header clearfix">'.
		'<div class="lfloat">เลือกแล้ว (<span class="js-selectedCountVal">0</span>)</div>'.
	'</header>'.
	'<div class="ui-invite-selected-listsbox">'.
		'<ul class="ui-list ui-list-token ui-list-horizontal" ref="tokenbox"></ul>'.
	'</div>'.
'</div>'.

'</div>'.

'</div>');

$formInvite = $form->html();

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'promotions/save"></form>';

# body
$arr['body'] = '<div class="table-plan-wrap"><div class="table-plan table-plan-promotions" data-plugins="activeform">'.
    '<div class="td-plan-detail">'.$formDetail.'</div>'.
    '<div class="td-plan-invite ui-invite">'.$formInvite.'</div>'.
'</div></div>';

# title
if( !empty($this->item) ){
    $arr['title']= "{$title}";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "{$title}";
}


$arr['width'] = 900;

# fotter: button
$arr['button'] = '';
if( !empty($this->item) ){
	$arr['button'] .= '<a data-plugins="dialog" href="'.URL.'promotions/del/'.$this->item['id'].'" class="btn btn-red">ลบ</a>';
}
$arr['button'] .= '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';

echo json_encode($arr);