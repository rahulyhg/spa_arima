<?php

$a = array();
$a[] = array('label'=>'เบอร์มือถือ', 'key' => 'phone_number');
$a[] = array('label'=>'Line ID', 'key' => 'line_id');
$a[] = array('label'=>'email', 'key' => 'email');
$a[] = array('label'=>'ที่อยู่', 'key'=>'address');

// $a[] = array('label'=>'จังหวัด', 'key' => 'city_name');
// $a[] = array('label'=>'รหัสไปรษณีย์', 'key'=> 'zip');
	
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

?>
<section class="mbl">
	<header class="clearfix">
		<h2 class="title"><i class="icon-map-marker mrs"></i>ข้อมูลการติดต่อ</h2>
		<?php if( $this->has_edit ){ ?>
		<a data-plugins="dialog" href="<?=URL?><?=$this->obj_type?>/edit_contact/<?=$this->obj_id?>" class="btn-icon btn-edit"><i class="icon-pencil"></i></a>
		<?php } ?>
	</header>
	
	<table cellspacing="0"><tbody><?php

		foreach ($a as $key => $value) {

			if( empty($this->item[ $value['key'] ]) ) continue;

			$label = $value['label'];
			$data = $this->item[ $value['key'] ];

			if( $value['key'] == 'address' ){
				$data = '';
				foreach ($addr as $val) {
					if( empty($this->item['address'][ $val['key'] ]) ) continue;

					$data .= !empty($data) ? ' ':'';
					$data .= !empty($val['label'])? '<span class="fcg mrs">'.$val['label'].'</span>': ' ';
					$data .= $this->item['address'][ $val['key'] ];
				}
			}

			if( !empty($data) ){
				echo '<tr>'.
					'<td class="label">'.$label.'</td>'.
					'<td class="data">'.$data.'</td>'.
				'</tr>';
			}
		}
		?>
	</tbody></table>

</section>