<?php

$li = '';

$li.='<li class="wfull etc">'.
    '<table>'.
        '<tr class="tr-label"><td colspan="2"></td><td class="actions"><label>แถม</label></td></tr>'.
        '<tr>'.
            '<td><input type="text" name="accessory[name][]" class="inputtext js-change-accessory" placeholder="อื่นๆ/เพิ่มเติม..." autocomplete="off" accessory="name" /></td>'.
            '<td class="price">'.
                '<input type="text" name="accessory[value][]" class="inputtext js-change-accessory" placeholder="ราคา..." autocomplete="off" accessory="value">'.
            '</td>'.
            '<td class="actions">'.
                '<label class="checkbox"><input type="checkbox" name="accessory[foc][]" value="less" class="js-change-accessory" accessory="type"></label>'.
            '</td>'.
        '</tr>'.
    '</table>'.

    '<div class="accessory-meta">'.
        '<input type="hidden" name="accessory[cost][]" accessory="cost" value="0" autocomplete="off">'.
        '<input type="hidden" name="accessory[rate][]" accessory="rate" value="0" autocomplete="off">'.
        '<input type="hidden" name="accessory[has_etc][]" accessory="has_etc" value="1" autocomplete="off">'.
    '</div>'.

    '<div class="accessory-actions">'.
        '<button type="button" data-reload="1" class="i-btn-a1 js-plus-accessory"><i class="icon-plus"></i></button>'.
        '<button type="button" data-reload="1" class="i-btn-a1 js-remove-accessory"><i class="icon-remove"></i></button>'.
    '</div>'.
'</li>';

$form = new Form();
$form = $form  ->create()
            ->elem('div');

$form   ->field("book_type")
        ->text( '<div class="accessory-wrap">'.
         '<ul class="list-table-cell clearfix" rel="listsbox">'. $li .'</ul>'.
         // '<div class="clearfix mts"><a class="rfloat fsm js-add-accessory">+เพิ่ม</a></div>'.
         /*'<div class="accessory-notes mtm">
            <label class="control-label">เหมายเหตุ/เพิ่มเติม</label>
            <textarea class="inputtext" name="book[accessory_note]"></textarea>'.
         '</div>'.*/

      '</div>' );

$section .= $form->html();