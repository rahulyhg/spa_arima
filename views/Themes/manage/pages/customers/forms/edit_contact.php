<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

// address
$form   ->field("cus_address")
        ->name('cus[address]')
        ->label('ที่อยู่*')
        ->text( $this->fn->q('form')->address( !empty($this->item['address'])? $this->item['address']:array(), array('city' => $this->city ) ) );

// email
$form->hr( $this->fn->q('form')->contacts( 
    'email',
    !empty($this->item['options']['email'])? $this->item['options']['email']:array(), 
    array( 'field_first_name'=>'options[email]' )
) );

// email
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

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'customers/update_contact"></form>';

# body
$arr['body'] = $form->html();

if( !empty($this->item) ){
    $arr['title']= "แก้ไขข้อมูลการติดต่อ";
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