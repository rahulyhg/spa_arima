<div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;overflow-y: hidden;">


	<!-- <div style="position: absolute;padding-top: 30px;padding-left: 30px;right: 0;left: 0;background-color: rgba(0, 144, 195,.98);z-index: 5;max-width: 700px;">

	</div> -->

	<div style="position: absolute;top: 10px;right: 30px;line-height: 30px;color: #fff;font-size: 80%;font-weight: bold;z-index: 10">
		<span class="gbtn radius"><a class="btn" data-global-action="menu"><i class="icon-arrow-right"></i></a></span>
	</div>

	<div class="profile-menu" style="position: absolute;top: 0;left: 30px;right: 0;bottom: 0;overflow-y: auto;"><div style="padding-top: 0">

		<div class="clearfix" style="max-width: 600px;">
			<div class="lfloat">
				<div style="padding-top: 7px; display: inline-block;">
				<h2>

					<span style="background-color: #fff;border:1px solid #000; width: 30px;height: 30px;text-align: center;line-height: 28px;display: inline-block;border-radius: 50%;color: #333;box-shadow: 0 0 0 1px rgba(255,255,255,.8)">
						<i class="icon-cube mrs"></i>
					</span>

				<span data-text="title" style="color: #fff">Title</span></h2>
				</div>
			</div>
		</div>

		<div class="clearfix mvm">
			<div class="pic lfloat mrl" style="width: 170px;height: 170px;background-color: #fff">
				<img src="">
			</div>
			<div style="overflow:hidden;">
				<table class="table-info"><tbody>
					<tr>
						<td class="label">เวลา</td>
						<td class="price">1</td>
						<td class="uint">Hour</td>
					</tr>
					<tr>
						<td class="label">ราคา</td>
						<td class="price">350</td>
						<td class="uint">฿</td>
					</tr>
					<tr>
						<td class="label">ส่วนลด (โปรโมชั่น)</td>
						<td class="price">-0</td>
						<td class="uint">฿</td>
					</tr>
					<tr>
						<td class="label">ค่าห้อง (V 3-1)</td>
						<td class="price">0</td>
						<td class="uint">฿</td>
					</tr>
					<tr>
						<td class="label">รวมทั้งหมด</td>
						<td class="price">350</td>
						<td class="uint">฿</td>
					</tr>
				</tbody></table>
			</div>
		</div>

		<div class="qty mvm">
			<label class="mrl">เวลา</label>
			<div class="qty-change">
				<table>
					<tbody><tr>
						<td class="b"><span class="gbtn radius"><button type="button" class="btn js-set-qty" data-type="minus"><i class="icon-minus"></i></button></span></td>
						<td class="tac">	
							<div class="input-number"><span class="value">1.30</span><span class="unit">Hour</span></div>
							<div class="fsm">09.30 - 10.30</div>
						</td>
						<td class="b"><span class="gbtn radius"><button type="button" class="btn js-set-qty" data-type="plus"><i class="icon-plus"></i></button></span></td>
					</tr>
				</tbody></table>
			</div>
		</div>

		<div class="masseuse clearfix mvm">
			<div class="mbs">พนง.ผู้บริการ</div>
			
			<div class="list-masseuse-warp has-many">
				<ul class="list-masseuse">
					<?php for ($i=1; $i <= 2; $i++) { ?>
					<li>
						
						<div class="number">001</div>

						<ul class="ui-list-masseuse" style="max-width: 550px">

							<!-- <li><span class="ui-status mrm">5</span><a class="control" data-control="change" data-type="masseuse" data-id="46"><div class="avatar lfloat mrs"><img src="http://localhost/spa_arima/public/uploads/1/87d2c0e7_4d1cfe823b002a78fdd6c8bbfebd07ae_a.jpg"></div><span class="">เมย์</span></a> <span class="time">10.00-11.00</span> <div class="actions"><span class="gbtn"><button class="btn btn-no-padding" data-control="change" data-type="masseuse" data-id="46"><i class="icon-retweet"></i></button></span><span class="gbtn"><button class="btn btn-no-padding" data-control="change" data-type="plus_masseuse"><i class="icon-plus"></i></button></span><span class="gbtn"><button class="btn btn-no-padding" data-control="change" data-type="remove_masseuse" data-id="46"><i class="icon-remove"></i></button></span></div></li>

							<li><span class="ui-status mrm">5</span><a class="control" data-control="change" data-type="masseuse" data-id="46"><div class="avatar lfloat mrs"><img src="http://localhost/spa_arima/public/uploads/1/87d2c0e7_4d1cfe823b002a78fdd6c8bbfebd07ae_a.jpg"></div><span class="">ภุชงค์ สวนแจ้ง</span></a> <span class="time">10.00-11.00</span><div class="actions"><span class="gbtn"><button class="btn btn-no-padding" data-control="change" data-type="masseuse" data-id="46"><i class="icon-retweet"></i></button></span><span class="gbtn"><button class="btn btn-no-padding" data-control="change" data-type="plus_masseuse"><i class="icon-plus"></i></button></span><span class="gbtn"><button class="btn btn-no-padding" data-control="change" data-type="remove_masseuse" data-id="46"><i class="icon-remove"></i></button></span></div></li> -->

						</ul>

						<div class="mvm"><span class="gbtn"><a class="btn">+ เพิ่มหมอ</a></span></div>
						
					</li>
					<?php } ?>
				</ul>

			</div>
			
		</div>

		<div class="profile-menu-action mvl"><ul class="clearfix">
			<li><span class="gbtn"><a class="btn btn-large"><span>ส่วนลด</span></a></span></li>
			<li><span class="gbtn"><a class="btn btn-large"><span>V.I.P Room</span></a></span></li>
			<li><span class="gbtn"><a class="btn btn-large"><span>คูปอง</span></a></span></li>
			<li><span class="gbtn"><a class="btn btn-red btn-large"><i class="icon-remove mrs"></i><span>ยกเลิก</span></a></span></li>
		</ul></div>


		<div class="note mvl clearfix">
			<label>หมายเหตุ</label>

			<div class="note-wrap mtm">
				<textarea class="textinput "></textarea>
			</div>
		</div>
		
	</div></div>

</div>