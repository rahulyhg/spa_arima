<?php

$form = new Form();
$form = $form   ->create()
                ->elem('div');

$form   ->field("book_insurence")
        ->text( '<ul class="list-table-cell">'.

    '<li>'.
        '<table>'.
            '<tr>'.
               '<td class="cell-label">บริษัท/Finance company</td>'.
               '<td class="cell-data"><input type="text" name="insurence[name]" class="inputtext"></td>'.
            '</tr>'.
        '</table>'.
    '</li>'.

    '<li>'.
        '<table>'.
            '<tr>'.
               '<td class="cell-label">ประเภท/Party</td>'.
               '<td class="cell-data"><input type="text" name="insurence[party]" class="inputtext"></td>'.
               '<td class="cell-label">ทุนประกัน</td>'.
               '<td class="cell-data"><input type="text" name="insurence[pledge]" class="inputtext"></td>'.
               '<td class="cell-right">บาท/Baht</td>'.
            '</tr>'.
        '</table>'.
    '</li>'.

    '<li>'.
        '<table>'.
            '<tr>'.
               '<td class="pts"><label class="radio"><input type="radio" name="insurence[sure]" value="1" class="js-change-insurenceSure" checked>ระบุชื่อ</label></td>'.
               '<td class="cell-label">ค่าเบี้ยประกัน/Premiun</td>'.
               '<td class="cell-data"><input data-name="insurance" type="text" name="insurence[premium]" class="inputtext not-clone js-number js-change-insurence"></td>'.
               '<td class="cell-right">บาท/Baht</td>'.
            '</tr>'.
            '<tr>'.
               '<td class="pts"><label class="radio"><input type="radio" name="insurence[sure]" value="0" class="js-change-insurenceSure">ไม่ระบุชื่อ</label></td>'.
               '<td class="cell-label">ค่าเบี้ยประกัน/Premiun</td>'.
 
               '<td class="cell-data"><input type="text" name="insurence[premium]" class="inputtext disabled not-clone js-number js-change-insurence" data-name="insurance" disabled></td>'.
               '<td class="cell-right">บาท/Baht</td>'.
            '</tr>'.
        '</table>'.
    '</li>'.

'</ul>' );


$section .= $form->html();