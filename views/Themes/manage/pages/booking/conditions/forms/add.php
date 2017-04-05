<?php


if( !empty($this->item) ){
    $arr['title']= "Edit Condition";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);

    $income_checked = !empty($this->item['income']) ?' checked="1"' :'';
    $income_lock = !empty($this->item['has_lock']) ?' checked="1"' :'';
    $is_cal = !empty($this->item['is_cal']) ?' checked="1"' :'';
}
else{
    $arr['title']= "New Condition";
}


$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form ->hr('<div class="pam uiBoxYellow mbm"><ul class="uiList uiListStandard">
    <li><strong>Income:</strong> ค่าจำนวนเงินบวกการจอง</li>
    <li><strong>Lock:</strong> จะไม่นำค่าเงินไปคิดรวมกับค่าใช้จ่ายของการจอง</li>
</ul></div>');

$form   ->field("condition_name")
        ->label('Name')
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['name'])? $this->item['name']:'' );

$form   ->field("condition_income")
        ->text(
            '<input autocomplete="off" class="inputtext mrl" style="width: 80px;display: inline-block;" type="text" name="condition_keyword" placeholder="Keyword" value="'.( !empty($this->item['keyword'])? $this->item['keyword']:'' ).'">'.
            '<label class="checkbox mrl"><input type="checkbox" name="condition_income"'.( isset($income_checked)?$income_checked: ' checked="1"' ).'><span class="fwb">Income</span></label>'.
            '<label class="checkbox mrl"><input type="checkbox" name="condition_is_cal"'.( isset($is_cal)?$is_cal: ' checked="1"' ).'><span class="fwb">Calculate</span></label>'.
            '<label class="checkbox"><input type="checkbox" name="condition_lock"'.( isset($income_lock)?$income_lock: ' checked="1"' ).'><span class="fwb">Lock</span></label>' );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'booking/save_condition"></form>';

# body
$arr['body'] = $form->html();

$arr['height'] = 'auto';
$arr['overflowY'] = 'auto';
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);