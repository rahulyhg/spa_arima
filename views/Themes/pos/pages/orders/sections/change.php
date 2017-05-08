<div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;overflow-y: hidden;">


	<div style="position: absolute;padding-top: 30px;padding-left: 30px;right: 0;left: 0;background-color: rgba(245,248,250,.98);z-index: 5;max-width: 700px;">
		
		<div class="clearfix" style="max-width: 600px;">

			<div class="lfloat">
				<div style="padding-top: 7px; display: inline-block;">
				<h2><i class="icon-cube mrs"></i><span data-text="title">SHOWER ROOM</span></h2>
				</div>
			</div>

			<div class="rfloat">
				<span class="gbtn"><a class="btn" data-global-action="menu"><i class="icon-arrow-left mrs"></i>Hide</a></span>
				<!-- <span class="gbtn"><a class="btn btn-red"><i class="icon-remove mrs"></i>Cancel</a></span> -->
			</div>

		</div>
	</div>

	<div style="position: absolute;top: 0;left: 30px;right: 0;bottom: 0;overflow-y: auto;"><div style="padding-top: 65px;padding-bottom: 30px; max-width: 600px;">

		<div class="profile-menu">

			<div>
			<table class="profile-menu-table">
				<thead>
					<tr>
						<th>Room</th>
						<th>Service By</th>
						<th class="time">Time</th>
						<th class="price">Price</th>
						<th class="actions">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php for ($i=0; $i < 3; $i++) { ?>
					<tr>
						<td>101</td>
						<td><div class="anchor clearfix"><div class="avatar lfloat mrm"><img class="img" src="http://localhost/spa_arima/public/uploads/1/87d2c0e7_a783003a6375b106ac9fa59fe388dfc9_a.jpg" alt="นายภุชงค์ สวนแจ้ง"></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">นายภุชงค์ สวนแจ้ง</div><span class="subname">0843635952</span></div></div></div></td>
						<td class="time">
							<div>1 TIME</div>
							<div>8:10 PM - 10:10 PM</div>
						</td>
						<td class="price">350฿</td>
						<td class="actions">
							<span class="gbtn"><a class="btn btn-no-padding"><i class="icon-remove"></i></a></span>
						</td> 
					</tr>
					<?php } ?>
				</tbody>

			</table>

			<div class="tac mts">
				<span class="gbtn"><a class="btn btn-small btn-blue "><i class="icon-plus mrs"></i><span>Add Time</span></a></span>
			</div>
			</div>

			<div>
				<label class="label">Total Time: </label>

				<div class="data">
					<span>1	TIME</span>
					<span class="duration mll">8:10 PM - 10:10 PM</span>
					<span class="timer mls">30:45:11</span>
				</div>
			</div>

			<div>
				<label class="label">Total Price: </label>
				<div class="data">฿350</div>
			</div>

			<div>
				<label class="label">Note: </label>
				<div><textarea class="inputtext inputnote" data-plugins="autosize"></textarea></div>
			</div>

			<!-- <div class="qty">
				<label class="label">Quantity</label>

				<div class="qty-change">
					<table>
						<tbody><tr>
							<td class="b"><span class="gbtn radius"><button type="button" class="btn js-set-qty" data-type="minus"><i class="icon-minus"></i></button></span></td>
							<td><input type="hidden" name="qty" class="total-input" value="79" min="1"><input type="text" name="qty" class="input-number js-qty-text" value="0" min="1"></td>
							<td class="b"><span class="gbtn radius"><button type="button" class="btn js-set-qty" data-type="plus"><i class="icon-plus"></i></button></span></td>
						</tr>
					</tbody></table>
				</div>
			</div> -->
		</div>

		<!-- <div class="profile-menu-action clearfix">
			<span class="gbtn"><a class="btn btn-large">Discount</a></span>
		</div> -->

		<div class="profile-menu clearfix mtl">
			<div class="lfloat">
				<span class="gbtn"><a class="btn btn-red"><i class="icon-remove mrs"></i>Cancel</a></span>

			</div>
			<div class="rfloat">
				<span class="gbtn radius"><a class="btn btn-blue">Done</a></span>
			</div>
		</div>
	</div></div>

</div>