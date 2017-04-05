<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert pal');

$form   ->field("name")
        ->label('ชื่อ')
        ->text( $this->fn->q('form')->fullname( !empty($this->item)?$this->item:array(), array('field_first_name'=>'cus_', 'prefix_name'=>$this->prefixName) ) );

// $form   ->field("birthday")
//         ->label('วันเกิด')
//         ->text( $this->fn->q('form')->birthday( !empty($this->item)?$this->item:array(), array('field_first_name'=>'cus_') ) );

$form   ->field("cus_card_id")
        ->label('หมายเลขบัตรประจำตัวประชาชน / Passport')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['card_id'])? $this->item['card_id']:'' );

$country = '';
foreach ($this->country as $key => $value) {

    $sel = '';
    if( !empty($this->item) ){
        if( $value['id'] == $this->item['country_id'] ){
            $sel = ' selected="1"';
        }
    }

    $country .= '<option'.$sel.' value="'.$value['id'].'">'.$value['name'].'</option>';
}

$country = '<select class="inputtext" name="cus_country_id">'.$country.'</select>';

$form   ->field("cus_country_id")
        ->label("ประเทศ")
        ->text( $country );

// $form   ->field("cus_address")
//         ->name('cus[address]')
//         ->label('ที่อยู่')
//         ->text( $this->fn->q('form')->address( !empty($this->item['address'])? $this->item['address']:array(), array('city'=>$this->city ) ) );

// email
$form->hr( $this->fn->q('form')->contacts( 
    'email',
    !empty($this->item['options']['email'])? $this->item['options']['email']:array(), 
    array( 'field_first_name'=>'options[email]' )
) );

// phone
$form->hr( $this->fn->q('form')->contacts( 
    'phone',
    !empty($this->item['options']['phone'])? $this->item['options']['phone']:array(), 
    array( 'field_first_name'=>'options[phone]' )
) );

// social
$form->hr( $this->fn->q('form')->contacts( 
    'social',
    !empty($this->item['options']['social'])? $this->item['options']['social']:array(), 
    array( 'field_first_name'=>'options[social]' )
) );

$level = '';
foreach ($this->level as $key => $value) {

    $sel = '';
    if( !empty($this->item) ){
        if( $value['id'] == $this->item['level_id'] ){
            $sel = ' selected="1"';
        }
    }
    $level .= '<option'.$sel.' value="'.$value['id'].'">'.$value['name'].'</option>';
}
$level = '<select class="inputtext" name="cus_level_id">'.$level.'</select>';

$form   ->field("cus_level_id")
        ->label('ระดับ')
        ->text( $level );

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

$rolesubmit = '';
if( isset( $_REQUEST['callback'] ) ){
    $arr['hiddenInput'][] = array('name'=>'callback','value'=>$_REQUEST['callback']);
    $rolesubmit = ' role="submit"';
}

$arr['button'] = '<button type="submit"'.$rolesubmit.' class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);