<?php

$form = new Form();
$form = $form->create()
    // set From
    ->addClass('form-insert form-large');

$form   ->hr( '<div class="tac mbm fwb">จำนวนลูกค้า</div>' );

$form   ->field("cus_qty")
        ->autocomplete('off')
        ->type('number')
        ->attr('autofocus', 1)
        ->attr('autoselect', 1)
        ->addClass('inputtext tac')
        ->value( isset($_GET['value']) ? $_GET['value']: 1 );

$form   ->hr('<div class="mtm"><button type="submit" role="submit" class="btn btn-large btn-primary btn-submit" style="width:100%"><span class="btn-text">'.$this->lang->translate('Save').'</span></button></div>');

# set form
$arr['form'] = '<form></form>';

# body
$arr['body'] = $form->html();


// $arr['is_close_bg'] = 1;
$arr['width'] = 200;

echo json_encode($arr);