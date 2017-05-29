<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert form-set-room');

$form   ->field("price")
        ->label($this->lang->translate('Price'))
        ->autocomplete('off')
        ->addClass('inputtext disabled')
        ->attr('disabled', 1)
        ->type('number')
        ->value( isset($_GET['price'])? $_GET['price']:0  );

$form   ->field("discount")
        ->label($this->lang->translate('Discount'))
        ->autocomplete('off')
        ->addClass('inputtext')
        ->type('number')
        ->value( isset($_GET['discount'])? $_GET['discount']:0 );

$form   ->field("total")
        ->label($this->lang->translate('Total'))
        ->autocomplete('off')
        ->addClass('inputtext disabled')
        ->type('number')
        ->attr('disabled', 1)
        ->value( isset($_GET['total'])? $_GET['total']:0 );

# set form
$arr['form'] = '<form data-plugins="inputDiscount">';

# body
$arr['body'] = $form->html();


$arr['width'] = 300;

# title
$arr['title']= $this->lang->translate('Set Price');

# fotter: button
$arr['button'] = '<button type="submit" role="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';


echo json_encode($arr);