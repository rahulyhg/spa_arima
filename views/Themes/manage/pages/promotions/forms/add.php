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
	->addClass('form-insert');

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

$form 	->field("event_start")
		->label($this->lang->translate('Date'))
		->text( '<div style="min-height: 159px;" data-plugins="eventdate" data-options="'.$this->fn->stringify( array(

			'startDate' => $startDate,
			'endDate' => !empty($this->item['end']) ? $this->item['end']:'',
			'allday' => true,
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

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'promotions/save"></form>';

# body
$arr['body'] = $form->html();

# title
if( !empty($this->item) ){
    $arr['title']= "{$title}";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "{$title}";
}

// $arr['height'] = 'full';
// $arr['overflowY'] = 'auto';
$arr['width'] = 550;

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';

echo json_encode($arr);