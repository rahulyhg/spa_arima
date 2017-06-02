<div class="slipPaper-container has-bottom">
	<div class="slipPaper-main">
		<div class="slipPaper-content clearfix">
			<div class="slipPaper-bodyHeader">

				<div class="clearfix">
					<div class="lfloat order-title">

						<div>
							<span data-bill="date"><input type="" name="" data-plugins="datepicker"></span>
							
						</div>
						<div class="text">
							<span><label></label> <strong data-bill="number">001, 002, 003</strong> <span class="ui-status vip">V.I.P.</span></span> <span data-bill="member">
							<i class="icon-address-card-o mrm"></i><span class="text" data-bill-set="member">ภุชงค์ สวนแจ้ง</span> <a data-bill-action="remove_member" class="btn-icon"><i class="icon-remove"></i></a>
							</span>
						</div>

					</div>
					<div class="rfloat order-title-btn">
						<span class="gbtn radius"><a class="btn btn-blue" data-bill-action="menu"><i class="icon-plus"></i></a></span>
					</div>
				</div>

			</div>
			<div class="slipPaper-bodyContent" style="padding-top: 29px; top: 85px; bottom: 164px;">
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
				<div class="slipPaper-bodyContent-body" style="top:32px"><table><tbody role="orderlists">
					<?php for ($i=0; $i < 3; $i++) { ?>
					<tr>
						<td class="no"><?=$i?></td>
						<td class="name">
							<div class="title fwb">001 นวดเท้า <span class="ui-status vip">V.I.P.</span> <span class="ui-status coupon">C</span></div>

							<table>
								<?php for ($j=0; $j < 1; $j++) { ?>
								<tr>
									<td class="name">
										<div class="order-title fsm">
											<ul>
												<li><span class="ui-status mrs">2</span>เติ้ล 10.00-11.00</li>
												<!-- <li><span class="ui-status mrs">2</span>เติ้ล 10.00-11.00</li> -->
											</ul>
										</div>
									</td>
									<td class="status">
										<span class="ui-status">RUN</span>
									</td>
									<td class="qty">
										<span class="gbtn"><button class="btn btn-no-padding" data-control="change" data-type="plus_masseuse"><i class="icon-minus"></i></button></span><span class="number">1.30</span><span class="gbtn"><button class="btn btn-no-padding" data-control="change" data-type="remove_masseuse" data-id="46"><i class="icon-plus"></i></button></span>
									</td>
									<td class="unit">Hour</td>
									<td class="price has-discount"><div class="cost">700</div><div class="discount">-100</div><div class="total">600</div></td>
								</tr>
								<?php } ?>
							</table>
						</td>
						
					</tr>
					<?php } ?>
				</tbody></table></div>
			</div>
			<div class="slipPaper-bodyFooter">
				<table class="slipPaper-bodyFooter-summary mbm">
					<tbody><tr>
						<td class="colleft">
							<table><tbody>
								
								<tr>
									<td class="label"><?=$this->lang->translate('Sub Total')?>:</td>
									<td class="data"><span summary="total">0</span> ฿</td>
								</tr>
								<tr>
									<td class="label"><?=$this->lang->translate('Discount')?>:</td>
									<td class="data discount">-<span summary="discount">0</span> ฿</td>
								</tr>
								
								<!-- <tr>
									<td class="label">ภาษี (7%):</td>
									<td class="data">฿<span summary="service-text">0</span></td>
								</tr>
								<tr>
									<td class="label">ค่าบริการ (20%):</td>
									<td class="data">฿<span summary="service-text">0</span></td>
								</tr> -->
							</tbody></table>
						</td>
						<td class="colright">
							<table><tbody>
								

								<tr>
									<td class="label"><?=$this->lang->translate('Drink')?>:</td>
									<td class="data"><span summary="drink">0</span> ฿</td>
								</tr>
								<tr>
									<td class="label"><?=$this->lang->translate('V.I.P. Room')?>:</td>
									<td class="data"><span summary="room_price">0</span> ฿</td>
								</tr>
								<tr>
									<td class="label TOTAL"><?=$this->lang->translate('Total')?>:</td>
									<td class="data TOTAL"><span summary="balance">0</span> ฿</td>
								</tr>
							</tbody></table>
						</td>
					</tr>
				</tbody></table>

				<div class="slipPaper-bodyFooter-actions mvm clearfix">
					<div class="lfloat">
						
						<span class="gbtn"><a class="btn btn-red" data-bill-action="cancel"><i class="icon-remove"></i><span class="text-btn mls"><?=$this->lang->translate('Cancel')?></span></a></span>

						<!-- <span class="gbtn"><a class="btn"><i class="icon-clone" data-bill-action="clone"></i><span class="text-btn mls">Clone</span></a></span> -->
						
						<!-- <span class="gbtn"><a class="btn"><i class="icon-envelope"></i></a></span> -->
					</div>
					<div class="rfloat">

						<!-- <span class="gbtn"><a class="btn" data-bill-action="hold"><i class="icon-arrow-up mrs"></i><?=$this->lang->translate('Hold')?></a></span> -->

						<!-- <span class="gbtn"><a class="btn" data-bill-action="booking"><i class="icon-address-book-o mrs"></i><?=$this->lang->translate('Booking')?></a></span> -->

						<span class="gbtn"><a class="btn btn-blue" data-bill-action="hold"><i class="icon-paper-plane-o mrs"></i><?=$this->lang->translate('Save')?></a></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end: slipPaper main-->

	<footer class="slipPaper-footer">
		
		<nav>
			<ul class="clearfix">
				
				<li class="button">
					<span class="gbtn radius"><a class="btn" data-bill-set="discount"><i class="icon-users"></i></a></span>
					<span class="t">จำนวนลูกค้า</span>
					<span class="countValue">1</span>
				</li>

				<li class="button">
					<span class="gbtn radius"><a class="btn" data-bill-set="drink"><i class="icon-glass"></i></a></span>
					<span class="t"><?=$this->lang->translate('DRINK')?></span>
				</li>

				<!-- <li class="button">
					<span class="gbtn radius"><a class="btn" data-bill-set="vip"><i class="icon-building-o"></i></a></span>
					<span class="t"><?=$this->lang->translate('V.I.P.')?></span>
				</li> -->
				

				<li class="button">
					<span class="gbtn radius"><a class="btn" data-bill-set="member"><i class="icon-address-card-o"></i></a></span>
					<span class="t"><?=$this->lang->translate('Member')?></span>
				</li>
										
				<!-- <li class="button">
					<span class="gbtn radius"><a class="btn" data-bill-set="discount"><i class="icon-percent"></i></a></span>
					<span class="t">Discount</span>
				</li> -->


			</ul>
		</nav>

		<div class="pay button">
			<span class="gbtn radius large"><a class="btn btn-blue" data-bill-action="pay"><i class="icon-thailand-baht"></i></a></span>
			<span class="t">Pay</span>
		</div>
	</footer>
	<!-- end: footer -->
</div>