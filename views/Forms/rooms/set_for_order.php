<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert form-set-room');

$form   ->field("room_floor")
        ->label($this->lang->translate('Floor'))
        ->autocomplete('off')
        ->addClass('inputtext')
        ->select( array() );

$form   ->field("room_name")
        ->label($this->lang->translate('Room Name'))
        ->autocomplete('off')
        ->addClass('inputtext')
        ->select( array() );

$form   ->field("room_number")
        ->label($this->lang->translate('Bed Name'))
        ->autocomplete('off')
        ->addClass('inputtext')
        ->select( array() );

# set form
// $arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'rooms/save"></form>';

# body
$arr['body'] = $form->html();

# title
$arr['title']= $this->lang->translate('Set Room');

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';


echo json_encode($arr);