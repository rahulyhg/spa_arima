<?php


if( !empty($this->item) ){
    $arr['title']= "แก้ไขแหล่งที่มา";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "เพิ่มแหล่งที่มา";
}


$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');


$form   ->field("refer_name")
        ->label('Name')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['name'])? $this->item['name']:'' );

$form 	->field("refer_note")
		->label('Note')
		->autocomplete('off')
		->addClass('inputtext')
		->type('textarea')
		->attr('data-plugins','autosize')
		->value( !empty($this->item['note'])? $this->item['note']:'' );


# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'booking/save_cus_refer"></form>';

# body
$arr['body'] = $form->html();

$arr['height'] = 'auto';
$arr['overflowY'] = 'auto';
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);