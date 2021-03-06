<?php

$title = 'Masseuse';

$options = array(
    'url' => URL.'media/set',
    'data' => array(
        'album_name'=>'my', 
        'minimize'=> array(128,128),
        'has_quad'=> true,
     ),
    'autosize' => true,
    'show'=>'quad_url',
    'remove' => true
);

if( !empty($this->item['id']) ){
    $options['setdata_url'] = URL.'employees/setdata/'.$this->item['id'].'/emp_image_id/?has_image_remove';
}

$image_url = '';
$hasfile = false;
if( !empty($this->item['image_url']) ){
    $hasfile = true;
    $image_url = '<img class="img" src="'.$this->item['image_url'].'?rand='.rand(100, 1).'">';

    $options['remove_url'] = URL.'media/del/'.$this->item['image_id'];
    
}

$picture_box = '<div class="anchor"><div class="clearfix">'.

        '<div class="ProfileImageComponent lfloat size80 radius mrm is-upload'.($hasfile ? ' has-file':' has-empty').'" data-plugins="uploadProfile" data-options="'.$this->fn->stringify( $options ).'">'.
            '<div class="ProfileImageComponent_image">'.$image_url.'</div>'.
            '<div class="ProfileImageComponent_overlay"><i class="icon-camera"></i></div>'.
            '<div class="ProfileImageComponent_empty"><i class="icon-camera"></i></div>'.
            '<div class="ProfileImageComponent_uploader"><div class="loader-spin-wrap"><div class="loader-spin"></div></div></div>'.
            '<button type="button" class="ProfileImageComponent_remove"><i class="icon-remove"></i></button>'.
        '</div>'.
    '</div>'.

'</div>';

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form   ->field("image")
        ->text( $picture_box );

$form   ->field("code")
        ->label( $this->lang->translate('Code') )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( $this->item['code'] );

$form   ->field("name")
        ->label('ชื่อ')
        ->text( $this->fn->q('form')->fullname( !empty($this->item)?$this->item:array(), array('field_first_name'=>'emp_', 'prefix_name'=>$this->prefixName) ) );

$position = '<option value="">-</option>';
foreach ($this->position as $key => $value) {
    $selected = '';
    if( !empty($this->item['pos_id']) ){
        if( $this->item['pos_id']==$value['id'] ){
            $selected = ' selected="1"';
        }
    }

    $position .= '<option'.$selected.' value="'.$value['id'].'">'.$value['name'].'</option>';
}
$position = '<select class="inputtext" name="emp_pos_id">'.$position.'</select>';
$form   ->field("emp_pos_id")
        ->label($this->lang->translate('Position'))
        ->text( $position );
        
$birthday = array();
if( !empty($this->item['birthday']) ){
    if( $this->item['birthday'] != '0000-00-00' ){
        $birthday = $this->item;
    }
}

$form   ->field("birthday")
        ->label('วันเกิด')
        ->text( $this->fn->q('form')->birthday( $birthday, array('field_first_name'=>'birthday') ) );


# set form
$arr['form'] = '<form class="js-submit-form" data-plugins="" method="post" action="'.URL. 'masseuse/update"></form>';

# body
$arr['body'] = $form->html();

# title
if( !empty($this->item) ){
    $arr['title']= "ข้อมูลพื้นฐาน";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
    $arr['hiddenInput'][] = array('name'=>'section','value'=>'basic');
}
else{
    $arr['title']= "New {$title}";
}

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">Save</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">Cancel</span></a>';

// $arr['width'] = 782;

echo json_encode($arr);