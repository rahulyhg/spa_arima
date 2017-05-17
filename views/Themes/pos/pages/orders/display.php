<?php

require 'init.php';

?><div id="mainContainer" class="clearfix hasLeft" data-plugins="main"><div id="order" data-plugins="order" data-options="<?=$this->fn->stringify( array( 
	'lang'=>$this->lang->getCode(),

	// 'date' => '2017-05-07'
) )?>">

	<div role="left" data-w-percent="50">
	<?php 

		$a = array();
		$a[] = array('id'=>'lists','name'=>'');
		$a[] = array('id'=>'bill','name'=>'');
		foreach ($a as $key => $value) {
			
			echo '<div class="ui-effect-top" data-global="'.$value['id'].'">';
			require "sections/{$value['id']}.php";
			echo '</div>';
		}
		 
		// require 'sections/bill.php'; ?>
	</div>

	<div role="content" class="" style="position:relative;">
		

		<div role="main"><?php

		$a = array();
		$a[] = array('id'=>'summary','name'=>'');
		$a[] = array('id'=>'invoice','name'=>'');
		$a[] = array('id'=>'menu','name'=>'');
		$a[] = array('id'=>'detail','name'=>'');
		$a[] = array('id'=>'pay','name'=>'');

		foreach ($a as $key => $value) {
			
			echo '<div class="ui-effect-top" data-global="'.$value['id'].'">';
			require "sections/{$value['id']}.php";
			echo '</div>';
		}


		?></div>
		<!-- end: main -->

	</div>
	<!-- end: content -->

</div></div>