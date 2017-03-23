<?php

$form = new Form();
$form = $form->create()
    ->url( URL."customers/update")
    ->addClass('js-submit-form form-insert mbl clearfix form-editor')
    ->attr('data-plugins', 'formEditor')
    ->method('post');

$name = '';
$a[] = array( 
    'id' => 'cus_prefix_name', 
    'label' => 'คำนำหน้าชื่อ',
    'type' => 'select',
    'options' => $this->prefixName,
    'value' => $this->customer['prefix_name']
);

$a[] = array( 
    'id' => 'cus_first_name', 
    'label' => 'ชื่อ',
    'value' => $this->customer['first_name']
);

$a[] = array( 
    'id' => 'cus_last_name', 
    'label' => 'นามสกุล',
    'value' => $this->customer['last_name']
);

/* set name*/
foreach ($a as $value) {

    $type = isset($value['type']) ? $value['type'] : 'text';
    if($type=='select'){
        
        $option = '';
        foreach ($value['options'] as $data) {

            $sel = '';
            if( !empty($value['value']) ){
                if( $value['value']==$data['id']  ){
                    $sel = ' selected="1"';
                }
            }

            $option .= '<option'.$sel.' value="'.$data['id'].'">'.$data['name'].'</option>';
        }

        $input = '<select class="inputtext" id="'.$value['id'].'" name="'.$value['id'].'">'.$option.'</select>';
    }
    else{

        $input = '<input id="'.$value['id'].'" autocomplete="off" placeholder="'.$value['label'].'" class="inputtext" type="text" name="'.$value['id'].'" value="'.( !empty($value['value'])? $value['value']: '' ).'">';
    }

    $name .= '<div class="u-table-cell">'.$input.'</div>';
}


$form   ->field("name")
        ->label('ชื่อ')
        ->text( '<div class="u-table"><div class="u-table-row">'.$name.'</div></div>' );

$form   ->field("cus_card_id")
        ->label('เลขบัตรประจำตัวประชาชน')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->customer['card_id'])? $this->customer['card_id']:'' );



$birthday = '';
$day = '<option value="00">วัน</option>';
for ($i=1; $i <= 31; $i++) { 

    $see = '';
    if( $this->customer['birthday']!='0000-00-00' ){
        $see = date('j', strtotime($this->customer['birthday'])) == $i ? ' selected="1"':'';
    }
    
    $day .= '<option'.$see.' value="'.$i.'">'.$i.'</option>';
}
$birthday .= '<div class="u-table-cell"><select class="inputtext" name="birthday[date]">'.$day.'</select></div>';

$m = '<option value="00">เดือน</option>';
for ($i=1; $i <= 12; $i++) { 

    $see = '';
    if( $this->customer['birthday']!='0000-00-00' ){
        $see = date('n', strtotime($this->customer['birthday'])) == $i ? ' selected="1"':'';
    }
    $m .= '<option'.$see.' value="'.$i.'">'. $this->fn->q('time')->month( $i, true).'</option>';
}
$birthday .= '<div class="u-table-cell"><select class="inputtext" name="birthday[month]" class="u-table-cell">'.$m.'</select></div>';


$y = '<option value="0000">ปี</option>';
$_year = date('Y')-6;
for ($i=0; $i < 60; $i++) {

    $see = '';
    if( $this->customer['birthday']!='0000-00-00' ){
        $see = date('Y', strtotime($this->customer['birthday'])) == $_year ? ' selected="1"':'';
    }

    $y .= '<option'.$see.' value="'.$_year.'">'.($_year+543).'</option>';
    $_year--;
    
}
$birthday .= '<div class="u-table-cell"><select class="inputtext" name="birthday[year]" class="u-table-cell">'.$y.'</select></div>';

$form   ->field("birthday")
        ->label('วันเกิด')
        ->text( '<div class="u-table"><div class="u-table-row">'.$birthday.'</div></div>' );

/*$form ->field("cus_email")
        ->label("Email")
        ->addClass('inputtext')
        ->autocomplete("off")
        ->value( !empty($this->customer['email']) ? $this->customer['email']:'' );*/

$label_Email = array();
$label_Email[] = array('text'=>'Personal Email');
$label_Email[] = array('text'=>'Work Email');
$label_Email[] = array('text'=>'Other Email');


$fieldset = '';
if( !empty($this->customer['options']['email']) ){

    foreach ($this->customer['options']['email'] as $key => $value) {

    $_label_Email = '';
    foreach ($label_Email as $val) {

        $s = $value['name'] == $val['text'] ? ' selected="1"':'';
        $_label_Email .='<option'.$s.' value="'.$val['text'].'">'.$val['text'].'</option>';
    }

    $fieldset .= '<fieldset class="control-group">'.
        '<label class="control-label">'.
            '<select name="options[email][name][]" class="labelselect">'.$_label_Email.'</select>'.
        '</label>'.
        '<div class="controls">'.
            '<input class="inputtext js-input" autocomplete="off" type="text" name="options[email][value][]" value="'.$value['value'].'">'.
            '<div class="notification"></div>'.
        '</div>'.
    '</fieldset>';
    }
}
else{

    $_label_Email = '';
    foreach ($label_Email as $value) {
        $_label_Email .='<option value="'.$value['text'].'">'.$value['text'].'</option>';
    }
    $fieldset = '<fieldset class="control-group">'.
        '<label class="control-label">'.
            '<select name="options[email][name][]" class="labelselect">'.$_label_Email.'</select>'.
        '</label>'.
        '<div class="controls">'.
            '<input class="inputtext js-input" autocomplete="off" type="text" name="options[email][value][]">'.
            '<div class="notification"></div>'.
        '</div>'.
    '</fieldset>';
}

$form->hr('<div class="form-field clearfix">'.
    $fieldset.
    '<a class="btn-add js-add-field">Add Email</a>'.
'</div>'
);


$label_phone = array();
$label_phone[] = array('text'=>'Mobile Phone');
$label_phone[] = array('text'=>'Work Phone');
$label_phone[] = array('text'=>'Home Phone');
$label_phone[] = array('text'=>'Other Phone');

$fieldset = '';
if( !empty($this->customer['options']['phone']) ){

    foreach ($this->customer['options']['phone'] as $key => $value) {

    $_label_phone = '';
    foreach ($label_phone as $val) {

        $s = $value['name'] == $val['text'] ? ' selected="1"':'';
        $_label_phone .='<option'.$s.' value="'.$val['text'].'">'.$val['text'].'</option>';
    }

    $fieldset .= '<fieldset class="control-group">'.
        '<label class="control-label">'.
            '<select name="options[phone][name][]" class="labelselect">'.$_label_phone.'</select>'.
        '</label>'.
        '<div class="controls">'.
            '<input class="inputtext js-input" autocomplete="off" type="text" name="options[phone][value][]" value="'.$value['value'].'">'.
            '<div class="notification"></div>'.
        '</div>'.
    '</fieldset>';
    }
}
else{

    $_label_phone = '';
    foreach ($label_phone as $value) {
        $_label_phone .='<option value="'.$value['text'].'">'.$value['text'].'</option>';
    }
    $fieldset = '<fieldset class="control-group">'.
        '<label class="control-label">'.
            '<select name="options[phone][name][]" class="labelselect">'.$_label_phone.'</select>'.
        '</label>'.
        '<div class="controls">'.
            '<input class="inputtext js-input" autocomplete="off" type="text" name="options[phone][value][]">'.
            '<div class="notification"></div>'.
        '</div>'.
    '</fieldset>';
}

$form->hr('<div class="form-field clearfix">'.
    $fieldset.
    '<a class="btn-add js-add-field">Add Phone</a>'.
'</div>'
);

$label_social = array();
$label_social[] = array('text'=>'Line ID');
$label_social[] = array('text'=>'facebook');
$label_social[] = array('text'=>'Other Social');

$fieldset = '';
if( !empty($this->customer['options']['social']) ){

    foreach ($this->customer['options']['social'] as $key => $value) {

    $_label_social = '';
    foreach ($label_social as $val) {

        $s = $value['name'] == $val['text'] ? ' selected="1"':'';
        $_label_social .='<option'.$s.' value="'.$val['text'].'">'.$val['text'].'</option>';
    }

    $fieldset .= '<fieldset class="control-group">'.
        '<label class="control-label">'.
            '<select name="options[social][name][]" class="labelselect">'.$_label_social.'</select>'.
        '</label>'.
        '<div class="controls">'.
            '<input class="inputtext js-input" autocomplete="off" type="text" name="options[social][value][]" value="'.$value['value'].'">'.
            '<div class="notification"></div>'.
        '</div>'.
    '</fieldset>';
    }
}
else{

    $_label_social = '';
    foreach ($label_social as $value) {
        $_label_social .='<option value="'.$value['text'].'">'.$value['text'].'</option>';
    }
    $fieldset = '<fieldset class="control-group">'.
        '<label class="control-label">'.
            '<select name="options[social][name][]" class="labelselect">'.$_label_social.'</select>'.
        '</label>'.
        '<div class="controls">'.
            '<input class="inputtext js-input" autocomplete="off" type="text" name="options[social][value][]">'.
            '<div class="notification"></div>'.
        '</div>'.
    '</fieldset>';
}

$form->hr('<div class="form-field clearfix">'.
    $fieldset.
    '<a class="btn-add js-add-field">Add Social</a>'.
'</div>'
);

/*

/*$form->field("options[location][address]")
        ->label('ที่อยู่')
        ->type('textarea')
        ->addClass('inputtext')
        ->attr('data-plugins', 'autosize')
        ->value( !empty($this->customer['address']) ? $this->fn->q('text')->textarea($this->customer['address']):'' );

$form   ->field("city")
        ->text( '<div class="u-table"><div class="u-table-row">'.
            '<div class="u-table-cell"><select name="options[location][city]" class="inputtext"></select></div>'.
            '<div class="u-table-cell plm" style="width:80px"><input name="options[location][zip]" class="inputtext" ></div>'.
        '</div></div>' );*/


$form ->hr('<input type="hidden" name="id" value="'.$this->customer['id'].'">');

if( !empty($this->hasMasterHost) ){
    $form ->hr('<input type="hidden" name="company" value="'.$this->company['id'].'">');
}

$form->submit()
        ->addClass("btn-submit btn btn-blue rfloat")
        ->value("บันทึก");




$subname = '';
if( !empty($this->customer['phone']) ){
    $subname .= !empty($subname) ? ', ':'';
    $subname .= '<i class="icon-phone mrs"></i>' . $this->customer['phone'];
}

if( !empty($this->customer['email']) ){
    $subname .= !empty($subname) ? ', ':'';
    $subname .= '<i class="icon-envelope-o mrs"></i>' .$this->customer['email'];
}

if( !empty($this->customer['lineID']) ){
    $subname .= !empty($subname) ? ', ':'';
    $subname .= 'Line ID: '.$this->customer['lineID'].'<a target="_blank" href="http://line.me/ti/p/~'.$this->customer['lineID'].'"><i class="mls icon-external-link"></i></a>';
}


$age = '';
if( $this->customer['birthday'] !='0000-00-00' ){
    $age = '<span class="fsm fwn" style="opacity: .8">(อายุ '.$this->fn->q('time')->age( $this->customer['birthday'] ).' ปี)</sapn>';
}


$arr['toolbar'] = '<div class="pal clearfix">'.

    '<div class="rfloat"><a class="btn btn-red js-del" data-id="'.$this->customer['id'].'">ลบ</a></div>'.
    '<div class="anchor clearfix"><div class="avatar lfloat no-avatar mrm"><div class="initials">'.$this->customer['initials'].'</div></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">'.$this->customer['fullname'].' '.$age.'</div><div class="subname fsm">'.$subname.'</div></div></div></div>'.
    '<div class="mts fsm" style="opacity: .8">แก้ไขล่าสุด: '.$this->fn->q('time')->live( $this->customer['updated'] ).'</div>'.
'</div>';

# body
$arr['content'] = '<div>'.
    '<div class="pal">'. $form->html(). '<div>'.
'<div>';


echo json_encode($arr);