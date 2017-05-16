<div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;overflow-y: hidden;">


	<div style="position: absolute;padding-top: 30px;padding-left: 30px;right: 0;left: 0;background-color: rgba(245,248,250,.98);z-index: 5;max-width: 700px;">
		
		<div class="clearfix" style="max-width: 600px;">

			<div class="lfloat">
				<div style="padding-top: 7px; display: inline-block;">
				<h2>

					<span style="background-color: #fff;border:1px solid #000; width: 30px;height: 30px;text-align: center;line-height: 28px;display: inline-block;border-radius: 50%;color: #333;box-shadow: 0 0 0 1px rgba(255,255,255,.8)">
					<i class="icon-cube mrs"></i>
					</span>

				<span data-text="title">dfddf</span></h2>
				</div>
			</div>

			<!-- <div class="rfloat"> -->
				<!-- <span class="gbtn"><a class="btn" data-global-action="menu"><i class="icon-arrow-left mrs"></i>Hide</a></span> -->
				<!-- <span class="gbtn"><a class="btn btn-red"><i class="icon-remove mrs"></i>Cancel</a></span> -->
			<!-- </div> -->

		</div>
	</div>

	<div style="position: absolute;top: 10px;right: 10px;line-height: 30px;color: #888;font-size: 12px;font-weight: bold;z-index: 10">
		Hide <span class="gbtn"><a class="js-link-back btn" data-global-action="menu"><i class="icon-arrow-right"></i></a></span>
	</div>

	<div style="position: absolute;top: 0;left: 30px;right: 0;bottom: 0;overflow-y: auto;"><div style="padding-top: 65px; max-width: 600px;">

		<div class="">

			<div>
				<ul class="ui-list-detail" role="listsbox">
					<li>
						
					</li>
					<?php for ($i=0; $i < 3; $i++) { ?>
					<li>

						<div class="date">
							<div class="number"><?=$i?></div>
							<div class="control">10.00 - 12.00 PM</div>
						</div>

						<div class="wrap">
						<table class="">
							<tr>
								<td class="label">Masseuse</td>
								<td class="data"><div class="control">
									<div class="avatar lfloat mrs"><img class="img" src="http://localhost/spa_arima/public/uploads/1/87d2c0e7_a783003a6375b106ac9fa59fe388dfc9_a.jpg" alt="Mr.ภุชงค์ สวนแจ้ง"></div> Mr.ภุชงค์ สวนแจ้ง</div>
								</td>
							</tr>
							<tr>
								<td class="label">Room</td>
								<td class="data"><div class="control">F: นวด / Room 101 / Bed 3</div></td>
							</tr>
							<tr>
								<td class="label">Time: </td>
								<td class="data"><div class="control">
									<span class="mrs">1 h</span><i class="icon-pencil"></i></div></td>
							</tr>
							<tr>
								<td class="label">Price</td>
								<td class="data price"><div class="control"><span class="cost">350</span><span class="discount">-50</span><span class="total">300</span><i class="icon-pencil"></i></div></td>
							</tr>
							
							<tr>
								<td class="label">Status</td>
								<td class="data"><span class="ui-status">ORDER</span></td>
							</tr>
							

						</table>
						</div>						

						<!-- <div class="" style="position: absolute; right:  0;bottom: 0">
							<span class="gbtn"><a class="btn btn-red"><i class="icon-remove"></i>Cancel</a></span>
						</div> -->
					</li>
					<?php } ?>
				</ul>

				<div class="pbl">
					<a class="btn btn-large btn-blue js-add-time"><i class="icon-plus mrs"></i><span>Add Time</span></a>
				</div>


			</div>

			<div class="hidden_elem">
				<label class="label">Total Time: </label>

				<div class="data">
					<span>1	TIME</span>
					<span class="duration mll">8:10 PM - 10:10 PM</span>
					<span class="timer mls">30:45:11</span>
				</div>
			</div>

			<div class="hidden_elem">
				<table class="profile-menu-staps">
					<tr>
						<td>
							<label class="label">Total Discount: </label>
							<div class="data">฿350</div>
						</td>
						<td>
							<label class="label">Total Price: </label>
							<div class="data">฿350</div>
						</td>
						<td>
							<label class="label">Time: </label>
							<div class="data"> 1 h</div>
						</td>
						<td>
							<label class="label">Total: </label>
							<div class="data">฿350</div>
						</td>
						<td class="w100">
							
						</td>
					</tr>
				</table>
			</div>


			<!-- <div>
				<label class="label">Note: </label>
				<div><textarea class="inputtext inputnote" data-plugins="autosize"></textarea></div>
			</div> -->

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

		<div class="profile-menu-action clearfix hidden_elem">
			<span class="gbtn"><a class="btn btn-large"><i class="icon-percent mrs"></i><span>Discount</span></a></span>
			<span class="gbtn"><a class="btn btn-red btn-large"><i class="icon-remove mrs"></i><span>Cancel</span></a></span>
		</div>

		<div class="profile-menu clearfix mtl hidden_elem">
			<!-- <div class="lfloat">
				<span class="gbtn"><a class="btn btn-red"><i class="icon-remove mrs"></i>Cancel</a></span>

			</div> -->
			<!-- <div class="rfloat">
				<span class="gbtn radius"><a class="btn btn-blue">Done</a></span>
			</div> -->
		</div>
	</div></div>

</div>