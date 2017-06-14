<?php

$form = new Form();
$form = $form->create()
    // set From
    ->addClass('form-insert');

$number[] = array('id'=>'1', 'name'=>'V 3-1');
$number[] = array('id'=>'2', 'name'=>'V 3-2');
$number[] = array('id'=>'3', 'name'=>'V 3-3');
$number[] = array('id'=>'4', 'name'=>'V 3-4');
$number[] = array('id'=>'5', 'name'=>'V 3-5');
$number[] = array('id'=>'6', 'name'=>'V 3-6');
$number[] = array('id'=>'7', 'name'=>'V 3-7');
$number[] = array('id'=>'8', 'name'=>'V 3-8');
$number[] = array('id'=>'9', 'name'=>'V 3-9');
$number[] = array('id'=>'10', 'name'=>'V 3-10');
$number[] = array('id'=>'11', 'name'=>'V 3-11');
$number[] = array('id'=>'12', 'name'=>'V 3-12');

$form   ->field("room_number")
        ->label('Number')
        ->autocomplete('off')
        ->select( $number )
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