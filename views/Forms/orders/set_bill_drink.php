<?php

$form = new Form();
$form = $form->create()
    // set From
    ->addClass('form-insert form-large');

$form   ->hr( '<h2 class="tac mbm">'.$this->lang->translate('DRINK').'</h2>' );

$form   ->field("drink")
        ->autocomplete('off')
        ->type('number')
        ->attr('autoselect', 1)
        ->addClass('inputtext tac')
        ->value( isset($_GET['drink']) ? $_GET['drink']: 0 );

$form   ->hr('<div class="mtm"><button type="submit" role="submit" class="btn btn-large btn-primary btn-submit" style="width:100%"><span class="btn-text">'.$this->lang->translate('Save').'</span></button></div>');

# set form
$arr['form'] = '<form></form>';

# body
$arr['body'] = $form->html();

# title
// $arr['title']= '<div>'$this->lang->translate('DRINK');

# fotter: button
// $arr['button'] = '<button type="submit" role="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
// $arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';

$arr['is_close_bg'] = 1;
$arr['width'] = 200;

echo json_encode($arr);