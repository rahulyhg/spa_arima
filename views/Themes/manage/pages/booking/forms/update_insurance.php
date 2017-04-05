<?php

$arr['title']= "แก้ไขประกันภัย";
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
$arr['hiddenInput'][] = array('name'=>'type','value'=>'insurance');

$sure0 = '';
$value0 = '';
$sure1 = '';
$value1 = '';

if( $this->item['insurance']['sure'] == 0 ){
  $sure0 = ' Checked="1"';
  $value0 = $this->item['insurance']['premium']; 
}
else{
  $sure1 = ' Checked="1"';
  $value1 = $this->item['insurance']['premium'];
}

$form = new Form();
$form = $form   ->create()
                ->elem('div');

$form   ->field("book_insurence")
        ->text( '<ul class="list-table-cell">'.

    '<li>'.
        '<table>'.
            '<tr>'.
               '<td class="cell-label">บริษัท/Finance company</td>'.
               '<td class="cell-data"><input type="text" name="insurence[name]" class="inputtext" value="'.$this->item['insurance']['name'].'"></td>'.
            '</tr>'.
        '</table>'.
    '</li>'.

    '<li>'.
        '<table>'.
            '<tr>'.
               '<td class="cell-label">ประเภท/Party</td>'.
               '<td class="cell-data"><input type="text" name="insurence[party]" class="inputtext" value="'.$this->item['insurance']['party'].'"></td>'.
               '<td class="cell-label">ทุนประกัน</td>'.
               '<td class="cell-data"><input type="text" name="insurence[pledge]" class="inputtext" value="'.$this->item['insurance']['pledge'].'"></td>'.
               '<td class="cell-right">บาท/Baht</td>'.
            '</tr>'.
        '</table>'.
    '</li>'.

    '<li>'.
        '<table data-plugins="actionsListHiden">'.
            '<tr data-active="sure">'.
               '<td class="pts"><label class="radio"><input type="radio" name="insurence[sure]" value="1" class="js-change-insurenceSure" '.$sure1.' data-actions="sure">ระบุชื่อ</label></td>'.
               '<td class="cell-label">ค่าเบี้ยประกัน/Premiun</td>'.
               '<td class="cell-data"><input data-name="insurance" type="text" name="insurence[premium]" class="inputtext not-clone js-number js-change-insurence" value="'.$value1.'"></td>'.
               '<td class="cell-right">บาท/Baht</td>'.
            '</tr>'.
            '<tr data-active="sure1">'.
               '<td class="pts"><label class="radio"><input type="radio" name="insurence[sure]" value="0" class="js-change-insurenceSure" '.$sure0.' data-actions="sure1">ไม่ระบุชื่อ</label></td>'.
               '<td class="cell-label">ค่าเบี้ยประกัน/Premiun</td>'.
 
               '<td class="cell-data"><input type="text" name="insurence[premium]" class="inputtext disabled not-clone js-number js-change-insurence" data-name="insurance" disabled value="'.$value0.'"></td>'.
               '<td class="cell-right">บาท/Baht</td>'.
            '</tr>'.
        '</table>'.
    '</li>'.

'</ul>' );


# set form
$arr['form'] = '<form class="js-submit-form form-booking" method="post" action="'.URL. 'booking/update"></form>';

# body
$arr['body'] = $form->html();

$arr['width'] = 720;

$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);