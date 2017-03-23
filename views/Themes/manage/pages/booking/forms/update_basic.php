<?php

$arr['title']= "แก้ไขข้อมูลการจอง";
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
$arr['hiddenInput'][] = array('name'=>'type','value'=>'basic');

$deposit_type = 'cash';

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form   ->field("book_date")
        ->name('book[date]')
        ->label('วันที่จอง')
        ->type('date')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['date'])? $this->item['date']:'' );

$form   ->field("book_page")
        ->name('book[page]')
        ->label('เล่มที่')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['page'])? $this->item['page']:'' );

$form   ->field("book_number")
        ->name('book[number]')
        ->label('เลขที่')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['number'])? $this->item['number']:'' );


if( count($this->dealer)==1 ){

$form   ->field("book_dealer_id")
        ->label('บริษัท/Dealer Name')
        ->text( '<select id="book_dealer_id" disabled="1" class="inputtext disabled js-data" name="book[dealer_id]"><option value="'.$this->dealer[0]['id'].'">'.$this->dealer[0]['name'].'</option></select><input type="hidden" autocomplete="off" name="book[dealer_id]" value="'.$this->dealer[0]['id'].'">' );
}
else{

$form   ->field("book_car")
        ->name('book[dealer_id]')
        ->autocomplete('off')
        ->label('บริษัท/Dealer Name')
        ->addClass('inputtext js-data')
        ->select( $this->dealer )
        ->value( !empty($this->item['cus']['refer']) ? $this->item['cus']['refer']:'' );
}

$form   ->field("book_cus_refer")
        ->name('book[cus_refer]')
        ->label('แหล่งที่มา')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->select( $this->cus_refer )
        ->value( !empty($this->item['cus']['refer']) ? $this->item['cus']['refer']:'' );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'booking/update"></form>';


# body
$arr['body'] = $form->html();

// $arr['width'] = 720;
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);