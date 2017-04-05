<?php 

$tr = '';
$no = 0;
$total_price = 0;
foreach ($this->item['options'] as $key => $value) {
	$no++;
	$total_price = $total_price + $value['value'];
	$tr .= '<tr>'.
        '<td class="ID">'.$no.'.</td>'.
        '<td class="name">'.$value['name'].'</td>'.
        '<td class="price">'. ($value['value']==0 ? '-': number_format($value['value'],0) ) .'</td>'.
        // '<td class="baht">บาท/baht</td>'.
    '</tr>';
}

echo '<table class="mtl table-accessory"><tbody>'.
	

    '<tbody class="income">'. $tr. '</tbody>'.

    '<tbody><tr>'.
		'<th colspan="2" class="total-text">รวมค่าใช้จ่าย</th>'.
		'<th class="total-value price">'. number_format( $total_price, 0) .'</th>'.
	'</tr></tbody>'.

'</tbody></table>';

?>
<!-- <div class="mvl clearfix">
	<div class="rfloat">
		<div class="group-btn">
			<a class="btn" href="<?=URL?>services/update/<?=$this->item['id']?>/options" data-plugins="dialog"><i class="icon-pencil mrs"></i>แก้ไข</a><a class="btn hidden_elem" data-plugins="dropdown" data-options="<?=$this->fn->stringify( array(
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
                            'href' => URL.'services/update/'.$this->item['id'].'/options',
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
</div> -->
