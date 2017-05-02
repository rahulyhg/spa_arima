<?php

$startDate = '';
if( !empty($this->item['start']) ){
	$startDate = $this->item['start'];
}
elseif( isset($_REQUEST['date']) ){
	$startDate = $_REQUEST['date'];
}

$title = $this->lang->translate('Promotions');

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert pal');

$type = '';
foreach ($this->type as $key => $value) {
	
	$sel = '';
	if( !empty($this->item['type']) ){

		if( $this->item['type'] == $value['id'] ){
			$sel = ' selected="1"';
		}
	}
	$type .= '<option'.$sel.' value="'.$value['id'].'">'.$value['name'].'</option>';
}

$type = '<select class="inputtext" name="pro_type">'.$type.'</select>';

$form 	->field("pro_type")
		->label($this->lang->translate("Type"))
		->text( $type );

$form   ->field("pro_name")
        ->label($this->lang->translate('Name'))
        ->addClass('inputtext')
        ->required(true)
        ->autocomplete("off")
        ->value( !empty($this->item['name']) ? $this->item['name']:'' );

$form   ->field("pro_discount")
        ->label($this->lang->translate('Discount'))
        ->addClass('inputtext')
        ->autocomplete("off")
        ->type('number')
        ->value( !empty($this->item['discount']) ? round($this->item['discount']):'' );

$form 	->field("pro_qty")
		->label($this->lang->translate('Quantity'))
		->addClass('inputtext')
		->autocomplete('off')
		->type('number')
		->value( !empty($this->item['qty']) ? $this->item['qty']:'' );

if( !empty($this->item['end']) ){
	if( $this->item['end']=='0000-00-00 00:00:00' ){
		$this->item['end'] = '';
	}
}

$form 	->field("event_start")
		->label($this->lang->translate('Close Date'))
		->text( '<div data-plugins="setdate" data-options="'.$this->fn->stringify( array(

			'startDate' => $startDate,
			'endDate' => !empty($this->item['end']) ? $this->item['end']:'',

			'allday' => 'disabled',
			'endtime' => false,
			'time' => 'disabled',

			'str' => array(
				$this->lang->translate('Start'),
				$this->lang->translate('End'),
				$this->lang->translate('All day'),
				$this->lang->translate('End Time'),
			),

			'lang' => $this->lang->getCode()

		) ).'"></div>' );

$status = '';
foreach ($this->status as $key => $value) {
	
	$sel = "";
	if( !empty($this->item['status']) ){

		if( $this->item['status'] == $value['id'] ){
			$sel = ' selected="1"';
		}
	}

	$status .= '<option'.$sel.' value="'.$value['id'].'">'.$value['name'].'</option>';
}

$status = '<select class="inputtext" name="pro_status">'.$status.'</select>';

$form   ->field("pro_status")
        ->label($this->lang->translate('Status'))
        ->text( $status );


$formDetail = $form->html();


// 
$form = new Form();
	$form = $form->create()->elem('div')->addClass('form-insert');
	$form 	->field("event_invite")
			->label( $this->lang->translate('Package') )
			->text( //'<div class="">'.

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

'');

$formInvite = $form->html();
$optionsInvite = array(
	'url' => URL.'promotions/invite',
);

if( !empty( $this->item['invite'] ) ){
	$optionsInvite['invite'] = $this->item['invite'];
}



# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'promotions/save"></form>';

# body
$arr['body'] = '<div class="table-plan-wrap"><div class="table-plan table-plan-promotions">'.
    '<div class="td-plan-detail">'.$formDetail.'</div>'.
    '<div class="td-plan-invite ui-invite" data-plugins="invite" data-options="'.$this->fn->stringify($optionsInvite).'">'.$formInvite.'</div>'.
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
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';

echo json_encode($arr);