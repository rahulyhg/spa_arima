<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$name = '';
$a[] = array( 
    'id' => 'pro_name', 
    'label' => 'ชื่อรถยนต์',
    'type' => 'select',
    'options' => $this->prefixName,
    'value' => $this->item['pro_name']
);

$a[] = array( 
    'id' => 'cus_first_name', 
    'label' => 'ชื่อ',
    'value' => $this->item['cus_first_name']
);

$a[] = array( 
    'id' => 'cus_last_name', 
    'label' => 'นามสกุล',
    'value' => $this->item['last_name']
);

/* set name*/
foreach ($a as $value) {

    $type = isset($value['type']) ? $value['type'] : 'text';
    if($type=='select'){
        
        $option = '';
        foreach ($value['options'] as $data) {

            $sel = '';
            if( !empty($value['value']) ){
                if( $value['value']==$data['id']  ){
                    $sel = ' selected="1"';
                }
            }

            $option .= '<option'.$sel.' value="'.$data['id'].'">'.$data['name'].'</option>';
        }

        $input = '<select class="inputtext" id="'.$value['id'].'" name="'.$value['id'].'">'.$option.'</select>';
    }
    else{

        $input = '<input id="'.$value['id'].'" autocomplete="off" placeholder="'.$value['label'].'" class="inputtext" type="text" name="'.$value['id'].'" value="'.( !empty($value['value'])? $value['value']: '' ).'">';
    }

    $name .= '<div class="u-table-cell">'.$input.'</div>';
}


$form   ->field("name")
        ->label('ชื่อ')
        ->text( '<div class="u-table"><div class="u-table-row">'.$name.'</div></div>' );

$form   ->field("cus_nickname")
        ->label('ชื่อเล่น')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['nickname'])? $this->item['nickname']:'' );

$birthday = '';
$day = '<option value="00">วัน</option>';
for ($i=1; $i <= 31; $i++) { 

    $see = '';
    if( $this->item['birthday']!='0000-00-00' ){
        $see = date('j', strtotime($this->item['birthday'])) == $i ? ' selected="1"':'';
    }
    
    $day .= '<option'.$see.' value="'.$i.'">'.$i.'</option>';
}
$birthday .= '<div class="u-table-cell"><select class="inputtext" name="birthday[date]">'.$day.'</select></div>';

$m = '<option value="00">เดือน</option>';
for ($i=1; $i <= 12; $i++) { 

    $see = '';
    if( $this->item['birthday']!='0000-00-00' ){
        $see = date('n', strtotime($this->item['birthday'])) == $i ? ' selected="1"':'';
    }
    $m .= '<option'.$see.' value="'.$i.'">'. $this->fn->q('time')->month( $i, true).'</option>';
}
$birthday .= '<div class="u-table-cell"><select class="inputtext" name="birthday[month]" class="u-table-cell">'.$m.'</select></div>';


$y = '<option value="0000">ปี</option>';
$_year = date('Y')-6;
for ($i=0; $i < 60; $i++) {

    $see = '';
    if( $this->item['birthday']!='0000-00-00' ){
        $see = date('Y', strtotime($this->item['birthday'])) == $_year ? ' selected="1"':'';
    }

    $y .= '<option'.$see.' value="'.$_year.'">'.($_year+543).'</option>';
    $_year--;
    
}
$birthday .= '<div class="u-table-cell"><select class="inputtext" name="birthday[year]" class="u-table-cell">'.$y.'</select></div>';

$form   ->field("birthday")
        ->label('วันเกิด')
        ->text( '<div class="u-table"><div class="u-table-row">'.$birthday.'</div></div>' );

$form   ->field("cus_card_id")
        ->label('หมายเลขบัตรประจำตัวประชาชน')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['card_id'])? $this->item['card_id']:'' );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'customers/update_basic"></form>';

# body
$arr['body'] = $form->html();

if( !empty($this->item) ){
    $arr['title']= "Edit Customres";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "New Customres";
}

$arr['height'] = 'auto';
$arr['overflowY'] = 'auto';
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);