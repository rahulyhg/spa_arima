<?php

$arr['title']= "แก้ไขเงินมัดจำ";
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
$arr['hiddenInput'][] = array('name'=>'type','value'=>'deposit');

$deposit_type = 'cash';

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');


$form   ->field("book_deposit")
		->name('book[deposit]')
		->type('number')
        ->label('เงินมัดจำ')
        ->autocomplete('off')
        ->addClass('inputtext w-auto')
        ->placeholder('')
        ->value( !empty($this->item['deposit'])? $this->item['deposit']:'' );

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

# set form
$arr['form'] = '<form class="js-submit-form form-booking" method="post" action="'.URL. 'booking/update"></form>';


# body
$arr['body'] = $form->html();

$arr['width'] = 720;
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);