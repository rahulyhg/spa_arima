<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form   ->field("cus_code")
        ->label($this->lang->translate('code'))
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['code'])? $this->item['code']:'' );

//level
$level = '';
foreach ($this->level as $key => $value) {

	$sel = '';
	if( $value['id'] == $this->item['level']['id'] ){
		$sel = ' selected';
	}

	$level .= '<option'.$sel.' value="'.$value['id'].'">'.$value['name'].'</option>';
}

$level = '<select class="inputtext" name="cus_level_id">'.$level.'</select>';

$form 	->field("cus_level_id")
		->label( $this->lang->translate("level") )
		->text( $level );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'customers/update_cus_level"></form>';

# body
$arr['body'] = $form->html();

if( !empty($this->item) ){
    $arr['title']= "ระดับสมาชิก";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}

$arr['width'] = 540;
$arr['height'] = 'auto';
$arr['overflowY'] = 'auto';
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);