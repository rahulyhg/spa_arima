<?php

switch ($this->item['pay_type']['options']['supply']) {
	case 'ending':
		$this->item['pay_type']['options']['supply'] = '<span class="mls fcg">ปลายงวด</span>';
		break;
	
	default:
		$this->item['pay_type']['options']['supply'] = '<span class="mls fcg">ต้นงวด</span>';
		break;
}
//

if( empty($this->item['pay_type']['options']['interest']) ){
	$this->item['pay_type']['options']['interest'] = '-';
	$this->item['pay_type']['options']['supply'] = '';
}

$a = array();
$a[] = array('label'=>'ประเภท', 'key'=>'pay_type', 'value'=>'name');
$a[] = array('label'=>'บริษัท', 'key'=>'pay_type', 'section'=>'options', 'value'=>'finance_name');
$a[] = array('label'=>'เงินดาวน์', 'key'=>'pay_type', 'section'=>'options', 'value'=>'down_payment_price', 'right'=> !empty($this->item['pay_type']['options']['down_payment_percent']) ? '<span class="mls fcg">'.$this->item['pay_type']['options']['down_payment_percent'].'%</span>':'' );
$a[] = array('label'=>'ดอกเบี้ย', 'key'=>'pay_type', 'section'=>'options', 'value'=>'interest', 'right'=>$this->item['pay_type']['options']['supply']);
$a[] = array('label'=>'ยอดจัด', 'key'=>'pay_type', 'section'=>'options', 'value'=>'finance_amount');
$a[] = array('label'=>'ผ่อนชำระ', 'key'=>'pay_type', 'section'=>'options', 'value'=>'installment', 'right'=>'<span class="mls fcg">เดือน</span>');
$a[] = array('label'=>'	เดือนละ', 'key'=>'pay_type', 'section'=>'options', 'value'=>'pay_monthly', 'right'=>'<span class="mls fcg">บาท</span>');

?>
<section class="mbl">
	<header class="clearfix">
		<h2 class="title"><i class="icon-credit-card mrs"></i>เงื่อนไขการชำระเงิน</h2>
		<a data-plugins="dialog" href="<?=URL?>booking/update/<?=$this->item['id']?>/payment" class="btn-icon btn-edit"><i class="icon-pencil"></i></a>
	</header>
	
	<table cellspacing="0"><tbody><?php

		foreach ($a as $key => $value) {

			if( empty($this->item[ $value['key'] ]) ) continue;

			if( isset($value['section']) && isset($value['value']) ){
				if( empty($this->item[ $value['key'] ][ $value['section'] ][ $value['value'] ]) ) continue;
				$val = $this->item[ $value['key'] ][ $value['section'] ][ $value['value'] ];

			}elseif( isset($value['value']) ){
				if( empty($this->item[ $value['key'] ][ $value['value'] ]) ) continue;

				$val = $this->item[ $value['key'] ][ $value['value'] ];
			}
			else{
				$val = $this->item[ $value['key'] ];
			}

			if( isset($value['type']) ){

				if( $value['type']=='date' ){
					$time = strtotime($val);

					$val = 
						  $this->fn->q('time')->day( date('w', $time), 1 )
						. 'ที่ '
						. date('j', $time)
						. ' '
						. $this->fn->q('time')->month( date('n', $time) )
						. ' '
						. ( date('Y', $time)+543 );
				}
				elseif($value['type']=='number'){
					$val = number_format($val, 0);
					$val = $val==0? '-':$val;
				}
			}

			$right = isset($value['right']) ? $value['right']:'';

			echo '<tr>'.
				'<td class="label">'.$value['label'].'</td>'.
				'<td class="data">'.$val.$right.'</td>'.
			'</tr>';
		}
	?></tbody></table>
					
</section>