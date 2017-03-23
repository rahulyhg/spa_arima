<?php

$a = array();
$a[] = array('label'=>'Dealer', 'key'=>'dealer', 'value'=>'name',/* 'colspan'=>2*/);
// $a[] = array('label'=>'เล่มที่', 'key'=>'page');
// $a[] = array('label'=>'เลขที่', 'key'=>'number');

?><section class="mbl">
	
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
			}

			$colspan = isset($value['colspan']) ? ' colspan="'.$value['colspan'].'"':'';

			echo '<tr>'.
				( empty($colspan)
					? '<td class="label">'.$value['label'].'</td>'
					: '' 
				).
				'<td class="data"'.$colspan.'>'.$val.'</td>'.
			'</tr>';
		}
	?></tbody></table>
					
</section>