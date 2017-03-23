<?php

$title = 'Dealer';

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
    ->style('horizontal')
	->addClass('form-insert');

$form   ->field("name")
        ->label('Name')
        ->addClass('inputtext')
        ->required(true)
        ->autocomplete("off")
        ->value( !empty($this->item['name']) ? $this->item['name']:'' );

$form   ->field("license")
        ->label('License No.')
        ->addClass('inputtext')
        ->autocomplete("off")
        ->value( !empty($this->item['license']) ? $this->item['license']:'');

$form   ->field("address")
        ->label('Address')
        ->type('textarea')
        ->addClass('inputtext')
        ->autocomplete("off")
        ->attr('data-plugins', 'autosize')
        ->value( !empty($this->item['address']) ? $this->item['address']:'');

$form   ->field("tel")
        ->label('Phone')
        ->addClass('inputtext')
        ->autocomplete("off")
        ->value( !empty($this->item['tel']) ? $this->item['tel']:'');

$form   ->field("mobile_phone")
        ->label('Mobile Phone')
        ->addClass('inputtext')
        ->autocomplete("off")
        ->value( !empty($this->item['mobile_phone']) ? $this->item['mobile_phone']:'');

$form   ->field("fax")
        ->label('Fax')
        ->addClass('inputtext')
        ->autocomplete("off")
        ->value( !empty($this->item['fax']) ? $this->item['fax']:'');

$form   ->field("email")
        ->label('Email')
        ->addClass('inputtext')
        ->autocomplete("off")
        ->value( !empty($this->item['email']) ? $this->item['email']:'');
        
# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'dealer/save"></form>';

# body
$arr['body'] = $form->html();

# title
if( !empty($this->item) ){
    $arr['title']= "Edit {$title}";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "New {$title}";
}

/*$arr['height'] = 'full';
$arr['overflowY'] = 'auto';*/
$arr['width'] = 550;

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">Save</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">Cancel</span></a>';

echo json_encode($arr);