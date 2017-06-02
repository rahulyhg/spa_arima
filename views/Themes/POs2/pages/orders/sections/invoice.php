<div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;">

<div style="position: absolute;top: 10px;right: 10px;line-height: 30px;color: #888;font-size: 12px;font-weight: bold;z-index: 10">
	Hide <span class="gbtn"><a class="js-link-back btn" data-global-action="summary"><i class="icon-arrow-right"></i></a></span>
</div>

<div style="position: absolute;top: 0;left: 0;right: 100px;bottom: 0;">
<div class="slipPaper-container">
	<div class="slipPaper-main">
		<div class="slipPaper-content clearfix">

			<div class="slipPaper-bodyHeader">
				<div class="clearfix">

					<div class="lfloat order-title">
						<div><span data-invoice="date"></span></div>
						<div class="text">
							<span><label>ลำดับที่</label> <strong data-invoice="number"></strong></span>

							<span data-invoice="status"></span>
							<span class="ui-status vip" data-invoice="vip">V.I.P.</span>
							<span class="ui-status coupon" data-invoice="coupon">C</span>
						</div>

						<div class="subtext hidden_elem" data-invoice="member">
							<span><label>สมาชิก:</label> <i class="icon-address-card-o mrs"></i><span class="text" data-invoice-set="member"></span> <a data-invoice-action="remove_member" class="btn-icon"><i class="icon-remove"></i></a></span>
						</div>
						
					</div>
					<div class="rfloat tar">
						<div data-invoice="itmelive" class="tableTime-text fsm fwn"></div>
						<!-- <span class="ui-status" data-invoice="status">RUN</span> -->
					</div>
				</div>	
			</div>
			<div class="slipPaper-bodyContent" style="padding-top: 29px; top: 70px; bottom: 140px;">
				<div class="slipPaper-bodyContent-header">
					<table>
						<tbody><tr>
							<th class="no">#</th>
							<th class="name">รายการ</th>
							<th class="status"></th>
							<th class="qty">เวลา</th>
							<th class="unit"></th>
							<th class="price">ราคา</th>
						</tr>
					</tbody></table>
				</div>
				<div class="slipPaper-bodyContent-body"><table><tbody role="orderlists"></tbody></table></div>
			</div>
			<div class="slipPaper-bodyFooter">
				<table class="slipPaper-bodyFooter-summary mvm">
					<tbody><tr>
						<td class="colleft">
							<table><tbody>
								
								
								<tr>
									<td class="label">ส่วนลด(รายการ):</td>
									<td class="data discount">-<span summary="discount">0</span> ฿</td>
								</tr>
								<tr>
									<td class="label">ส่วนลด(สมาชิก 10%):</td>
									<td class="data discount">-<span summary="discount">0</span> ฿</td>
								</tr>

								<!-- <tr>
									<td class="label">ส่วนลด(คูปอง):</td>
									<td class="data discount">-<span summary="discount">0</span> ฿</td>
								</tr> -->

								<tr>
									<td class="label"><?=$this->lang->translate('Drink')?>:</td>
									<td class="data"><span summary="drink">0</span> ฿</td>
								</tr>
								<tr>
									<td class="label"><?=$this->lang->translate('ค่าห้อง V.I.P')?>:</td>
									<td class="data"><span summary="room_price">0</span> ฿</td>
								</tr>
								
							</tbody></table>
						</td>
						<td class="colright">
							<table><tbody>
								<tr>
									<td class="label">รวม:</td>
									<td class="data"><span summary="total">0</span> ฿</td>
								</tr>
								<tr>
									<td class="label">รวมหัก:</td>
									<td class="data discount">-<span summary="discount">0</span> ฿</td>
								</tr>
								<tr>
									<td class="label TOTAL">รวมทั้งหมด:</td>
									<td class="data TOTAL"><span summary="balance">0</span> ฿</td>
								</tr>
								
								<tr>
									<td class="label balance">รับเงิน(สด):</td>
									<td class="data"><span summary="pay">0</span> ฿</td>
								</tr>
								<tr>
									<td class="label balance">ทอน:</td>
									<td class="data"><span summary="change">0</span> ฿</td>
								</tr>
							</tbody></table>
						</td>
					</tr>
				</tbody></table>
				<div class="slipPaper-bodyFooter-actions mvm clearfix">
					<div class="lfloat">
						
						<span class="gbtn"><a class="btn btn-red" data-invoice-action="remove"><i class="icon-remove"></i><span class="text-btn mls">ลบรายการ</span></a></span>

						<!-- <span class="gbtn"><a class="btn"><i class="icon-clone" data-invoice-action="clone"></i><span class="text-btn mls">Clone</span></a></span> -->
						
						<!-- <span class="gbtn"><a class="btn"><i class="icon-envelope"></i></a></span> -->
					</div>
					<div class="rfloat">
						<!-- <span class="gbtn"><a class="btn" data-invoice-action="hold"><i class="icon-arrow-up mrs"></i>ปิด</a></span> -->

						<!-- <span class="gbtn"><a class="btn" data-invoice-action="booking"><i class="icon-address-book-o mrs"></i>Booking</a></span> -->

						<!-- <span class="gbtn"><a class="btn btn-blue" data-invoice-action="hold"><i class="icon-paper-plane-o mrs"></i>Order</a></span> -->
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- end: slipPaper-main -->

	<footer class="slipPaper-footer">
		
		<nav>
			<ul class="clearfix" style="width:800px">
				
				<li class="button">
					<span class="gbtn radius"><a class="btn" data-invoice-action="drink"><i class="icon-glass"></i></a></span>
					<span class="t"><?=$this->lang->translate('DRINK')?></span>
				</li>

				<li class="button">
					<span class="gbtn radius"><a class="btn" data-invoice-action="vip"><i class="icon-building-o"></i></a></span>
					<span class="t"><?=$this->lang->translate('V.I.P.')?></span>
				</li>

				<li class="button">
					<span class="gbtn radius"><a class="btn" data-invoice-action="member"><i class="icon-address-card-o"></i></a></span>
					<span class="t"><?=$this->lang->translate('Member')?></span>
				</li>

				<li class="button">
					<span class="gbtn radius">
						<a class="btn" data-invoice-action="coupon"><i class="icon-credit-card"></i></a>
					</span>
					<span class="t">คูปอง</span>
				</li>

			</ul>
		</nav>

		<div class="pay button">
			<span class="gbtn radius large"><a class="btn btn-blue" data-invoice-action="pay"><i class="icon-thailand-baht"></i></a></span>
			<span class="t">Pay</span>
		</div>
	</footer>
</div>
</div>

<div style="position: absolute;width: 100px;right: 0;top: 50px;bottom: 30px;">

	<ul class="ui-list">

		<li class="mbm tac">
			<div class="gbtn radius">
				<a class="btn" data-invoice-action="edit"><i class="icon-pencil"></i></a>
			</div>
			<div class="mts des-text">แก้ไข</div>
		</li>
		
	</ul>

	<ul class="bottom" style="position: absolute;bottom: 0;left: 0;right: 0">

	</ul>
	
</div>

</div>