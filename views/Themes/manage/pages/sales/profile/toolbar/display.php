<div class="profile-toolbar">
	
	<ul class="ProfileToolbar_status">
		
		<li class="item"><label class="label">ยอดจอง</label><div class="data"><?=(!empty($this->item['total_booking']) ? $this->item['total_booking'] : '-')?></div></li>

		<li class="item"><label class="label">ยอดขาย</label><div class="data"><?=(!empty($this->item['total_finish']) ? $this->item['total_finish'] : '-')?></div></li>

		<li class="item"><label class="label">ยกเลิก</label><div class="data"><?=(!empty($this->item['total_cancel']) ? $this->item['total_cancel'] : '-')?></div></li>


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