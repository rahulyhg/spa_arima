<div role="toolbar" class="pbs ptl mhl">
	<ul class="ui-list ui-list-horizontal clearfix" ref="actions">
		<li class="ui-item"><h2>Dashboard</h2></li>
		<li class="ui-item plm">
			<div class="uiBoxWhite">
				<select selector="closedate" name="closedate" class="inputtext"></select>
			</div>
		</li>
	</ul>
	 
	<?php if( !empty($this->tabs) ) { ?>
	<nav class="ui-toolbar-toolbar clearfix mtm"><?php
	foreach ($this->tabs as $key => $value) {
		
		$cls = '';
		if( isset($this->tab) ){
			if( $this->tab == $value['id'] ){
				$cls .= 'active';
			}
		}

		$icon = '';
		if( !empty($value['icon']) ){
			$icon = '<i class="icon-'.$value['icon'].' mrs"></i>';
		}

		if( !empty($cls) ){
			$cls = ' class="'.$cls.'"';
		}


		$href = '';
		if( !empty($value['url']) ){
			$href = ' href="'.$value['url'].'"';
		}
		echo '<a'.$cls.' data-action="'.$value['id'].'"'.$href.'>'.$icon.'<span>'.$value['name'].'</span></a>';
	}
	?>
	</nav>
	<?php } ?>
	
</div>