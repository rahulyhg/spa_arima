<section class="section section-package">

	<header class="section-package-header">
		<form class="">
		<table>
			<tr>
				<td class="prm" style="white-space: nowrap;width: 20px">
					<label>&nbsp;</label>
					<div class="textbox fwb fsxl" ><i class="icon-address-card-o mrs"></i>Queue(5)</div>
				</td>

				<td class="prs">
					<label>Close date</label>
					<select class="inputtext"><option>ล่าสุด</option></select>
				</td>
				
				<td>
					<label>Search:</label>
					<input type="text" class="inputtext input-search" maxlength="100" placeholder="">
				</td>
			</tr>
		</table>
		
		</form>

		
	</header>
	<div class="section-package-content">
		<ul class="ui-list ui-list-orders">

			<?php for ($i=0; $i < 20; $i++) { ?>
			<li class="ui-item ">
				<div class="item-inner clearfix">
					

					<div class="avatar lfloat mrm"><img class="img" src="http://localhost/spa_arima/public/uploads/1/87d2c0e7_a783003a6375b106ac9fa59fe388dfc9_a.jpg" alt="นายภุชงค์ สวนแจ้ง"></div>
					
					<div class="mts">
						<abbr class="rfloat timestamp fcg fsm">9:25</abbr>
						
						<div class="text">
							<span><label>Code:</label> <strong>#00002</strong></span>
							<span><i class="icon-address-card-o"></i>ภุชงค์</span>
						</div>
						
						<div class="subtext clearfix">
							<span><label>Room Number:</label> 101</span>
							<div class="rfloat"><span class="ui-status">RUN</span></div>
						</div>
					</div>
				</div>
			</li>
			<?php } ?>
		</ul>
	</div>
</section>