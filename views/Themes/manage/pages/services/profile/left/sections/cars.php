<?php

$a = array();
$a[] = array('label'=>'Model', 'key'=>'model', 'value'=>'name');
$a[] = array('label'=>'รุ่น', 'key' => 'pro' , 'value'=>'name');
$a[] = array('label'=>'เลขเครื่องยนต์', 'key' => 'car' , 'value'=>'engine');
$a[] = array('label'=>'เลขตัวถัง', 'key' => 'car' , 'value'=>'VIN');
$a[] = array('label'=>'สี', 'key'=>'car', 'value'=>'color_text');
$a[] = array('label'=>'ป้ายทะเบียน', 'key'=>'car', 'value'=>'plate');
$a[] = array('label'=>'ป้ายแดง', 'key'=>'car', 'value'=>'red_plate');

?>
<section class="mbl">
	<header class="clearfix">
		<h2 class="title"><i class="icon-car mrs"></i>ข้อมูลรถยนต์</h2>
		
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
			}

			$right = isset($value['right']) ? $value['right']:'';

			echo '<tr>'.
				'<td class="label">'.$value['label'].'</td>'.
				'<td class="data">'.$val.$right.'</td>'.
			'</tr>';
		}
	?></tbody></table>
					
</section>