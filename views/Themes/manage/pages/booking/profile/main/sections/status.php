<div class="mvl">
	<div class="uiBoxYellow pam mbm">
		เลือนเพื่อเปลี่ยนสถานะ
	</div>

	<table class="table-move-status"><tbody>
		<tr>
			
			<?php foreach ($this->status as $key => $value) { ?>
				<th><div class="label"><div class="back"></div><h3><?=$value['name']?></h3></div></li></th>
			<?php } ?>
	 	</tr>

	 	<tr>
	 		
			<?php foreach ($this->status as $key => $value) { 
				echo '<td>';
				if( $this->item['status']['id'] == $value['id'] ){

					echo '<div class="box-status">MG GS 1.5 2WD D (Black top)</div>';
				}
				echo '</td>'; 
			 } ?>
	 		</td>
	 	</tr>

 	</tbody></table>
</div>