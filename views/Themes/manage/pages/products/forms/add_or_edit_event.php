<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form   ->field("event_name")
        ->label('ชื่องาน')
        ->addClass('inputtext')
        ->autocomplete('off')
        ->placeholder('')
        ->value( !empty($this->item['name']) ? $this->item['name']:'' );

$form   ->field("event_address")
        ->label('สถานที่จัดงาน')
        ->type('textarea')
        ->attr('data-plugins', 'autosize')
        ->addClass('inputtext')
        ->autocomplete('off')
        ->placeholder('')
        ->value( !empty($this->item['address']) ? $this->item['address']:'' );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'products/save_event"></form>';

# body
$arr['body'] = $form->html();

if( !empty($this->item) ){
    $arr['title']= "Edit Event";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "New Event";
}

$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);