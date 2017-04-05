<?php 

$income = 0;
$income_tatol = 0;

$deposit = 0;
$lass_tatol = 0;

$tr = array('income'=>'', 'less'=>'');
foreach ($this->conditions as $key => $value) {

    $type = 'less';
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
    
    $desc = empty($value['is_cal']) ?'<span class="fcg mls fsm">ไม่รวมค่าใช่จ่าย</span>': '';
    if( !empty($value['income']) ){
        $income++;
        $no = $income;
        $type = 'income';

        if( !empty($value['is_cal']) ){
            $income_tatol += is_numeric($val) ? $val:0;
        }

    }
    else{
        $deposit++;
        $no = $deposit;

        if( !empty($value['is_cal']) ){
            $lass_tatol += is_numeric($val) ? $val: 0;
        }
    }

    $tr[ $type ] .= '<tr>'.
        '<td class="ID">'.$no.'.</td>'.
        '<td class="name">'.$value['name'].$desc.'</td>'.
        '<td class="price">'. ($val==0 ? '-': number_format($val,0) ) .'</td>'.
        // '<td class="baht">บาท/baht</td>'.
    '</tr>';
}

foreach ($this->item['conditions'] as $key => $value) {
    if( isset($value['is']) ) continue;

    $val = is_numeric($value['value']) ? $value['value']:0;

    if( $value['type'] == 'income' ){
        $income++;
        $no = $income;

        $income_tatol += is_numeric($val) ? $val:0;
    }
    else{
        $deposit++;
        $no = $deposit;

        $lass_tatol += is_numeric($val) ? $val: 0;
    }

    $tr[ $value['type'] ] .= '<tr>'.
        '<td class="ID">'.$no.'.</td>'.
        '<td class="name">'.$value['name'].'</td>'.
        '<td class="price">'. ($val==0 ? '-':number_format($val,0)) .'</td>'.
        // '<td class="baht">บาท/baht</td>'.
    '</tr>';
}

echo '<table class="mtl table-accessory"><tbody>'.
	

    '<tbody class="income">'. $tr['income']. '</tbody>'.

    '<tbody><tr>'.
		'<th colspan="2" class="total-text">รวมค่าใช้จ่าย</th>'.
		'<th class="total-value price">'. number_format( $income_tatol, 0) .'</th>'.
	'</tr></tbody>'.

'</tbody></table>';

echo '<table class="mtl table-accessory"><tbody>'.

    '<tbody class="income">'. $tr['less']. '</tbody>'.

    '<tbody><tr>'.
        '<th colspan="2" class="total-text">รวมรายการหัก</th>'.
        '<th class="total-value price">'. number_format( $lass_tatol, 0) .'</th>'.
    '</tr></tbody>'.

    '<tfoot><tr>'.
		'<th colspan="2" class="total-text">รวมค่าใช้จ่ายทั้งสิ้น</th>'.
		'<th class="total-value price">'. ( number_format( $income_tatol-$lass_tatol, 0)  ) .'</th>'.
	'</tr></tfoot>'.

'</tbody></table>';

?>
<div class="mvl clearfix">
	<div class="rfloat">
		<div class="group-btn">
            <?php if( !empty($this->permit['booking']['edit']) || $this->me['id'] == $this->item['sale']['id']  ) { ?>
			<a class="btn" href="<?=URL?>booking/update/<?=$this->item['id']?>/conditions" data-plugins="dialog"><i class="icon-pencil mrs"></i>แก้ไข</a><a class="btn hidden_elem" data-plugins="dropdown" data-options="<?=$this->fn->stringify( array(
                    'select' => array( 0=> 
                        /*array(
                            'text' => 'Export Excel',
                            // 'href' => URL.'customers/status/'.$this->item['id'],
                            'attr' => array('data-plugins'=>'dialog'),
                        ), array(
                            'type' => 'separator',
                        ),*/
                        array(
                            'text' => 'แก้ไข',
                            'href' => URL.'booking/update/'.$this->item['id'].'/conditions',
                            'attr' => array('data-plugins'=>'dialog'),
                        ),

                    ),
                    'settings'=> array(
                    	'axisX' => 'right',
                    )
                    ) )?>"><i class="icon-ellipsis-v"></i>

			</a>
            <?php } ?>
		</div>
	</div>
</div>
