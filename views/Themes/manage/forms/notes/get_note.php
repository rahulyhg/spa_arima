<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form   ->field("note_text")
        // ->label('หมายเลขบัตรประจำตัวประชาชน')
        ->type('textarea')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->attr('data-plugins', 'autosize')
        ->placeholder('')
        ->value( !empty($this->item['text'])? $this->item['text']:'' );
# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'notes/edit_note"></form>';

# body
$arr['body'] = $form->html();


$arr['title']= "แก้ไขโน๊ต";
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);


$arr['button'] = isset($_REQUEST['callback'])
    ? '<button type="submit" role="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>'
    : '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';

$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);