<?php

$title = 'พนักงาน';

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
    ->style('horizontal')
	->addClass('form-insert');

// $form   ->field("image")
//         ->text('<div class="profile-cover image-cover" data-plugins="imageCover" data-options="'.(
//         !empty($this->item['image_arr']) 
//             ? $this->fn->stringify( array_merge( 
//                 array( 
//                     'scaledX'=> 250,
//                     'scaledY'=> 250,
//                     'action_url' => URL.'employees/del_image_profile/'.$this->item['id'],
//                     // 'top_url' => IMAGES_PRODUCTS
//                 ), $this->item['image_arr'] ) )
//             : $this->fn->stringify( array( 
//                     'scaledX'=> 250,
//                     'scaledY'=> 250
//                 ) )
//             ).'" style="margin-top: 0px; margin-left: -23%;">
//         <div class="loader">
//         <div class="progress-bar medium"><span class="bar blue" style="width:0"></span></div>
//         </div>
//         <div class="preview"></div>
//         <div class="dropzone">
//             <div class="dropzone-text">
//                 <div class="dropzone-icon"><i class="icon-picture-o img"></i></div>
//                 <div class="dropzone-title">เพิ่มรูปโฆษณา</div>
//             </div>
//             <div class="media-upload"><input type="file" accept="image/*" name="image"></div>
//         </div>
        
// </div>');

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

$arr['width'] = 625;

echo json_encode($arr);