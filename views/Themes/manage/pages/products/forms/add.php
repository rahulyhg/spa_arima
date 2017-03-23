<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

if( count($this->brands)==1 ){
    $arr['hiddenInput'][] = array('name'=>'car_brand_id','value'=>$this->brands[0]['id']);
}
else{

    $brands = '<option>-</option>';
    foreach ($this->brands as $key => $value) {
        $brands .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
    }

$form   ->field("car_brand_id")
        ->label('Brand')
        ->text( '<select class="inputtext" name="car_brand_id">'.$brands.'</select>' );
}

$model = '<option>-</option>';
foreach ($this->models as $key => $value) {
    $model .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
}
$form   ->field("car_model_id")
        ->label('Model')
        ->text( '<select class="inputtext" name="car_brand_id">'.$model.'</select>' );

$form   ->field("car_name")
        ->label('ชื่อ')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['nickname'])? $this->item['nickname']:'' );

$form   ->field("car_cost")
        ->label('ราคาทุน')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['nickname'])? $this->item['nickname']:'' );

$form   ->field("car_price")
        ->label('ราคาขาย')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['nickname'])? $this->item['nickname']:'' );

$form   ->field("count")
        ->label('จำนวน')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['nickname'])? $this->item['nickname']:'' );


# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'customers/save"></form>';

# body
$arr['body'] = $form->html();

if( !empty($this->item) ){
    $arr['title']= "Edit Car";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "New car";
}

$arr['height'] = 'auto';
$arr['overflowY'] = 'auto';
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);