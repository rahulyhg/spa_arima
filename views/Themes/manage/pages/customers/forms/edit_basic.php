<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

// name
$form   ->field("name")
        ->label('ชื่อ')
        ->text( $this->fn->q('form')->fullname( !empty($this->item)?$this->item:array(), array('field_first_name'=>'cus_', 'prefix_name'=>$this->prefixName) ) );

// birthday
// $form   ->field("birthday")
//         ->label('วันเกิด')
//         ->text( $this->fn->q('form')->birthday( !empty($this->item)?$this->item:array(), array('field_first_name'=>'cus_') ) );

$form   ->field("cus_card_id")
        ->label('หมายเลขบัตรประจำตัวประชาชน')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['card_id'])? $this->item['card_id']:'' );

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
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'customers/update_basic"></form>';

# body
$arr['body'] = $form->html();

if( !empty($this->item) ){
    $arr['title']= "แก้ไขข้อมูลพื้นฐาน";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "New Customres";
}

$arr['height'] = 'auto';
$arr['overflowY'] = 'auto';
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);