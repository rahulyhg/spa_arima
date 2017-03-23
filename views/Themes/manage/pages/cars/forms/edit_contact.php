<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

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

/*
$addr = array();
$addr[] = array(
    'id'=>'cus_city_id',
    'label'=>'จังหวัด',
    'type'=>'select',
    'options'=>$this->city['lists'],
    'value' => $this->item['city_id']
);

$addr[] = array(
    'id'=>'cus_zip',
    'label'=>'รหัสไปรษณีย์',
    'value'=> $this->item['zip'] 
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

    $address .= '<div class="u-table-cell">'.$input.'</div>';
}


$form   ->field("address")
        ->text( '<div class="u-table"><div class="u-table-row">'.$address.'</div></div>' );
*/

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
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'customers/update_contact"></form>';

# body
$arr['body'] = $form->html();

if( !empty($this->item) ){
    $arr['title']= "Edit Customres ".$this->item['fullname'];
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "New Customres";
}

$arr['width'] = 540;
$arr['height'] = 'auto';
$arr['overflowY'] = 'auto';
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);