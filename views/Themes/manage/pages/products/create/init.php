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

$form   ->field("pro_brand_id")
        ->label('Brand')
        ->text( '<select class="inputtext" id="pro_brand_id" name="car[brand_id]">'.$brands.'</select>' );
}

$form   ->field("pro_model_id")
        ->name('car[model_id]')
        ->label('Model')
        ->addClass('inputtext js-model')
        ->select( $this->models )
        ->value( !empty($_GET['model_id']) ? $_GET['model_id']:'' );

$form   ->field("pro_name")
		->name('car[name]')
        ->label('ชื่อ')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['name'])? $this->item['name']:'' );

$form   ->field("cost")
        ->name('activity[cost]')
        ->label('ราคาทุน (บาท)')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['act_cost']) ? round($this->item['act_cost']):'' );

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

$form   ->field("qty")
        ->name('activity[qty]')
        ->label('จำนวน')
        ->type('number')
        ->autocomplete('off')
        ->addClass('inputtext js-count-value')
        ->placeholder('')
        ->value( !empty($this->item['act_qty'])? $this->item['act_qty']:0 );

if( !empty($this->item['id']) ){
    $form   ->field('id')
            ->text('<input type="hidden" name="id" value="'.$this->item['id'].'">');
}

// $form   ->hr('<div class="pam uiBoxYellow">การเพิ่มข้อมูลสินค้าใหม่จำเป็นต้องใส่ข้อมูลที่ถูงต้อง</div>');