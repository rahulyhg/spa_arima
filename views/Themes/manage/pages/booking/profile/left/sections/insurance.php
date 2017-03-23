<?php

$a = array();
$a[] = array('label'=>'บริษัท', 'key'=>'insurance', 'value'=>'name');
$a[] = array('label'=>'ประเภท', 'key'=>'insurance', 'value'=>'party');
$a[] = array('label'=>'ทุนประกัน', 'key'=>'insurance', 'value'=>'pledge','type'=>'number');
$a[] = array('label'=>'แบบ', 'key'=>'insurance', 'value'=>'sure');
$a[] = array('label'=>'ค่าเบี้ยประกัน', 'key'=>'insurance', 'value'=>'premium', 'type'=>'number');

?>
<section class="mbl">
	<header class="clearfix">
		<h2 class="title"><i class="icon-heart mrs"></i>ประกันภัย</h2>
		<a data-plugins="dialog" href="<?=URL?>booking/update/<?=$this->item['id']?>/insurance" class="btn-icon btn-edit"><i class="icon-pencil"></i></a>
	</header>
	
	<table cellspacing="0"><tbody><?php

		foreach ($a as $key => $value) {

		if( empty($this->item[ $value['key'] ]) ) continue;

		if( isset($value['value']) ){
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
			elseif($value['type']=='birthday'){
				$val = $this->fn->q('time')->birthday($this->item['cus'][ $value['key'] ]);
			}
			elseif($value['type']=='sub'){
				$str = '';
				foreach ($value['options'] as $_val) {
					if( empty($val[ $_val['key'] ]) ) continue;

					$str .= !empty($str) ? ' ':'';
					$str .= !empty($_val['label'])? '<span class="fcg mrs">'.$_val['label'].'</span>': ' ';
					$str .= $val[ $_val['key'] ];
				}

				$val = $str;
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