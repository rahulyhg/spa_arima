<?php

# title
$arr['title']= $this->lang->translate('Note');

# set form
$form = new Form();
$form = $form->create()
    // set From
    ->addClass('form-insert');

$form   ->field("note")
        ->autocomplete('off')
        ->type('textarea')
        ->attr('autofocus', 1)
        ->addClass('inputtext')
        ->value( isset($_GET['note']) ? $_GET['note']: '' );
        

# set content
$arr['form'] = '<form>';

# body
$arr['body'] = $form->html();

# fotter: button
$arr['button'] = '<button type="submit" role="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';

$arr['is_close_bg'] = 1;
echo json_encode($arr);