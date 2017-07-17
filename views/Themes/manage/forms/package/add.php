<?php

$title = $this->lang->translate('Package');

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert form-package');

$form   ->field("image")
        ->text('<div class="profile-cover image-cover" data-plugins="imageCover" data-options="'.(
        !empty($this->item['image_arr']) 
            ? $this->fn->stringify( array_merge( 
                array( 
                    'scaledX'=> 640,
                    'scaledY'=> 360,
                    'action_url' => URL.'package/del_image_cover/'.$this->item['id'],
                    // 'top_url' => IMAGES_PRODUCTS
                ), $this->item['image_arr'] ) )
            : $this->fn->stringify( array( 
                    'scaledX'=> 640,
                    'scaledY'=> 360
                ) )
            ).'">
        <div class="loader">
        <div class="progress-bar medium"><span class="bar blue" style="width:0"></span></div>
        </div>
        <div class="preview"></div>
        <div class="dropzone">
            <div class="dropzone-text">
                <div class="dropzone-icon"><i class="icon-picture-o img"></i></div>
                <div class="dropzone-title">เพิ่มรูป</div>
            </div>
            <div class="media-upload"><input type="file" accept="image/*" name="pack_image"></div>
        </div>
        
</div>');


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

    $skill .= '<label class="checkbox mrl"><input'.$ck.' type="checkbox" name="skill[]" value="'.$value['id'].'"><span>'.$value['name'].'</span></label>';
}

$form   ->field("pack_skill")
        // ->label($this->lang->translate('Skill'))
        ->text( '<div class="openset">'.

            '<label class="checkbox"><input'.$ck.' type="checkbox" name="has_masseuse" value="1" class="js-openset"'.( !empty($this->item['has_masseuse']) ? ' checked':'' ).'><span class="fwb">มีการใช้ พนง.ผู้บริการ(หมอ) หรือไหม?</span></label>'.

            '<div class="content" data-name="has_masseuse">' .$skill. '</div>'. 

        '</div>' );
        // ->note('');

# set form
$arr['form'] = '<form class="js-submit-form" data-plugins="activeform" method="post" action="'.URL. 'package/save"></form>';

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