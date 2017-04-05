<?php

$a = array();
$a[] = array('label'=>'ชื่อ', 'key'=>'tec', 'value'=>'fullname');
$a[] = array('label'=>'เบอร์โทร', 'key' => 'tec' , 'value'=>'phone_number');
$a[] = array('label'=>'E-mail', 'key' => 'tec' , 'value'=>'email');
$a[] = array('label'=>'LineID', 'key' => 'tec' , 'value'=>'line_id');

$addr = array();
$addr[] = array('label'=>'บ้านเลขที่','key'=>'number');
$addr[] = array('label'=>'หมู่','key'=>'mu');
$addr[] = array('label'=>'หมู่บ้าน','key'=>'village');
$addr[] = array('label'=>'ซอย','key'=>'alley');
$addr[] = array('label'=>'ถนน','key'=>'street');
$addr[] = array('label'=>'แขวง/ตำบล','key'=>'district');
$addr[] = array('label'=>'เขต/อำเภอ','key'=>'amphur');
$addr[] = array('label'=>'จังหวัด','key'=>'city_name');
$addr[] = array('label'=>'','key'=>'zip');
$a[] = array('label'=>'ที่อยู่', 'key' => 'tec', 'value'=>'address', 'type'=>'sub', 'options'=>$addr);


?>
<section class="mbl">
	<header class="clearfix">
		<h2 class="title"><i class="icon-cogs mrs"></i>ข้อมูลช่างซ่อม</h2>
		<?php if( !empty($this->permit['services']['edit']) || $this->me['id'] == $this->item['emp']['id'] ) { ?>
		<a data-plugins="dialog" href="<?=URL?>services/update/<?=$this->item['id']?>/tec" class="btn-icon btn-edit"><i class="icon-pencil"></i></a>
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