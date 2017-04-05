<?php

$a = array();
$a[] = array('label'=>'จำนวน', 'key'=>'deposit', 'type'=>'number');
$a[] = array('label'=>'ประเภท', 'key' => 'deposit_type' , 'value'=>'name');
$a[] = array('label'=>'ธนาคาร', 'key' => 'deposit_options' , 'value'=>'bank');
$a[] = array('label'=>'สาขา', 'key' => 'deposit_options' , 'value'=>'branch');
$a[] = array('label'=>'เลขที่เช็ค', 'key' => 'deposit_options' , 'value'=>'number');
$a[] = array('label'=>'ลงเช็คเมื่อ', 'key' => 'deposit_options' , 'value'=>'create', 'type'=>'date');

?>
<section class="mbl">
	<header class="clearfix">
		<h2 class="title"><i class="icon-handshake-o mrs"></i>เงินมัดจำ</h2>
		<?php if( !empty($this->permit['booking']['edit']) || $this->me['id'] == $this->item['sale']['id'] ) { ?>
		<a data-plugins="dialog" href="<?=URL?>booking/update/<?=$this->item['id']?>/deposit" class="btn-icon btn-edit"><i class="icon-pencil"></i></a>
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

			echo '<tr>'.
				'<td class="label">'.$value['label'].'</td>'.
				'<td class="data">'.$val.'</td>'.
			'</tr>';
		}
	?></tbody></table>
					
</section>