<?php


$form = new Form();
$form = $form->create()
	// set From
	->elem('div');

$form   ->field("sender_is_owner")
        ->label('ผู้ส่งซ่อม')
        ->text( '<table><tr>'.

        	'<td><label class="radio"><input type="radio" id="sender_is_owner" name="sender[is_owner]" value="1" class="js-senderIsOwner" checked />เจ้าของส่งซ่อมเอง</label></td>'.
        	'<td class="plm"><label class="radio"><input type="radio" id="sender_is_owner" name="sender[is_owner]" value="0" class="js-senderIsOwner" />ไม่ใช่เจ้าของส่งซ่อม</label></td>' .

        '</tr></table>' );

$field_sender_name[] = array( 
    'id' => 'cus_prefix_name', 
    'name' => 'cus[prefix_name]', 
    'label' => 'คำนำหน้าชื่อ',
    'type' => 'select',
    'options' => $this->prefixName
);

$field_sender_name[] = array( 
    'id' => 'sender_first_name', 
    'name' => 'sender[first_name]', 
    'label' => 'ชื่อ',
);

$field_sender_name[] = array( 
    'id' => 'sender_last_name', 
    'name' => 'sender[last_name]', 
    'label' => 'นามสกุล',
);

$field_sender_name[] = array( 
    'id' => 'sender_nickname', 
    'name' => 'sender[nickname]', 
    'label' => 'ชื่อเล่น',
);

$form   ->field("sender_name")
        ->label('ข้อมูลผู้ส่งซ่อม')
        ->text( '<div class="u-table"><div class="u-table-row">'.$this->fn->uTableCell($field_sender_name).'</div></div>' );

$form   ->field("sender_relationship")
        ->name('sender[relationship]')
        ->label( 'เกี่ยวข้องกับเจ้าของรถเป็น' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->field("sender_mobile_phone")
        ->name('sender[mobile_phone]')
        ->label( 'เบอร์มือถือ' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->field("sender_tel")
        ->name('sender[tel]')
        ->label( 'โทรศัพท์บ้าน/ทำงาน' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->field("sender_line_id")
        ->name('sender[line_id]')
        ->label( 'Line ID' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->field("sender_note")
        ->name('sender[note]')
        ->label('หมายเหตุ')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$section .= $form->html();