<?php

?>
<div class="profile-toolbar">
	
	<ul class="ProfileToolbar_status">
		
		<li class="item"><label class="label">ยอดจอง</label><div class="data">-</div></li>

		<li class="item"><label class="label">ถอนจอง</label><div class="data">-</div></li>

		<li class="item"><label class="label">ส่งหมอบ</label><div class="data">-</div></li>


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