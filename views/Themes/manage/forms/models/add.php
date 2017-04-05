<?php

$title = 'Model';

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert');


// Dealer
if( count($this->dealer['lists'])==1 ){
    $arr['hiddenInput'][] = array('name'=>'model_dealer_id','value'=>$this->dealer['lists'][0]['id']);
}
else{

    $options = '';
    foreach ($this->dealer['lists'] as $key => $value) {
        
        $selected = '';
        if( !empty($this->item['dealer_id']) ){
            if( $this->item['dealer_id']==$value['id'] ){
                $selected = ' selected="1"';
            }
        }
        $options .= '<option'.$selected.' value="'.$value['id'].'">'.$value['name'].'</option>';
    }
    $select = '<select class="inputtext" name="model_dealer_id">'.$options.'</select>';
    $form   ->field("model_brand_id")
            ->label('Dealer')
            ->text( $select );
}


// brand
if( count($this->brand['lists'])==1 ){
    $arr['hiddenInput'][] = array('name'=>'model_brand_id','value'=>$this->brand['lists'][0]['id']);
}
else{

    $brand = '';
    foreach ($this->brand['lists'] as $key => $value) {
        
        $selected = '';
        if( !empty($this->item['brand_id']) ){
            if( $this->item['brand_id']==$value['id'] ){
                $selected = ' selected="1"';
            }
        }

        $brand .= '<option'.$selected.' value="'.$value['id'].'">'.$value['name'].'</option>';
    }
    $brand = '<select class="inputtext" name="model_brand_id">'.$brand.'</select>';
    $form   ->field("model_brand_id")
            ->label('Brand')
            ->text( $brand );  
}
$form   ->field("image")
        ->text('<div class="profile-cover image-cover" data-plugins="imageCover" data-options="'.(
        !empty($this->item['image_arr']) 
            ? $this->fn->stringify( array_merge( 
                array( 
                    'scaledX'=> 1180,
                    'scaledY'=> 640,
                    'action_url' => URL.'models/del_image_cover/'.$this->item['id'],
                    // 'top_url' => IMAGES_PRODUCTS
                ), $this->item['image_arr'] ) )
            : $this->fn->stringify( array( 
                    'scaledX'=> 1180,
                    'scaledY'=> 640
                ) )
            ).'"style="width: 329px;height: 201px; margin-left:43px;margin-top:0px">
        <div class="loader">
        <div class="progress-bar medium"><span class="bar blue" style="width:0"></span></div>
        </div>
        <div class="preview"></div>
        <div class="dropzone">
            <div class="dropzone-text">
                <div class="dropzone-icon"><i class="icon-picture-o img"></i></div>
                <div class="dropzone-title">เพิ่มรูปรถ</div>
            </div>
            <div class="media-upload"><input type="file" accept="image/*" name="image_cover"></div>
        </div>
        
</div>');


$form 	->field("model_name")
    	->label('Name*')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['name'])? $this->item['name']:'' );

$form   ->field("item_countries")
        ->label('เพิ่มสี')
        ->text('<div data-plugins="modelcolor" data-options="'.
        $this->fn->stringify( array( 
            'lists' => !empty($this->item['colors']) ? $this->item['colors']: array(),
        ) ).'"></div>');
   
# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'models/save"></form>';

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
 $arr['height'] = 500;
echo json_encode($arr);