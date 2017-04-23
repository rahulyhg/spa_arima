<?php

$this->has_invite = isset($_REQUEST['invite']) ? $_REQUEST['invite']: 1;
if( !empty($this->item) ){
	$this->has_invite = $this->item['has_invite'];
}

if( !empty($_REQUEST['obj_type']) && !empty($_REQUEST['obj_id']) && !isset($_REQUEST['invite']) ) $this->has_invite = 0;


$startDate = '';
if( !empty($this->item['start']) ){
	$startDate = $this->item['start'];
}
elseif( isset($_REQUEST['date']) ){
	$startDate = $_REQUEST['date'];
}

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form   ->field("event_title")
        ->label($this->lang->translate('Topic'))
        ->addClass('inputtext')
        ->placeholder('')
        ->autocomplete('off')
        ->value( !empty($this->item['title']) ? $this->item['title']:'' );

$form 	->field("event_location")
		->label($this->lang->translate('Location'))
		->addClass('inputtext')
		->placeholder('')
		->autocomplete('off')
		->value( !empty($this->item['location']) ? $this->item['location']:'' );

$form 	->field("event_start")
		->label($this->lang->translate('Date'))
		->text( '<div style="min-height: 159px;" data-plugins="eventdate" data-options="'.$this->fn->stringify( array(

			'startDate' => $startDate,
			'endDate' => !empty($this->item['end']) ? $this->item['end']:'',
			'allday' => !empty($this->item['allday']) ? $this->item['allday']:true,
		) ).'"></div>' );


$form 	->field("event_color_code")
		->label($this->lang->translate('Color'))
		->addClass('inputtext')
		->type('textarea')
		->attr('data-plugins', 'colors')
		->placeholder('')
		->autocomplete('off')
		->value( !empty($this->item['color_code']) ? $this->item['color_code']:'' );

$form 	->field("event_text")
		->label($this->lang->translate('Description'))
		->addClass('inputtext')
		->type('textarea')
		->placeholder('')
		->autocomplete('off')
		->value( !empty($this->item['text']) ? $this->item['text']:'' );

$formDetail = $form->html();

if( $this->has_invite ){

	$form = new Form();
	$form = $form->create()->elem('div')->addClass('form-insert');
	$form 	->field("event_invite")
			->label('ผู้ที่เกี่ยวข้อง')
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
				'<select class="inputtext" act="selector" name="objects">'.
					'<option>ทั้งหมด</option>'.
					'<option value="employees">พนักงาน</option>'.
					'<option value="customers">ลูกค้า</option>'.
				'</select>'.
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
		'url' => URL.'events/invite',
	);

	if( !empty( $this->item['invite'] ) ){
		$optionsInvite['invite'] = $this->item['invite'];
	}

	$arr['hiddenInput'][] = array('name'=>'has_invite','value'=>1);
	

# body
$arr['body'] = '<div class="table-plan-wrap"><div class="table-plan">'.
	'<div class="td-plan-detail">'. $formDetail .'</div>'.
	'<div class="td-plan-invite ui-invite" data-plugins="invite" data-options="'.$this->fn->stringify($optionsInvite).'">'.$formInvite.'</div>'.
'</div></div>';
$arr['width'] = 950; //-180  770 - 400 370

}
else{
	$arr['body'] = $formDetail;

	$arr['hiddenInput'][] = array('name'=>'has_invite','value'=>0);

	if( !empty($this->item) ){

	}
	else{
		$obj_type = $_REQUEST['obj_type'];
		$obj_id = $_REQUEST['obj_id'];
		if( is_array($obj_type) ){
			for ($i=0; $i < count($obj_type); $i++) { 
				$arr['hiddenInput'][] = array('name'=>'invite[type][]','value'=>$obj_type[$i]);
				$arr['hiddenInput'][] = array('name'=>'invite[id][]','value'=>$obj_id[$i]);
			}
		}
		else{
			$arr['hiddenInput'][] = array('name'=>'invite[type][]','value'=>$obj_type);
			$arr['hiddenInput'][] = array('name'=>'invite[id][]','value'=>$obj_id);

		}
	}
}

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'events/save"></form>';

$arr['button'] = '';
if( !empty($this->item) ){
    $arr['title']= "แก้ไขนัดหมาย";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);

}
else{
    $arr['title']= "เพิ่มนัดหมาย";
}

$has_callback = '';
if( isset( $_REQUEST['callback'] ) ){
    $arr['hiddenInput'][] = array('name'=>'callback','value'=>$_REQUEST['callback']);
    $has_callback = ' role="submit"';
}

$arr['button'] .= '<button type="submit"'.$has_callback.' class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);