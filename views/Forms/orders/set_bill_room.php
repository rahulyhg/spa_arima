<?php

$room = array();
$room[] = array('id'=>'', 'name'=> 'V. 3-1', 'price'=>'50');
$room[] = array('id'=>'', 'name'=> 'V. 3-2', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 3-3', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 3-4', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 3-5', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 3-6', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 3-7', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 3-8', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 3-9', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 3-10', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 3-11', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 3-12', 'price'=>'');
$li = '';
foreach ($room as $key => $value) {
    $li .= '<li><a class="btn btn-white btn-large js-choose" data-room="'.$value['name'].'" data-price="'.$value['price'].'">'.$value['name'].'</a></li>';
}
$ul = '';
$ul .= '<ul class="ui-list ui-list-choose-rooms" style="position:absolute;top:0;left:0;width:120px;bottom:0;overflow-y:auto;">'.$li.'</ul>';

$room = array();
$room[] = array('id'=>'', 'name'=> 'V. 5-1', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 5-2', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 5-3', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 5-4', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 5-5', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 5-6', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 5-7', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 5-8', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 5-9', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 5-10', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 5-11', 'price'=>'');
$li = '';
foreach ($room as $key => $value) {
    $li .= '<li><a class="btn btn-white btn-large js-choose" data-room="'.$value['name'].'" data-price="'.$value['price'].'">'.$value['name'].'</a></li>';
}
$ul .= '<ul class="ui-list ui-list-choose-rooms" style="position:absolute;top:0;left:120px;width:120px;bottom:0;overflow-y:auto;border-left: 1px solid #ddd;">'.$li.'</ul>';


$room = array();
$room[] = array('id'=>'', 'name'=> 'V. 6-1', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 6-2', 'price'=>'');
$room[] = array('id'=>'', 'name'=> 'V. 6-3', 'price'=>'');
$li = '';
foreach ($room as $key => $value) {
    $li .= '<li><a class="btn btn-white btn-large js-choose" data-room="'.$value['name'].'" data-price="'.$value['price'].'">'.$value['name'].'</a></li>';
}
$ul .= '<ul class="ui-list ui-list-choose-rooms" style="position:absolute;top:0;left:240px;width:120px;bottom:0;overflow-y:auto;border-left: 1px solid #ddd;">'.$li.'</ul>';


$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert form-set-room form-large');

$form   ->field("room_name")
        ->label( 'ห้อง' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->attr('data-name', 'room')
        ->attr('autofocus', 1)
        ->attr('autoselect', 1)
        ->value( isset($_GET['room_name']) ? $_GET['room_name']: '' );

$form   ->field("room_price")
        ->type('number')
        ->label( 'ราคา' )
        ->autocomplete('off')
        ->attr('data-name', 'price')
        ->addClass('inputtext')
        ->value( isset($_GET['room_price']) ? $_GET['room_price']: 0 );

# set form
$arr['form'] = '<form data-plugins="chooseRooms2"></form>';

# body
$arr['body'] = '<div style="position: relative;margin: -20px;height: 200px;">'.
    '<div style="position: absolute;right: 361px;left: 0;padding: 20px;">'.$form->html().'</div>'.

    '<div style="position: absolute;top: 0;background-color: #f2f2f2;right: 0;width: 361px;bottom: 0;border-left: 1px solid #ccc">'.$ul.'</div>'.
'</div>';

# title
$arr['title']= 'กำหนดห้อง';

# fotter: button
$arr['button'] = '<button class="btn" type="button" role="cancel"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></button>';
$arr['button'] .= '<button type="submit" role="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';

$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ปิด</span></a>';

$arr['width'] = 550;

echo json_encode($arr);