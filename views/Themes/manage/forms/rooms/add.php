<?php

$title = 'ห้อง';

$options = array(
    'url' => URL.'media/set',
    'data' => array(
        'album_name'=>'my', 
        'minimize'=> array(128,128),
        'has_quad'=> true,
     ),
    'autosize' => true,
    'show'=>'quad_url',
    'remove' => true
);

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert form-insert-room');

$form   ->field("room_floor")
        ->label('ชั้น')
        ->type('number')
        ->maxlength(2)
        ->autocomplete('off')
        ->addClass('inputtext');

$form   ->field("room_level")
        ->label('ประเภทห้อง')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->select( $this->level, 'id', 'name', false );

$form   ->field("room_number")
        ->label('ชื่อหรือหมายเลขห้อง')
        ->autocomplete('off')
        ->addClass('inputtext');

$a = array();
$a[] = array('id'=>'free', 'name'=>'Free');
$a[] = array('id'=>'time', 'name'=>'ต่อครั้ง');
$a[] = array('id'=>'person', 'name'=>'ตามจำนวนลูกค้า');

$form   ->field("room_price_type")
        ->label('อัตราการเข้าใช้บริกการ')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->select( $a, 'id', 'name', false );


$form   ->field("room_person")
        ->label('จำนวนลูกค้า')
        ->type('number')
        ->autocomplete('off')
        ->addClass('inputtext');

/*$array[] = array('id'=>'30','30 นาที');
$array[] = array('id'=>'60','');
$array[] = array('id'=>'90','');
$array[] = array('id'=>'90','');*/

$form   ->field("room_timer")
        ->label('/ เวลา(นาที)')
        ->type('number')
        ->autocomplete('off')
        ->addClass('inputtext');  

$form   ->field("room_price")
        ->label('ราคา')
        ->type('number')
        ->autocomplete('off')
        ->addClass('inputtext');

$form   ->field("room_bed")
        ->label('จำนวนเตียง')
        ->type('number')
        ->maxlength(2)
        ->autocomplete('off')
        ->addClass('inputtext');


# set form
$arr['form'] = '<form class="js-submit-form" data-plugins="addrooms" method="post" action="'.URL. 'rooms/save"></form>';

# body
$arr['body'] = $form->html();

# title
if( !empty($this->item) ){
    $arr['title']= "แก้ไข{$title}";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "เพิ่ม{$title}";
}

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">Save</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">Cancel</span></a>';

// $arr['width'] = 550;
$arr['height'] = 'auto';
$arr['overflowY'] = 'auto';

echo json_encode($arr);