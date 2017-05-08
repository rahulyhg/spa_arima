<section class="section section-package">

	<header class="section-package-header">
		<form class="">
		<table>
			<tr>
				<td class="prm" style="white-space: nowrap;width: 20px">
					<label>&nbsp;</label>
					<div class="textbox fwb fsxl"><i class="icon-list-ol mrs"></i>Queue</div>
				</td>

				<!-- <td class="prs">
					<label>Close date</label>
					<select class="inputtext"><option>ล่าสุด</option></select>
				</td>
				
				<td>
					<label>Search:</label>
					<input type="text" class="inputtext input-search" maxlength="100" placeholder="">
				</td> -->
			</tr>
		</table>
		
		</form>

		
	</header>
	<div class="section-package-content">
		
		<div class="queue-wrap" data-plugins="jopQueue">
		<ul class="ui-list ui-list-queue" rel="listsbox"><?php 

			for ($i=0; $i < 50; $i++) { 
			?><li><div class="inner">
				<div class="number"><?=$i?></div>
				<div class="box"><div class="box-inner">
					<div class="avatar no-avatar"><div class="initials"><?=sprintf("%03d", $i)?></div></div>

					<div class="box-content">
						<!-- <h3>101</h3> -->
						<div class="name">ภุชงค์ ชื่อยาวววววววววววววววววววววววววววววววววววววววววววววววววววววววว</div>
					</div>
					
				</div></div>
			</div></li><?php 
			} 
		?></ul>
		</div>
	</div>
</section>