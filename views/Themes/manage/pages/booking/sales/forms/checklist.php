<?php

$li = '';
foreach ($this->results as $key => $value) {

    $contact = '';
    if( !empty($value['phone_number']) ){
        $contact = '<i class="icon-phone mrs"></i>'.$value['phone_number'];
    }
    elseif( !empty($value['email']) ){
        $contact = '<i class="icon-envelope-o mrs"></i>: '.$value['email'];
    }
    elseif( !empty($value['line_id']) ){
        $contact = 'Line ID: '.$value['phone'];
    }

    $checked = false;
    if( isset($this->checked) ){
        if( is_array($this->checked) ){
            foreach ($this->checked as $id) {
                if( $value['id']==$id ){
                    $checked = true;
                    break;
                }
            }
        }
        else if( $value['id']==$this->checked ){
            $checked = true;
        }
    }

    $image = '';
    if( !empty($value['image_url']) ){
        $image = '<div class="avatar lfloat mrm"><img class="img" src="'.$value['image_url'].'" alt="'.$value['fullname'].'"><i class="icon-check i-after"></i></div>';
    }
    else{
        $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user i-before"></i><i class="icon-check i-after"></i></div></div>';
    }

    $li .= '<li class="checklist-item'.( $checked ? ' checked':'' ).'"><div class="anchor clearfix">'.$image.'<div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">'.$value['fullname'].'</div><div class="subname fsm meta">'.$contact.'</div></div></div></div>'.

        '<div class="checklist-item-hiden">'.
            '<input type="checkbox" name="ids[]" value="'.$value['id'].'"'.( $checked ? ' checked="1"':'' ).'>'.
        '</div>'.
    '</li>';
}

$arr['title']= "Sales Consultant";

# set form
$arr['form'] = '<form class="js-submit-form checklist-container" method="post" action="'.URL. 'booking/change_sale"></form>';

# body
$arr['body'] = '<div class="pal checklist-main" data-plugins="checklist" data-options="'.$this->fn->stringify( $this->options ).'">'.
    '<ul class="checklist-items checklist-horizontal count-3" ref="listsbox">'.$li.'</ul>'.
'</div>';

$arr['height'] = 'full';
$arr['overflowY'] = 'auto';
$arr['width'] = 980;

if( !empty($this->item) ){
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}

if( isset($_REQUEST['callback']) ){
    $arr['button'] = '<button type="submit" role="submit" class="btn btn-primary btn-submit"><span class="btn-text">เสร็จ</span></button>';
}else{
    $arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
}

$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);