<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form   ->field("vin")
        ->label('เลขตัวถัง (VIN)')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['vin'])? $this->item['vin']:'' );

$form   ->field("engine")
        ->label('เลขเครื่องยนต์')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['engine'])? $this->item['engine']:'' );

$color = '';
foreach ($this->color as $key => $value) {
    $selected = '';
    if( $value['id'] == $this->item['color'] ){
        $selected = ' selected="1"';
    }

    $color .= '<option'.$selected.' value="'.$value['id'].'">'.$value['name'].'</option>';
}

$form   ->field("color")
        ->label('สี')
        ->text( '<select class="inputtext" name="color">'.$color.'</select>' );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'products/update_item"></form>';

# body
$arr['body'] = $form->html();

if( !empty($this->item) ){
    $arr['title']= "Edit Car";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
    $arr['hiddenInput'][] = array('name'=>'pro_id','value'=>$this->item['pro_id']);
}
else{
    $arr['title']= "New car";
}

$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);