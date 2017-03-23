<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

// if( count($this->brands)==1 ){
//     $arr['hiddenInput'][] = array('name'=>'car[brand_id]','value'=>$this->brands[0]['id']);
// }
// else{

//     $brands = '<option>-</option>';
//     foreach ($this->brands as $key => $value) {
//         $brands .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
//     }

// $form   ->field("car_brand_id")
//         ->label('Brand')
//         ->text( '<select class="inputtext" id="car_brand_id" name="car[brand_id]">'.$brands.'</select>' );
// }

$model = '<option value="">-</option>';

foreach ($this->models as $key => $value) {
    $sel = '';

    if( !empty($this->item['model_id']) ){
        if( $this->item['model_id']==$value['id'] ){
            $sel = ' selected="1"';
        }
    }

    $model .= '<option'.$sel.' value="'.$value['id'].'">'.$value['name'].'</option>';
}
$form   ->field("pro_model_id")
		->name('car[model_id]')
        ->label('Model')
        ->text( '<select class="inputtext js-model" id="pro_model_id" name="car[model_id]">'.$model.'</select>' );

$form   ->field("pro_name")
		->name('car[name]')
        ->label('ชื่อ')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['name'])? $this->item['name']:'' );

$form   ->field("cost")
        ->name('activity[cost]')
        ->label('ราคาทุน (บาท) (ราคาเดิม '.$this->activity['cost'].')')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->activity['cost']) ? round($this->activity['cost']):'' );

$form   ->field("pro_price")
		->name('car[price]')
        ->label('ราคาขาย (บาท)')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['price'])? round($this->item['price']):'' );

$form   ->field("pro_cc")
		->name('car[cc]')
        ->label('ขนาดเครื่องยนต์')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['cc'])? $this->item['cc']:'' );

$form   ->field("pro_mfy")
        ->name('car[mfy]')
        ->label('ปีที่ผลิต')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['mfy'])? $this->item['mfy']:'' );


# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'products/save"></form>';

# body
$arr['body'] = $form->html();

if( !empty($this->item) ){
    $arr['title']= "Edit Car";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
    $arr['hiddenInput'][] = array('name'=>'act_id', 'value'=>$this->activity['id']);
}
else{
    $arr['title']= "New car";
}

$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);