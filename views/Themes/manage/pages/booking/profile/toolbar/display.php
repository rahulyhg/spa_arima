<?php

$select = array();
foreach ($this->status as $key => $value) {

	if( $value['id']==$this->item['status']['id'] ) continue;

	$url = URL.'booking/update/'.$this->item['id'].'/status/'.$value['id'];
	if( $value['id'] == 'finish' ){
		$url .= '?next='.URL.'customers/'.$this->item['cus']['id'].'/cars';
	}

	$select[] = array(
	    'text' => $value['name'],
	    'href' => $url,
	    'attr' => array('data-plugins'=>'dialog'),
	);
}

$options = $this->fn->stringify( array(
    'select' => $select
) );

?>
<div class="profile-toolbar profile-toolbar-mg">
	
	<ul class="ProfileToolbar_status">
		<li class="item">
			<label class="label">สถานะ</label>
			<a class="" data-plugins="dropdown" data-options="<?=$options?>"><i class="icon-caret-down"></i></a>
			<div class="data"><?php

			echo '<span class="ui-status-icon mrs" style="background-color:'.$this->item['status']['color'].'"></span><span>' . $this->item['status']['name'].'</span>';
			?></div>
		</li>
		
		<li class="item"><label class="label">เงื่อนไขการซื้อ</label><div class="data"><?= $this->item['pay_type']['name']?></div></li>

		<li class="item"><label class="label">จำนวนเงินมัดจำ</label><div class="data"><?=number_format($this->item['deposit'], 0)?>฿</div></li>

		<li class="item"><label class="label">รวมค่าอุปกรณ์ตกแต่ง</label><div class="data"><?=number_format($this->item['accessory_price'], 0)?>฿</div></li>

		<li class="item"><label class="label">รวมค่าใช่จ่ายทั้งหมด</label><div class="data"><?=number_format($this->item['net_price'], 0)?>฿</div></li>

	</ul>
		
	<nav class="profile-actions-toolbar clearfix tab-action"><?php

		foreach ($this->tabs as $key => $value) {

			$icon = !empty($value['icon']) ? '<i class="icon-'.$value['icon'].' mrs"></i>':'';
			$active = $value['id']==$this->tab ? ' class="active" ':'';
			echo '<a'.$active.' data-action="'.$value['id'].'">'.$icon.'<span>'.$value['name'].'</span></a>';
		}

	?>
	</nav>
</div>