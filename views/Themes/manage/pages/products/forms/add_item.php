<?php

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert pal');

/*$form   ->field("qty")
        ->label('จำนวน')
        ->autocomplete('off')
        ->addClass('inputtext js-number')
        ->placeholder('ป้อนจำนวนใหม่ที่ต้องการเพิ่มสินค้า..');*/

$form   ->field("items")
        ->text('<div class="ui-items-lists" rel="listbox"></div>');


# set form
$arr['form'] = '<form data-plugins="addPDItem" data-options="'.$this->fn->stringify( array(
	'colors' => $this->colors
) ).'" class="js-submit-form" method="post" action="'.URL. 'products/add_item/'.$this->item['id'].'"></form>';

$arr['summary'] = '<div class="clearfix"><fieldset style="float: left; margin-right: 10px;margin-bottom: 0;" id="qty_fieldset" class="control-group"><label for="qty" class="control-label fcg fwb">ป้อนจำนวนสินค้าใหม่</label><div class="controls"><input id="qty" autocomplete="off" class="inputtext js-number" placeholder="" minlength="1" type="number" name="qty"><div class="notification"></div></div></fieldset>';

$arr['summary'] .= '<fieldset id="cost_fieldset" class="control-group"><label for="cost" class="control-label fcg fwb">ราคาทุน (ราคาเดิม '.number_format($this->activity['cost'],0).' บาท)</label><div class="controls"><input id="cost" autocomplete="off" class="inputtext" type="text" name="cost" value="'.(!empty($this->activity['cost']) ? round($this->activity['cost']):'').'"><div class="notification"></div></div></fieldset></div>';

# body
$arr['body'] = $form->html();


$arr['title']= "เพิ่มจำนวนสินค้า";

$arr['hiddenInput'][] = array('name'=>'old_cost','value'=>$this->activity['cost']);

$arr['height'] = 'full';
$arr['overflowY'] = 'auto';
$arr['width'] = 720;
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';


echo json_encode($arr);
