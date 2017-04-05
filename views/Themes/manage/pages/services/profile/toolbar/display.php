<?php

$select = array();
foreach ($this->status as $key => $value) {

	if( !empty($this->permit['services']['edit']) || $this->me['id'] == $this->item['emp']['id'] ) 
	{

		if( $value['id']==$this->item['status']['id'] || $value['id'] == 'due' ) continue;

		$url = URL.'services/update/'.$this->item['id'].'/status/'.$value['id'];
		if( $value['id'] == 'finish' ){
			$url .= '?next='.URL.'customers/'.$this->item['cus']['id'].'/repair';
		}

		$select[] = array(
			'text' => $value['name'],
			'href' => $url,
			'attr' => array('data-plugins'=>'dialog'),
		);
	}
}

$options = $this->fn->stringify( array(
    'select' => $select
) );

?>
<div class="profile-toolbar">
	
	<ul class="ProfileToolbar_status">

		<li class="item">
			<label class="label">สถานะ</label>
			<a class="" data-plugins="dropdown" data-options="<?=$options?>"><i class="icon-caret-down"></i></a>
			<div class="data"><?php

			echo '<span class="ui-status-icon mrs" style="background-color:'.$this->item['status']['color'].'"></span><span>' . $this->item['status']['name'].'</span>';
			?></div>
		</li>

		<li class="item"><label class="label">ราคารวมทั้งหมด</label><div class="data"><?=(!empty($this->item['total_price']) ? $this->item['total_price'] : '-')?></div></li>
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