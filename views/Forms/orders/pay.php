<?php

$form = new Form();
$form = $form->create()
    // set From
	->elem('div')
    ->addClass('form-insert');

$form   ->field("total")
        ->autocomplete('off')
        ->label('ยอดรวม')
        ->text(  number_format($this->item['total'], 0) );

$form   ->field("discount")
        ->autocomplete('off')
        ->label('ส่วนลด')
        ->text( '-'. number_format($this->item['discount'], 0) );

$form   ->field("balance")
        ->autocomplete('off')
        ->label('รวมทั้งหมดที่ต้องจ่าย')
        ->text(  number_format($this->item['balance'], 0) );

$form   ->field("pay")
        ->autocomplete('off')
        ->type('number')
        ->attr('autofocus', 1)
        ->addClass('inputtext')
        ->label('จำนวนเงินที่จ่าย')
        ->value( !empty($this->item['pay']) ? round($this->item['pay'],0): 0);


# set form
$arr['form'] = '<form action="'.URL. 'orders/pay"></form>';

$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);

# body
$arr['body'] = $form->html();

# title
$arr['title']= 'ชำระเงิน';

# fotter: button
$arr['button'] = '<button type="submit" role="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';


echo json_encode($arr);