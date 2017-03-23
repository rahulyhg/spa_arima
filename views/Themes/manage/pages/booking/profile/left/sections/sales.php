<?php

$a = array();
$a[] = array('label'=>'ชื่อ', 'key' =>'sale', 'value'=> 'fullname');
$a[] = array('label'=>'เบอร์โทร', 'key' =>'sale', 'value'=> 'phone_number');
$a[] = array('label'=>'Dealer', 'key'=>'dealer', 'value'=>'name');

?>
<section class="mbl">
	<header class="clearfix">
		<h2 class="title"><i class="icon-user-circle-o mrs"></i>พนักงานขาย</h2>
		<a data-plugins="dialog" href="<?=URL?>booking/change_sale/<?=$this->item['id']?>" class="btn-icon btn-edit"><i class="icon-pencil"></i></a>
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