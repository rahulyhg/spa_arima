<?php 

$arr['title']= "แก้ไขการชำระเงิน";
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
$arr['hiddenInput'][] = array('name'=>'type','value'=>'payment');


$income = array();
$deposit = array();

$tr = array('income'=>'', 'less'=>'');
foreach ($this->conditions as $key => $value) {

    $type = 'less';
    $dataname = '';
    $cls = 'inputtext js-number';
    $data = array();

    foreach ($this->item['conditions'] as $i => $item) {

        if( $item['has_etc']==0 && $item['condition_id']==$value['id'] ){
            $this->item['conditions'][$i]['is'] = 1;
            $data = $item;
            break;
        }
    }

    $val = 0;
    if( !empty($data['value']) ){
        $val = is_numeric($data['value']) ? $data['value']:0;
    }


    if( !empty($value['keyword']) ){
        $dataname = 'summary="'.$value['keyword'].'" data-name="'.$value['keyword'].'"';
    }

    if( empty($value['is_cal']) ){
        $cls .= ' is-lock';
    }

    if( !empty( $value['income'] ) ){
        $type = 'income';
    }

    $inputHidden = '';
    if( !empty($value['has_lock']) ){
        
        $inputHidden = '<input data-type="'.$type.'" type="hidden" name="payment['.$type.'][value][]"'.$dataname.' value="'.$val.'">';

        $cls .= ' disabled';
    }

    $tr[$type] .= '<tr'.( !empty($value['id']) ? ' data-id="'.$value['id'].'"':'' ).'>'.
        '<td class="label">'.$value['name'].'</td>'.
        '<td class="data">'.
            '<input type="hidden" name="payment['.$type.'][name][]" value="'.$value['id'].'" class="inputtext">'.
            $inputHidden .
            '<input data-type="'.$type.'" type="text" name="payment['.$type.'][value][]" class="'.$cls.'"'.$dataname.''.( !empty($value['has_lock'])? ' disabled':'' ).' value="'.$val.'">'.
            '</td>'.
        '<td class="baht">บาท/baht</td>'.
    '</tr>';

}

foreach ($this->item['conditions'] as $key => $value) {
    if( isset($value['is']) ) continue;

    $val = is_numeric($value['value']) ? $value['value']:0;
    $type = 'less';

    if( $value['type'] == 'income' ){
        $income++;
        $no = $income;

        $type = 'income';
    }
    else{
        $deposit++;
        $no = $deposit;
    }

    $tr[ $type ] .= '<tr data-id="etc">'.
        '<td class="label">อื่นๆ/Other <input type="text" name="payment['.$type.'][name][]" class="inputtext mrs" style="width:260px;" value="'.$value['name'].'"><a title="เพิ่มการชำระเงิน" data-plugins="tooltip" data-reload="1" class="icon js-plus-list"><i class="icon-plus"></i></a><a title="ลบเงื่อนไข" data-plugins="tooltip" data-reload="1" class="icon js-remove-list"><i class="icon-remove"></i></a></td>'.
        '<td class="data"><input data-type="'.$type.'" type="text" name="payment['.$type.'][value][]" class="inputtext js-number" value="'.$val.'"></td>'.
        '<td class="baht">บาท/baht</td>'.
    '</tr>';
}



$tr['income'] .= '<tr data-id="etc">'.
            '<td class="label">อื่นๆ/Other <input type="text" name="payment[income][name][]" class="inputtext mrs" style="width:260px;"><a title="เพิ่มการชำระเงิน" data-plugins="tooltip" data-reload="1" class="icon js-plus-list"><i class="icon-plus"></i></a><a title="ลบเงื่อนไข" data-plugins="tooltip" data-reload="1" class="icon js-remove-list"><i class="icon-remove"></i></a></td>'.
            '<td class="data"><input data-type="income" type="text" name="payment[income][value][]" class="inputtext js-number" /></td>'.
            '<td class="baht">บาท/baht</td>'.
        '</tr>';

$tr['less'] .= '<tr data-id="etc">'.
            '<td class="label">อื่นๆ/Other <input type="text" name="payment[less][name][]" class="inputtext mrs" style="width:260px;"><a title="เพิ่มรายการหัก" data-plugins="tooltip" data-reload="1" class="icon js-plus-list"><i class="icon-plus"></i></a><a title="ลบรายการหัก" data-plugins="tooltip" data-reload="1" class="icon js-remove-list"><i class="icon-remove"></i></a></td>'.
            '<td class="data"><input data-type="less" type="text" name="payment[less][value][]" class="inputtext js-number" /></td>'.
            '<td class="baht">บาท/baht</td>'.
            '</tr>';

$form = new Form();
$form = $form 	->create()
                ->addClass('form_conditions pal')
    			->elem('div');

$form   ->field("conditions")
        ->text( '<table class="booking-conditions" rel="listsbox"><tbody>'.

            '<tbody class="income">'. $tr['income']. '</tbody>'.

            '<tbody class="sub"><tr>'.
                '<td class="label fwb">รวมค่าใช้จ่าย/Total expense</td>'.
                '<td class="data"><input type="text" class="inputtext" value="00.00" disabled="1" summary="sub" /></td>'.
                '<td class="baht">บาท/baht</td>'.
            '</tr></tbody>'.

            '<tbody class="deposit">'. $tr['less']. '</tbody>'.

            '<tbody class="total"><tr>'.
                '<td class="label fwb">รวมค่าใช้จ่ายทั้งสิ้น/Net total expense</td>'.
                '<td class="data"><input type="text" class="inputtext" value="00.00" disabled="1" summary="total" /></td>'.
                '<td class="baht">บาท/baht</td>'.
            '</tr></tbody>'.

        '</tbody></table>' );


# set form
$arr['form'] = '<form class="js-submit-form form-booking" method="post" action="'.URL. 'booking/update" data-plugins="conditionpayment"></form>';

# body
$arr['body'] = $form->html();

$arr['width'] = 720;
$arr['height'] = 'full';
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);