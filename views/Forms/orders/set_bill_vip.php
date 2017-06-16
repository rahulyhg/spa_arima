<?php

$form = new Form();
$form = $form->create()
    // set From
    ->addClass('form-insert');

$form   ->field("room_number")
        ->label('Number')
        ->autocomplete('off')
        ->select( $this->number )
        ->addClass('inputtext')
        ->value( isset($_GET['room_number']) ? $_GET['room_number']: 0 );

$form   ->field("room_price")
        ->label("Price")
        ->autocomplete('off')
        ->type('number')
        ->addClass('inputtext')
        ->value( isset($_GET['room_price']) ? $_GET['room_price']: 0 );

# set form
$arr['form'] = '<form></form>';

# body
$arr['body'] = $form->html();

# title
$arr['title']= "กำหนดห้อง";

# fotter: button
$arr['button'] = '<button type="submit" role="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';

$arr['is_close_bg'] = 1;
$arr['width'] = 350;

echo json_encode($arr);