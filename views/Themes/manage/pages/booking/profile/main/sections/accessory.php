<?php 

$accStr = array( 0=> 
	  array( 'name'=>'รายการที่ซื้อ', 'count'=>0, 'html'=>'', 'total'=>0,  )
	, array( 'name'=>'รายการของแถม', 'count'=>0, 'html'=>'', 'total'=>0, 'minu' => true )
);

// print_r($this->item['accessory']); die;

foreach ($this->item['accessory'] as $key => $value) {

	$accStr[ $value['FOC'] ]['count']++; 
	$accStr[ $value['FOC'] ]['total'] += $value['value'];
	$accStr[ $value['FOC'] ]['html'] .= '<tr>'.
		'<td class="ID">'.$accStr[ $value['FOC'] ]['count'].'.</td>'.
		'<td class="name">'.$value['name'].'</td>'.
		'<td class="price">'. ($value['value']==0 ? '-': number_format($value['value'], 0)).'</td>'.
	'</tr>';

}

$total = 0;
foreach ($accStr as $key => $value) { 

	// if( $value['total']==0 ) continue;

	if( !empty($value['minu']) ){
		$total -= $value['total'];
	}
	else{
		$total += $value['total'];
	}

?>

<table class="table-accessory mvl">
	<thead>
		<tr>
			<th class="ID">#</th>
			<th class="name"><?=$value['name']?></th>
			<th class="price">ราคา</th>
		</tr>
	</thead>
	<?php if( $accStr[ $key ]['count']==0 ){ ?>
	<tbody><tr><td colspan="3" class="td-empty">ไม่มีรายการ</td></tr></tbody>
	<?php }else{ ?>
	<tbody><?=$accStr[ $key ]['html']?></tbody>
	<?php } ?>
	<tfoot>
		<tr>
			<th colspan="2" class="total-text">รวม</th>
			<th class="total-value price"><?= $accStr[ $key ]['total']==0 ? '-': number_format($accStr[ $key ]['total'],0)?></th>
		</tr>
	</tfoot>

</table>
<?php } ?>

<!-- <table class="table-accessory mvl">

	<tfoot>
		<tr>
			<th colspan="2" class="total-text">รวมทั้งหมด</th>
			<th class="total-value price"><?=number_format($total,0)?></th>
		</tr>
	</tfoot>

</table> -->

<div class="mvl clearfix">
	<div class="rfloat">
		<div class="group-btn">
		<?php if( !empty($this->permit['booking']['edit']) || $this->me['id'] == $this->item['sale']['id']  ) { ?>
			<a class="btn"><i class="icon-print mrs"></i>Print</a><a class="btn" data-plugins="dropdown" data-options="<?=$this->fn->stringify( array(
                    'select' => array( 0=> 
                        /*array(
                            'text' => 'Export Excel',
                            'href' => URL.'export/booking/'.$this->item['id'],
                            // 'attr' => array('data-plugins'=>'dialog'),
                        ), array(
                            'type' => 'separator',
                        ),*/
                        array(
                            'text' => 'แก้ไข',
                            'href' => URL.'booking/update/'.$this->item['id'].'/accessory',
                            'attr' => array('data-plugins'=>'dialog'),
                        ),

                    ),

                    'settings'=> array(
                    	'axisX' => 'right',
                    	// 'parent' => '.customers-main'
                    )
                    ) )?>"><i class="icon-ellipsis-v"></i></a>
        <?php } ?>
		</div>
	</div>
</div>