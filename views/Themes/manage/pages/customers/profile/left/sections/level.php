<?php

$a = array();
$a[] = array('label'=>'รหัสสมาชิก', 'key'=> 'code');
$a[] = array('label'=>'ระดับ', 'key' => 'level', 'value'=>'name');
$a[] = array('label'=>'ส่วนลด', 'key'=>'level', 'value'=>'discount');
$a[] = array('label'=>'สถานะ', 'key' => 'status');
// $a[] = array('label'=>'สถานภาพการสมรส', 'key' => 'fullname');

?>
<section class="mbl">
	<header class="clearfix">
		<h2 class="title"><i class="icon-info-circle mrs"></i>ข้อมูลสมาชิก</h2>
		<?php if( $this->has_edit ){ ?>
		<a data-plugins="dialog" href="<?=URL?>customers/edit_cus_level/<?=$this->item['id']?>" class="btn-icon btn-edit"><i class="icon-pencil"></i></a>
		<?php } ?>
	</header>
	
	<table cellspacing="0"><tbody><?php

	foreach ($a as $key => $value) {
		
		if( empty($this->item[ $value['key'] ]) ) continue;

		$val = $this->item[ $value['key'] ];

		if( $val == 'run' ){
			$val = '<div class="status-wrap"><a class="ui-status" style="background-color: rgb(11, 195, 57);">RUN</a></div>';
		}
		elseif( $val == 'expired' ){
			$val = '<div class="status-wrap"><a class="ui-status" style="background-color: rgb(219, 21, 6);">EXPIRED</a>';
		}

		if( $value['key'] == 'level' ){
			$val = $this->item[ $value['key'] ][ $value['value'] ];

			if( $value['value'] == 'discount' ){
				$val .= '%';
			}
		}

		echo '<tr>'.
			'<td class="label">'.$value['label'].'</td>'.
			'<td class="data">'.$val.'</td>'.
		'</tr>';
	}

	if( $this->item['status'] == 'expired' ){
		echo '<tr>'.
		'<td class="label"></td>'.
		'<td class="data"><a data-plugins="dialog" href="'.URL.'customers/set_extend/'.$this->item['id'].'" class="btn btn-green"><i class="icon-plus"></i> ต่ออายุ</a></div></td>'.
		'</tr>';
	}
	?></tbody></table>
					
</section>