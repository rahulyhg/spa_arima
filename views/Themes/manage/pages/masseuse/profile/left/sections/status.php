<section class="mbl">
	<header class="clearfix">
		<h2 class="title"><i class="icon-server mrs"></i>สถานะ</h2>
	</header>
	
	<table cellspacing="0"><tbody>
		<tr>
			<td class="label">สถานะ</td>
			<td class="data">
				<?php 
				if( $this->item['display'] == 'enabled' ){
					echo '<div class="status-wrap"><span class="ui-status" style="background-color: rgb(11, 195, 57);">Enabled</span></div>';
				}
				else{
					echo '<div class="status-wrap"><span class="ui-status" style="background-color: rgb(219, 21, 6);">Disabled</span>';
				}
				?>
			</td>
		</tr>
	</tbody></table>

</section>