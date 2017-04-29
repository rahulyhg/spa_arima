<div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;overflow-y: hidden;">


	<div style="position: absolute;padding-top: 30px;padding-left: 30px;right: 0;left: 0;background-color: rgba(245,248,250,.98);z-index: 5;max-width: 700px;">
		
		<div class="clearfix" style="max-width: 600px;">

			<div class="lfloat">
				<h2><i class="icon-address-book-o mrs"></i><span>00001</span> <a class="ui-status" style="background-color: rgb(219, 21, 6);">Booking</a></h2>

			</div>

			<div class="rfloat">
				<span class="gbtn"><a class="btn"><i class="icon-pencil mrs"></i>Edit</a></span>
				<!-- <span class="gbtn"><a class="btn btn-red"><i class="icon-remove mrs"></i>Cancel</a></span> -->
			</div>

		</div>
	</div>

	<div style="position: absolute;top: 0;left: 30px;right: 0;bottom: 0;overflow-y: auto;"><div style="padding-top: 65px;padding-bottom: 30px; max-width: 600px;">

		<div class="profile-menu">

			<div>
				<label class="label">Member:</label>

				<div class="anchor clearfix"><div class="avatar lfloat mrm"><img class="img" src="http://localhost/spa_arima/public/uploads/1/87d2c0e7_a783003a6375b106ac9fa59fe388dfc9_a.jpg" alt="นายภุชงค์ สวนแจ้ง"></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">นายภุชงค์ สวนแจ้ง</div><span class="subname">0843635952</span></div></div></div>
			</div>

			<div>
				<label class="label">Date:</label>
				
				<div class="data">
					<span><?=date('l, j F, Y')?></span>
					<span class="duration mll">8:00PM - 10:00PM</span>
				</div>
			</div>

			<div>
			<label class="label">Package:</label>
			<table class="profile-menu-table">
				

				<thead>
					<tr>
						<th colspan="5">AKASURI</th>
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

				<thead>
					<tr>
						<th colspan="5">AKASURI</th>
					</tr>
				</thead>

				<tbody>
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
				</tbody>
			</table>

			</div>

			<div>
				<label class="label">Total Price: </label>
				<div class="data">฿350</div>
			</div>

			<div>
				<label class="label">Note: </label>
				<div>sdfsf sfsdfsdfsd</div>
			</div>

		</div>

		<!-- <div class="profile-menu-action clearfix">
			<span class="gbtn"><a class="btn btn-large">Discount</a></span>
		</div> -->

		<div class="clearfix mtl">
			<div class="lfloat">
				<span class="gbtn"><a class="btn btn-red"><i class="icon-remove mrs"></i>Cancel</a></span>

			</div>
			<div class="rfloat">
				<span class="gbtn"><a class="btn btn-blue"><i class="icon-sign-in mrs"></i>Check In</a></span>
			</div>
		</div>
	</div></div>

</div>