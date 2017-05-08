<?php

$title = $this->lang->translate('Package');

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert form-package');

$form   ->field("pack_code")
        ->label($this->lang->translate('Code'))
        ->addClass('inputtext')
        ->autocomplete("off")
        ->value( !empty($this->item['code']) ? $this->item['code']:'' );

$form   ->field("pack_name")
        ->label($this->lang->translate('Name'))
        ->addClass('inputtext')
        ->required(true)
        ->autocomplete("off")
        ->value( !empty($this->item['name']) ? $this->item['name']:'' );

$form   ->field("pack_qty")
        ->label( $this->lang->translate('Quantity') )
        ->addClass('inputtext')
        ->autocomplete("off")
        ->type('number')
        ->value( !empty($this->item['qty']) ? $this->item['qty']:'' );

$form   ->field("pack_unit")
        ->label( 'Unit' )
        ->addClass('inputtext')
        ->autocomplete("off")
        ->select( $this->unit, 'id', 'name', false )
        ->value( !empty($this->item['unit']) ? $this->item['unit']:'' );

$form   ->field("pack_price")
        ->label($this->lang->translate('Price'))
        ->addClass('inputtext')
        ->autocomplete("off")
        ->type('number')
        ->value( !empty($this->item['price']) ? round($this->item['price']):'' );

$skill = '';
foreach ($this->skill as $key => $value) {

    $ck = '';
    if( !empty($this->item['skill']) ){
        foreach ($this->item['skill'] as $val) {

            if( $val['id'] == $value['id'] ){
                $ck = ' checked="1"';
                break;
            }
        }
    }

    $skill .= '<label class="checkbox mrl"><input'.$ck.' type="checkbox" name="skill[]" value="'.$value['id'].'"><span class="fwb">'.$value['name'].'</span></label>';
}

$form   ->field("pack_skill")
        ->label($this->lang->translate('Skill'))
        ->text( $skill );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'package/save"></form>';

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

// $arr['height'] = 'full';
// $arr['overflowY'] = 'auto';
// $arr['width'] = 550;

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';

echo json_encode($arr);