<?php

$title = $this->lang->translate('Room');

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
        ->label($this->lang->translate('floor'))
        ->type('number')
        ->maxlength(2)
        ->autocomplete('off')
        ->addClass('inputtext');

$form   ->field("room_level")
        ->label($this->lang->translate('Type'))
        ->autocomplete('off')
        ->addClass('inputtext')
        ->select( $this->level, 'id', 'name', false );

$form   ->field("room_number")
        ->label($this->lang->translate('Number'))
        ->autocomplete('off')
        ->addClass('inputtext');

$a = array();
$a[] = array('id'=>'free', 'name'=>$this->lang->translate('Free'));
$a[] = array('id'=>'time', 'name'=>$this->lang->translate('Per Time'));
$a[] = array('id'=>'person', 'name'=>$this->lang->translate('Per Customer'));

$form   ->field("room_price_type")
        ->label($this->lang->translate('Price rate'))
        ->autocomplete('off')
        ->addClass('inputtext')
        ->select( $a, 'id', 'name', false );


$form   ->field("room_person")
        ->label($this->lang->translate('Number of').' '.$this->lang->translate('Person'))
        ->type('number')
        ->autocomplete('off')
        ->addClass('inputtext');

/*$array[] = array('id'=>'30','30 นาที');
$array[] = array('id'=>'60','');
$array[] = array('id'=>'90','');
$array[] = array('id'=>'90','');*/

$form   ->field("room_timer")
        ->label($this->lang->translate('time').'/('.$this->lang->translate('minute').')')
        ->type('number')
        ->autocomplete('off')
        ->addClass('inputtext');  

$form   ->field("room_price")
        ->label($this->lang->translate('Number of').' '.$this->lang->translate('Price'))
        ->type('number')
        ->autocomplete('off')
        ->addClass('inputtext');

$form   ->field("room_bed")
        ->label($this->lang->translate('Number of').' '.$this->lang->translate('Bed'))
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
    $arr['title']= "{$title}";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "{$title}";
}

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';

// $arr['width'] = 550;
$arr['height'] = 'auto';
$arr['overflowY'] = 'auto';

echo json_encode($arr);