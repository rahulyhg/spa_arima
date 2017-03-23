<?php

$arr['title']= "แก้ไขอุปกรณ์ตกแต่ง";
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
$arr['hiddenInput'][] = array('name'=>'type','value'=>$this->type);


$li ='<li class="etc" data-id="etc">'.
    '<table>'.
        '<tr class="tr-label"><td colspan="2"></td><td class="actions"><label>แถม</label></td></tr>'.
        '<tr>'.
            '<td><input type="text" name="accessory[name][]" class="inputtext js-change-accessory" placeholder="อื่นๆ/เพิ่มเติม..." autocomplete="off" data-accessory="name" /></td>'.
            '<td class="price">'.
                '<input type="text" name="accessory[value][]" class="inputtext js-change-accessory" placeholder="ราคา..." autocomplete="off" data-accessory="value">'.
            '</td>'.
            '<td class="actions">'.
                '<label class="checkbox"><input type="checkbox" name="accessory[FOC][]" value="1" class="js-change-accessory" data-accessory="FOC"></label>'.
            '</td>'.
        '</tr>'.
    '</table>'.

    '<div class="accessory-meta">'.
        '<input type="hidden" name="accessory[cost][]" data-accessory="cost" value="0" autocomplete="off">'.
        '<input type="hidden" name="accessory[rate][]" data-accessory="rate" value="0" autocomplete="off">'.
        '<input type="hidden" name="accessory[has_etc][]" data-accessory="has_etc" value="1" autocomplete="off">'.
    '</div>'.

    '<div class="accessory-actions">'.
        '<button type="button" data-reload="1" class="i-btn-a1 js-plus-accessory"><i class="icon-plus"></i></button>'.
        '<button type="button" data-reload="1" class="i-btn-a1 js-remove-accessory"><i class="icon-remove"></i></button>'.
    '</div>'.
'</li>';

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form   ->field("book_type")
        ->text( '<div class="accessory-wrap pal">'.
         '<ul class="list-table-cell clearfix" rel="listsbox">'. $li .'</ul>'.
      '</div>' );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'booking/update" data-plugins="listsaccessory" data-options="'.$this->fn->stringify( array(
        'model' => !empty($this->item['model']['id'])? $this->item['model']['id']:'',
        'data' => $this->item['accessory']
    ) ).'"></form>';


# body
$arr['body'] = $form->html();

$arr['width'] = 720;
$arr['height'] = 'full';
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);