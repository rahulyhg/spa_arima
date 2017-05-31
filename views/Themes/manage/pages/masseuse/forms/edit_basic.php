<?php

$title = 'Masseuse';

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form   ->field("code")
        ->label( $this->lang->translate('Code') )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( $this->item['code'] );

$form   ->field("name")
        ->label('ชื่อ')
        ->text( $this->fn->q('form')->fullname( !empty($this->item)?$this->item:array(), array('field_first_name'=>'emp_', 'prefix_name'=>$this->prefixName) ) );
        
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