<?php

if( !empty($this->item) ){
    $arr['title']= "Edit Status";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);


    $status_color_value = ' value="'. $this->item['color'] .'"';

    $status_lock_checked = !empty($this->item['is_lock']) ?' checked="1"' :'';
    $status_enable_checked = !empty($this->item['enable']) ?' checked="1"' :'';
}
else{
    $arr['title']= "New Status";
}


$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form   ->field("status_label")
        ->label('Name')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['name'])? $this->item['name']:'' );


$form   ->field("status_options")
        ->text( 

            '<input autocomplete="off" class="inputtext mrl" style="width: 80px;display: inline-block;" type="text" name="status_color" placeholder="Color" data-plugins="colorpicker"'.( isset($status_color_value)?$status_color_value:'' ).'>'.

            '<label class="checkbox mrl"><input type="checkbox" name="status_lock"'.( isset($status_lock_checked)?$status_lock_checked:'' ).'><span class="fwb">Lock</span></label>'.

            '<label class="checkbox"><input type="checkbox" name="status_enable"'.( isset($status_enable_checked)?$status_enable_checked:'' ).'><span class="fwb">Enable</span></label>' );


# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'booking/save_status"></form>';

# body
$arr['body'] = $form->html();

$arr['height'] = 'auto';
$arr['overflowY'] = 'auto';
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);