<div role="toolbar" class="pbs ptl mhl">
	<ul class="ui-list ui-list-horizontal clearfix">
		<li class="ui-item"><h2>Dashboard</h2></li>
		<li class="ui-item"><select selector="closedate" name="closedate" class="inputtext" onchange="window.location = '<?=URL?>dashboard?period=' + this.value  ">

			<?php 
			$a = array();
			$a[] = array('id'=>'daily','name'=>'วันนี้');
			$a[] = array('id'=>'weekly','name'=>'สัปดาห์นี้');
			$a[] = array('id'=>'monthly','name'=>'เดือนนี้');
			foreach ($a as $key => $value) {
				
				$selected = '';
				if( isset($_GET['period']) ){
					if( $_GET['period']==$value['id'] ){
						$selected = ' selected';
					}
				}
				
				echo '<option'.$selected.' value="'.$value['id'].'">'.$value['name'].'</option>';
			}
			?>
        </select></li>
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