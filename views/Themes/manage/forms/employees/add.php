<?php

$title = 'พนักงาน';

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
	->addClass('form-insert form-emp');

$form   ->field("image")
        ->text( $picture_box );

// Dealer
if( count($this->dealer['lists'])==1 ){
    $arr['hiddenInput'][] = array('name'=>'emp_dealer_id','value'=>$this->dealer['lists'][0]['id']);
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
    $select = '<select class="inputtext" name="emp_dealer_id">'.$options.'</select>';
    $form   ->field("emp_dealer_id")
            ->label('Dealer')
            ->text( $select );
}

$form   ->field("emp_username")
        ->label('Username*')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value( !empty($this->item['username'])? $this->item['username']:'' );
        
if( empty($this->item) ){

$form   ->field("emp_password")
        ->label('Password*')
        ->type('password')
        ->maxlength(30)
        ->autocomplete('off')
        ->addClass('inputtext');
}


$form   ->field("name")
        ->label('ชื่อ')
        ->text( $this->fn->q('form')->fullname( !empty($this->item)?$this->item:array(), array('field_first_name'=>'emp_', 'prefix_name'=>$this->prefixName) ) );


$department = '<option value="">-</option>';
foreach ($this->department as $key => $value) {
    
    $selected = '';
    if( !empty($this->item['dep_id']) ){
        if( $this->item['dep_id']==$value['id'] ){
            $selected = ' selected="1"';
        }
    }

    $department .= '<option'.$selected.' value="'.$value['id'].'">'.$value['name'].'</option>';
}


$department = '<select class="inputtext" name="emp_dep_id">'.$department.'</select>';
$form   ->field("emp_dep_id")
        ->label('Department')
        ->text( $department );

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
        ->label('Position')
        ->text( $position );


$form   ->field("cus_address")
        ->name('cus[address]')
        ->label('ที่อยู่')
        ->text( $this->fn->q('form')->address( !empty($this->item['address'])? $this->item['address']:array(), array('city'=>$this->city ) ) );


$form   ->field("birthday")
        ->label('วันเกิด')
        ->text( $this->fn->q('form')->birthday( !empty($this->item)?$this->item:array(), array('field_first_name'=>'emp_') ) );

$form   ->field("emp_phone_number")
        ->label('Phone number*')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['phone_number'])? $this->item['phone_number']:'' );

$form   ->field("emp_email")
        ->label('Email')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['email'])? $this->item['email']:'' );

$form   ->field("emp_line_id")
        ->label('Line ID')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['line_id'])? $this->item['line_id']:'' );

$form   ->field("emp_notes")
        ->label('Note')
        ->type('textarea')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->attr('data-plugins', 'autosize')
        ->placeholder('')
        ->value( !empty($this->item['notes'])? $this->fn->q('text')->textarea($this->item['notes']):'' );

# set form
$arr['form'] = '<form class="js-submit-form" data-plugins="empposition" method="post" action="'.URL. 'employees/save"></form>';

# body
$arr['body'] = $form->html();

# title
if( !empty($this->item) ){
    $arr['title']= "แก้ไข{$title}";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "เพิ่ม{$title}";
}

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">Save</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">Cancel</span></a>';

$arr['width'] = 550;

echo json_encode($arr);