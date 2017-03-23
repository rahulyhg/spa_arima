<?php

$deposit_type = 'cash';

$form = new Form();
$form = $form 	->create()
                ->addClass('form_depositType')
    			->elem('div');

$form   ->field("book_type")
        ->text( 
'<ul class="list-table-cell">'.
    '<li><label class="radio"><input'.( $deposit_type=='cash' ? ' checked="1"':'' ).' type="radio" name="book[deposit_type]" value="cash">เงินสด</label></li>'.
    '<li><table>'.
        '<tr>'.
            '<td class="pts"><label class="radio"><input'.( $deposit_type=='credit' ? ' checked="1"':'' ).' type="radio" name="book[deposit_type]" value="credit" />บัตเครดิต</label></td>'.
            '<td class="cell-label">เลขที่บัตร</td>'.
            '<td><input type="text" name="book[deposit_type_options][number]" class="inputtext" disabled /></td>'.
            '<td class="cell-label">วันหมดอายุ</td>'.
            '<td><input type="date" name="book[deposit_type_options][exp]" class="inputtext" disabled /></td>'.
        '</tr>'.
    '</table></li>'.

    '<li><table>'.
        '<tr>'.
            '<td class="pts" style="width:100px"><label class="radio"><input type="radio" name="book[deposit_type]" value="check"'.( $deposit_type=='check' ? ' checked="1"':'' ).'><span>เช็คธนาคาร</span></label></td>'.
            '<td><input type="text" name="book[deposit_type_options][bank]" class="inputtext" disabled></td>'.
            '<td class="cell-label">สาขา</td>'.
            '<td><input type="text" name="book[deposit_type_options][branch]" class="inputtext" disabled></td>'.
        '</tr>'.
        '<tr>'.
            '<td class="cell-label pll"><span class="mls">เลขที่เช็ค</span></td>'.
            '<td><input type="text" name="book[deposit_type_options][number]" class="inputtext" disabled></td>'.
            '<td class="cell-label">ลงวันที่</td>'.
            '<td><input type="date" name="book[deposit_type_options][create]" class="inputtext" disabled></td>'.
        '</tr>'.
    '</table></li>'.
'</ul>'
);


$section .= $form->html();