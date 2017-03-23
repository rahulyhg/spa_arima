<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert pal');

$name = '';
$a[] = array( 
    'id' => 'cus_prefix_name', 
    'label' => 'คำนำหน้าชื่อ',
    'type' => 'select',
    'options' => $this->prefixName
);

$a[] = array( 
    'id' => 'cus_first_name', 
    'label' => 'ชื่อ',
);

$a[] = array( 
    'id' => 'cus_last_name', 
    'label' => 'นามสกุล',
);

/*$a[] = array( 
    'id' => 'cus_nickname', 
    'label' => 'ชื่อเล่น',
);
*/
foreach ($a as $value) {

    $type = isset($value['type']) ? $value['type'] : 'text';
    if($type=='select'){
        
        $option = '';
        foreach ($value['options'] as $data) {
            $option .= '<option value="'.$data['id'].'">'.$data['name'].'</option>';
        }

        $input = '<select class="inputtext" id="'.$value['id'].'" name="'.$value['id'].'">'.$option.'</select>';
    }
    else{

        $input = '<input id="'.$value['id'].'" autocomplete="off" placeholder="'.$value['label'].'" class="inputtext" type="text" name="'.$value['id'].'">';
    }

    $name .= '<div class="u-table-cell">'.$input.'</div>';
}


$form   ->field("name")
        ->label('ชื่อ')
        ->text( '<div class="u-table"><div class="u-table-row">'.$name.'</div></div>' );

$form   ->field("cus_nickname")
        ->label('ชื่อเล่น')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['nickname'])? $this->item['nickname']:'' );

$birthday = '';
$day = '';
for ($i=1; $i <= 31; $i++) { 
    $day .= '<option value="'.$i.'">'.$i.'</option>';
}
$birthday .= '<div class="u-table-cell"><select class="inputtext" name="birthday[date]">'.$day.'</select></div>';

$m = '';
for ($i=1; $i <= 12; $i++) { 
    $m .= '<option value="'.$i.'">'. $this->fn->q('time')->month( $i, true).'</option>';
}
$birthday .= '<div class="u-table-cell"><select class="inputtext" name="birthday[month]" class="u-table-cell">'.$m.'</select></div>';


$y = '';
$_year = date('Y');
for ($i=0; $i < 60; $i++) {
    $y .= '<option value="'.$_year.'">'.($_year+543).'</option>';
    $_year--;
    
}
$birthday .= '<div class="u-table-cell"><select class="inputtext" name="birthday[year]" class="u-table-cell">'.$y.'</select></div>';

$form   ->field("birthday")
        ->label('วันเกิด')
        ->text( '<div class="u-table"><div class="u-table-row">'.$birthday.'</div></div>' );

$form   ->field("cus_card_id")
        ->label('หมายเลขบัตรประจำตัวประชาชน')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['card_id'])? $this->item['card_id']:'' );

/*$form   ->field('cus_address')
        ->label('ที่อยู่')
        ->addClass('inputtext')
        ->type('textarea')
        ->attr('data-plugins', 'autosize')
        ->value( !empty($this->item['address'])? $this->fn->q('text')->textarea($this->item['address']):'' );*/

$address = array( 0=> 

    array( 0 => 
        array(
            'id' => 'address_number', 
            'name' => 'address[number]', 
            'label' => 'บ้านเลขที่',
        ),
        array(
            'id' => 'address_mu', 
            'name' => 'address[mu]', 
            'label' => 'หมู่ที่',
        ),
        array(
            'id' => 'address_village', 
            'name' => 'address[village]', 
            'label' => 'หมู่บ้าน',
        ),
        array(
            'id' => 'address_alley', 
            'name' => 'address[alley]', 
            'label' => 'ซอย',
        ),
    ),

    array( 0 => 
        array(
            'id' => 'address_street', 
            'name' => 'address[street]', 
            'label' => 'ถนน',
        ),
        array(
            'id' => 'address_district', 
            'name' => 'address[district]', 
            'label' => 'แขวง/ตำบล',
        ),
        array(
            'id' => 'address_amphur', 
            'name' => 'address[amphur]', 
            'label' => 'เขต/อำเภอ'
        ),
    ),

    array( 0 => 
        array(
            'id' => 'address_city', 
            'name' => 'address[city]', 
            'label' => 'จังหวัด',
            'type' => 'select',
            'options' => $this->city['lists'],
            'value' => 1
        ),
        array(
            'id' => 'address_zip', 
            'name' => 'address[zip]', 
            'label' => 'รหัสไปรษณีย์'
        ),
    ),
);

$form   ->field("cus_address")
        ->name('cus[address]')
        ->label('ที่อยู่')
        ->text( '<div class="table-address-wrap">'. $this->fn->uTableAddress($address).'</div>' );

$addr = array();
$addr[] = array(
    'id'=>'cus_city_id',
    'label'=>'จังหวัด',
    'type'=>'select',
    'options'=>$this->city['lists']
);

$addr[] = array(
    'id'=>'cus_zip',
    'label'=>'รหัสไปรษณีย์'
);
$addr[] = array( 'space'=>true );

$address = '';

foreach ($addr as $value) {

    $type = isset($value['type']) ? $value['type'] : 'text';
    if( isset($value['space']) ){
        $input ='<div style="width:120px"></div>';
    }
    elseif($type=='select'){
        
        $option = '';
        foreach ($value['options'] as $data) {
            $option .= '<option value="'.$data['id'].'">'.$data['name'].'</option>';
        }

        $input = '<select class="inputtext" id="'.$value['id'].'" name="'.$value['id'].'">'.$option.'</select>';
    }
    else{

        $input = '<input id="'.$value['id'].'" autocomplete="off" placeholder="'.$value['label'].'" class="inputtext" type="text" name="'.$value['id'].'">';
    }

    $address .= '<div class="u-table-cell">'.$input.'</div>';
}


$form   ->field("address")
        ->text( '<div class="u-table"><div class="u-table-row">'.$address.'</div></div>' );

$label_Email = array();
$label_Email[] = array('text'=>'Personal Email');
$label_Email[] = array('text'=>'Work Email');
$label_Email[] = array('text'=>'Other Email');


$fieldset = '';
if( !empty($this->item['options']['email']) ){

    foreach ($this->item['options']['email'] as $key => $value) {

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
if( !empty($this->item['options']['phone']) ){

    foreach ($this->item['options']['phone'] as $key => $value) {

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
if( !empty($this->item['options']['social']) ){

    foreach ($this->item['options']['social'] as $key => $value) {

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

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'customers/save"></form>';

# body
$arr['body'] = $form->html();

if( !empty($this->item) ){
    $arr['title']= "Edit Customres";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "New Customres";
}

$arr['width'] = 540;
$arr['height'] = 'full';
$arr['overflowY'] = 'auto';
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);