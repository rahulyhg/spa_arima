<?php 

$income = 0;
$income_tatol = 0;
$deposit = 0;

$tr = array('income'=>'', 'less'=>'');
foreach ($this->conditions as $key => $value) {

	
    $type = 'less';
    $dataname = '';
    $cls = 'inputtext js-number';

    if( !empty($value['keyword']) ){
        $dataname = 'summary="'.$value['keyword'].'" data-name="'.$value['keyword'].'"';
    }

    if( !empty($value['has_lock']) ){
        $cls .= ' disabled is-lock';
    }

    if( !empty( $value['income'] ) ){
    	$income++;
        $type = 'income';
        $no = $income;
    }
    else{
    	$deposit++;
    	$no = $deposit;
    }


    $tr[$type] .= '<tr'.( !empty($value['id']) ? ' data-id="'.$value['id'].'"':'' ).'>'.
        '<td class="ID">'.$no.'.</td>'.
        '<td class="name">'.$value['name'].'</td>'.
        '<td class="price"></td>'.
        // '<td class="baht">บาท/baht</td>'.
    '</tr>';

}

echo '<table class="mtl table-accessory"><tbody>'.
	

    '<tbody class="income">'. $tr['income']. '</tbody>'.

    '<tfoot><tr>'.
		'<th colspan="2" class="total-text">รวมค่าใช้จ่าย</th>'.
		'<th class="total-value price">-</th>'.
	'</tr></tfoot>'.

'</tbody></table>';

echo '<table class="mtl table-accessory"><tbody>'.

    '<tbody class="income">'. $tr['less']. '</tbody>'.

    '<tfoot><tr>'.
		'<th colspan="2" class="total-text">รวมค่าใช้จ่ายทั้งสิ้น</th>'.
		'<th class="total-value price">-</th>'.
	'</tr></tfoot>'.

'</tbody></table>';

?>
<div class="mvl clearfix">
	<div class="rfloat">
		<div class="group-btn">
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
		</div>
	</div>
</div>
