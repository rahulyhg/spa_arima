<?php

$arr['title']= "แก้ไขข้อมูล รถยนต์";
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
$arr['hiddenInput'][] = array('name'=>'type','value'=>'car');


$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form   ->field("book_model_id")
		->name('book[model_id]')
        ->label('Model')
        ->attr('data-name', 'model')
        ->addClass('inputtext')
        ->select( $this->models, 'id', 'name', false )
        ->value( !empty($this->item['model']['id'])? $this->item['model']['id']:'' );

$form   ->field("book_pro_id")
		->name('book[pro_id]')
        ->label('Model')
        ->attr('data-name', 'product')
        ->addClass('inputtext')
        ->select( array() );

$form   ->hr('<div class="clearfix"></div>');

$form   ->field("book_color")
		->name('book[color]')
        ->label('สีรถ')
        ->attr('data-name', 'model_color')
        ->addClass('inputtext')
        ->select( array()  );

// $form   ->hr('<div class="clearfix"></div>');

$form   ->field("book_pro_price")
		->name('book[pro_price]')
		->type('number')
		->attr('data-name', 'product_price')
        ->label('ราคารถยนต์(ราคาปัจจุบัน '. ( !empty($this->item['pro']['price']) ? number_format($this->item['pro']['price']):'' ) .')')
        ->autocomplete('off')
        ->addClass('inputtext w-auto')
        ->placeholder('')
        ->value( !empty($this->item['pro']['price'])? $this->item['pro']['price']:'' );


# set form
$arr['form'] = '<form class="js-submit-form form-booking" data-plugins="selectors_stocks" data-options="'.$this->fn->stringify( array(

		'model' => !empty($this->item['model']['id'])? $this->item['model']['id']:'',
		'product' => !empty($this->item['pro']['id'])? $this->item['pro']['id']:'',
		'color' => !empty($this->item['color']['id'])? $this->item['color']['id']:'',

	) ).'" method="post" action="'.URL. 'booking/update"></form>';



# body
$arr['body'] = $form->html();

$arr['width'] = 520;
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);