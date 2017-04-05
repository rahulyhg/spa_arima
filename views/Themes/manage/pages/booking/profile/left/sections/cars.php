<?php

$a = array();
$a[] = array('label'=>'Model', 'key'=>'model', 'value'=>'name');
$a[] = array('label'=>'รุ่น', 'key' => 'product' , 'value'=>'name');
$a[] = array('label'=>'เครื่องยนต์', 'key' => 'product' , 'value'=>'cc', 'right'=>' cc');
$a[] = array('label'=>'ปี', 'key' => 'product' , 'value'=>'mfy');
$a[] = array('label'=>'สี', 'key'=>'color', 'value'=>'name');
$a[] = array('label'=>'ราคา', 'key'=>'product', 'value'=>'price', 'type'=>'number');

?>
<section class="mbl">
	<header class="clearfix">
		<h2 class="title"><i class="icon-car mrs"></i>รถยนต์ที่จอง</h2>
		<?php 
		if( !empty($this->permit['booking']['edit']) || $this->me['id'] == $this->item['sale']['id'] ){
		?>
		<a data-plugins="dialog" href="<?=URL?>booking/update/<?=$this->item['id']?>/car" class="btn-icon btn-edit"><i class="icon-pencil"></i></a>
		<?php } ?>
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