<?php

$title = 'Accessory';

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert');


$model = '';
foreach ($this->model['lists'] as $key => $value) {
	$selected = '';
	if( !empty($this->item['model_id']) ){
		if( $this->item['model_id'] == $value['id'] ){
			$selected = ' selected ="1"';
		}
	}

	$model.= '<option'.$selected.' value="'.$value['id'].'">'.$value['name'].'</option>';
}
$model = '<select class="inputtext" name="acc_model_id">'.$model.'</select>';
$form   ->field("acc_model_id")
        ->label('Model')
        ->text( $model );

$store = '<option value="">-</option>';
foreach ($this->store['lists'] as $key => $value) {
    
    $selected = '';
    if( !empty($this->item['store_id']) ){
        if( $this->item['store_id']==$value['id'] ){
            $selected = ' selected="1"';
        }
    }

    $store .= '<option'.$selected.' value="'.$value['id'].'">'.$value['name'].'</option>';
}
$store = '<select class="inputtext" name="acc_store_id">'.$store.'</select>';
$form   ->field("acc_store_id")
        ->label('Store')
        ->text( $store );

$form 	->field("acc_name")
    	->label('Name*')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['name'])? $this->item['name']:'' );

$form 	->field("acc_price")
    	->label('ราคาขาย*')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['price'])? round($this->item['price']):'' );

$form 	->field("acc_cost")
    	->label('ราคาเซล*')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['cost'])? round($this->item['cost']):'' );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'accessory/save"></form>';

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

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">Save</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">Cancel</span></a>';

// $arr['width'] = 782;

echo json_encode($arr);