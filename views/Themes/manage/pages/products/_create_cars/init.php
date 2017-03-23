<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('insert');

if( count($this->brands)==1 ){
    $arr['hiddenInput'][] = array('name'=>'car[brand_id]','value'=>$this->brands[0]['id']);
}
else{

    $brands = '<option>-</option>';
    foreach ($this->brands as $key => $value) {
        $brands .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
    }

$form   ->field("car_brand_id")
        ->label('Brand')
        ->text( '<select class="inputtext" id="car_brand_id" name="car[brand_id]">'.$brands.'</select>' );
}

$model = '';
foreach ($this->models as $key => $value) {

    if( !empty($this->item['model_id']) ){
        if( $this->item['model_id']==$value['id'] ){
            //$sel = ' selected="1"';
            $model = $value['name'];
        }
    }
}

$form   ->field("car_model_id")
		->name('car[model_id]')
        ->label('Model')
        ->text( '<input class="inputtext js-model-input" data-model="'.$this->item['model_id'].'" id="car_model_id" type="text" disabled="1" value="'.$model.'">');

$form   ->field("car_name")
		->name('car[name]')
        ->label('ชื่อ')
        ->text( '<input class="inputtext" type="text" disabled="1" value="'.$this->item['name'].'">' );

$form   ->field("cost")
        ->name('activity[cost]')
        ->label('ราคาทุน (บาท)')
        ->text( '<input class="inputtext" type="text" disabled="1" value="'.number_format($this->item['act_cost']).'">' );

$form   ->field("car_price")
		->name('car[price]')
        ->label('ราคาขาย (บาท)')
        ->text( '<input class="inputtext" type="text" disabled="1" value="'.number_format($this->item['price']).'">' );

$form   ->field("car_cc")
		->name('car[cc]')
        ->label('ขนาดเครื่องยนต์')
        ->text( '<input class="inputtext" type="text" disabled="1" value="'.$this->item['cc'].'">' );

$form   ->field("car_mfy")
        ->name('car[mfy]')
        ->label('ปีที่ผลิต')
        ->text( '<input class="inputtext" type="text" disabled="1" value="'.$this->item['mfy'].'">' );

$form   ->field("qty")
        ->name('activity[qty]')
        ->label('จำนวน')
        ->type('number')
        ->autocomplete('off')
        ->addClass('inputtext js-count-value')
        ->placeholder('')
        ->value( 0 );

if( !empty($this->item['id']) ){
    $form   ->field('id')
            ->text('<input type="hidden" name="id" value="'.$this->item['id'].'">');
}


// $form   ->hr('<div class="pam uiBoxYellow">การเพิ่มข้อมูลสินค้าใหม่จำเป็นต้องใส่ข้อมูลที่ถูงต้อง</div>');