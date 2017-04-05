<?php


// $a[] = array('label'=>'สถานภาพการสมรส', 'key' => 'fullname');
$a = array();
$a[] = array('label'=>'รุ่นรถ', 'key' => 'total_price');
$a[] = array('label'=>'ชื่อเล่น', 'key' => 'nickname');
$a[] = array('label'=>'บัตรประชาชน', 'key' => 'card_id');


?>
<section class="mbl">
	<header class="clearfix">
		<h2 class="title"><i class="icon-address-card-o mrs"></i>ข้อมูลรถ</h2>
		<?php 

		if( !empty($this->permit['sales']['del']) || $this->item['id']==$this->me['id'] ){
			echo '<a data-plugins="dialog" href="'.URL.'employees/edit_basic/'.$this->item['id'].'" class="btn-icon btn-edit"><i class="icon-pencil"></i></a>';
		}
		?>
	</header>
	
	<table cellspacing="0"><tbody><?php

	foreach ($a as $key => $value) {
		
		if( empty($this->item[ $value['key'] ]) ) continue;

		
		if($value['key']=='birthday'){
			$val =  $this->fn->q('time')->birthday($this->item[ $value['key'] ]);
                       
		}
		else{
			$val = $this->item[ $value['key'] ];
		}
		echo '<tr>'.
			'<td class="label">'.$value['label'].'</td>'.
			'<td class="data">'.$val.'</td>'.
		     '</tr>';
	}
	?></tbody></table>
					
</section>