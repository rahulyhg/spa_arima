<?php

// term of payment

$form = new Form();
$form = $form 	->create()
          ->addClass('form_payment') 
    			->elem('div');

$form   ->field("book_type")
        ->text( '<ul class="list-table-cell">
    <li>
      <table><tr>
        <td><label class="radio"><input type="radio" name="book[pay_type]" value="cash" action-set="paytype" checked="1" >เงินสด</label></td>
        <td><label class="radio"><input type="radio" name="book[pay_type]" value="hier" action-set="paytype">กรณีเช่าซื้อ/Hier Purchase</label></td>
      </tr></table>
    </li>
    <li action-type="paytype" data-id="hier">
      <table><tr>
        <td class="cell-label">บริษัท/Finance company</td>
        <td><input type="text" name="book[pay_type_options][finance_name]" class="inputtext"></td>
      </tr></table>
    </li>
    <li action-type="paytype" data-id="hier">
      <table><tr>
        <td class="cell-label">เงินดาวน์/Down payment</td>
        <td style="width:50px;"><input type="text" name="book[pay_type_options][down_payment_percent]" class="inputtext"></td>
        <td class="cell-label">%</td>
        <td style="width:150px;"><input type="text" name="book[pay_type_options][down_payment_price]" data-name="paydown" class="inputtext js-number"></td>
        <td class="cell-label">บาท/Bath</td>
        <td></td>
      </tr></table>
    </li>
    <li action-type="paytype" data-id="hier">
      <table><tr>
        <td class="cell-label">ดอกเบี้ย/Interest</td>
        <td style="width:50px;"><input type="text" name="book[pay_type_options][interest]" class="inputtext"></td>
        <td class="cell-label">%</td>
        <td>
            <ul class="pts">
                <li><label class="radio"><input type="radio" name="book[pay_type_options][supply]" value="begin" checked>ต้นงวด/Beginning</label></li>
                <li><label class="radio"><input type="radio" name="book[pay_type_options][supply]" value="ending">ปลายงวด/Ending</label></li>
            </ul>
          </td>
      </tr></table>
    </li>
    <li action-type="paytype" data-id="hier">
      <table><tr>
        <td class="cell-label">ยอดจัด/Finance Amount</td>
        <td><input type="text" name="book[pay_type_options][finance_amount]" class="inputtext"></td>
        <td class="cell-label">บาท/baht</td>
      </tr></table>
    </li>
    <li action-type="paytype" data-id="hier">
      <table><tr>
        <td class="cell-label">ผ่อนชำระ/Interest</td>
        <td><input type="text" name="book[pay_type_options][installment]" class="inputtext"></td>
        <td class="cell-label">เดือน/Month</td>

        <td class="cell-label">เดือนละ/Monthly</td>
        <td><input type="text" name="book[pay_type_options][pay_monthly]" class="inputtext"></td>
        <td class="cell-label">บาท/baht</td>
      </tr></table>
    </li>'.

'</ul>' );


$section .= $form->html();