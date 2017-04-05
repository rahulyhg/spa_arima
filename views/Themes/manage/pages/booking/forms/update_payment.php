<?php

$arr['title']= "แก้ไขเงื่อนไขการชำระเงิน";
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
$arr['hiddenInput'][] = array('name'=>'type','value'=>'payment');

$supply = '';

if( !empty($this->item['pay_type']['options']['supply']) ){
  $supply = $this->item['pay_type']['options']['supply'];
}

$option = array();
if( !empty($this->item['pay_type']['options']) ){
  $option = $this->item['pay_type']['options'];
}

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form   ->field("book_type")
        ->text( '<ul class="list-table-cell" data-plugins="actionsListHiden">
    <li>
      <table><tr>
        <td><label class="radio"><input type="radio" name="book[pay_type]" value="cash" action-id="cash" '.($this->item['pay_type']['id']=='cash'?'checked="1"':'').'>เงินสด</label></td>
        <td><label class="radio"><input type="radio" name="book[pay_type]" value="hier" action-id="hier" '.($this->item['pay_type']['id']=='hier'?'checked="1"':'').'>กรณีเช่าซื้อ/Hier Purchase</label></td>
      </tr></table>
    </li>
    <li action-type="hier">
      <table><tr>
        <td class="cell-label">บริษัท/Finance company</td>
        <td><input type="text" name="book[pay_type_options][finance_name]" class="inputtext" value="'.(!empty($option['finance_name'])?$option['finance_name']:'').'"></td>
      </tr></table>
    </li>
    <li action-type="hier">
      <table><tr>
        <td class="cell-label">เงินดาวน์/Down payment</td>
        <td style="width:50px;"><input type="text" name="book[pay_type_options][down_payment_percent]" class="inputtext" value="'.(!empty($option['down_payment_percent']) ? $option['down_payment_percent'] : '').'"></td>
        <td class="cell-label">%</td>
        <td style="width:150px;"><input type="text" name="book[pay_type_options][down_payment_price]" data-name="paydown" class="inputtext js-number" value="'.(!empty($option['down_payment_price']) ? $option['down_payment_price']:'').'"></td>
        <td class="cell-label">บาท/Bath</td>
        <td></td>
      </tr></table>
    </li>
    <li action-type="hier">
      <table><tr>
        <td class="cell-label">ดอกเบี้ย/Interest</td>
        <td style="width:50px;"><input type="text" name="book[pay_type_options][interest]" class="inputtext" value="'.(!empty($option['interest'])?$option['interest']:'').'"></td>
        <td class="cell-label">%</td>
        <td>
            <ul class="pts">
                <li><label class="radio"><input type="radio" name="book[pay_type_options][supply]" value="begin" '.($supply=='begin'?'Checked="1"':'').'>ต้นงวด/Beginning</label></li>
                <li><label class="radio"><input type="radio" name="book[pay_type_options][supply]" value="ending" '.($supply=='ending'?'Checked="1"':'').'>ปลายงวด/Ending</label></li>
            </ul>
          </td>
      </tr></table>
    </li>
    <li action-type="hier">
      <table><tr>
        <td class="cell-label">ยอดจัด/Finance Amount</td>
        <td><input type="text" name="book[pay_type_options][finance_amount]" class="inputtext" value="'.(!empty($option['finance_amount'])?$option['finance_amount']:'').'"></td>
        <td class="cell-label">บาท/baht</td>
      </tr></table>
    </li>
    <li action-type="hier">
      <table><tr>
        <td class="cell-label">ผ่อนชำระ/Interest</td>
        <td><input type="text" name="book[pay_type_options][installment]" class="inputtext" value="'.(!empty($option['installment'])?$option['installment']:'').'"></td>
        <td class="cell-label">เดือน/Month</td>

        <td class="cell-label">เดือนละ/Monthly</td>
        <td><input type="text" name="book[pay_type_options][pay_monthly]" class="inputtext" value="'.(!empty($option['pay_monthly'])?$this->item['pay_type']['options']['pay_monthly']:'').'"></td>
        <td class="cell-label">บาท/baht</td>
      </tr></table>
    </li>'.

'</ul>' );


# set form
$arr['form'] = '<form class="js-submit-form form-booking" method="post" action="'.URL. 'booking/update"></form>';

# body
$arr['body'] = $form->html();

$arr['width'] = 720;

$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);