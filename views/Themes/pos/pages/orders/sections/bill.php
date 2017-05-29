<div class="slipPaper-container has-bottom">
	<div class="slipPaper-main">
		<div class="slipPaper-content clearfix">
			<div class="slipPaper-bodyHeader">

				<div class="clearfix">
					<div class="lfloat order-title">

						<div><span data-bill="date"></span></div>
						<div class="text">
							<span><label></label> <strong data-bill="number"></strong></span>
						</div>

						<!-- <div class="subtext">
							<span><label>Time:</label> 8:10 PM</span>
							<span><label>-</label> 10:10 PM</span>
							<span> 30:45:11</span>
						</div> -->

						<div class="subtext hidden_elem" data-bill="member">
							<span><label>Member:</label> <i class="icon-address-card-o mrs"></i><span class="text" data-bill-set="member"></span> <a data-bill-action="remove_member" class="btn-icon"><i class="icon-remove"></i></a></span>
						</div>
						<!-- <div class="subtext">
							<span><label>Room No.</label> 101</span>
						</div>
						<div class="subtext">
							<span><label>By:</label> <i class="icon-user-circle-o"></i><a>ภุชงค์</a></span>
						</div> -->
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
							<th class="name">Items</th>
							<th class="status"></th>
							<th class="qty">Time</th>
							<th class="unit"></th>
							<th class="price">Price</th>
						</tr>
					</tbody></table>
				</div>
				<div class="slipPaper-bodyContent-body"><table><tbody role="orderlists"></tbody></table></div>
			</div>
			<div class="slipPaper-bodyFooter">
				<table class="slipPaper-bodyFooter-summary mbm">
					<tbody><tr>
						<td class="colleft">
							<table><tbody>
								
								<tr>
									<td class="label"><?=$this->lang->translate('Total')?>:</td>
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
									<td class="label TOTAL"><?=$this->lang->translate('Balance')?>:</td>
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

						<span class="gbtn"><a class="btn btn-blue" data-bill-action="hold"><i class="icon-paper-plane-o mrs"></i><?=$this->lang->translate('Order')?></a></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end: main-->

	<footer class="slipPaper-footer">
		
		<nav>
			<ul class="clearfix" style="width:800px">
				
				<li class="button">
					<span class="gbtn radius"><a class="btn" data-bill-set="drink"><i class="icon-glass"></i></a></span>
					<span class="t"><?=$this->lang->translate('DRINK')?></span>
				</li>

				<li class="button">
					<span class="gbtn radius"><a class="btn" data-bill-set="vip"><i class="icon-building-o"></i></a></span>
					<span class="t"><?=$this->lang->translate('V.I.P.')?></span>
				</li>
				

				<li class="button">
					<span class="gbtn radius"><a class="btn" data-bill-set="member"><i class="icon-address-card-o"></i></a></span>
					<span class="t"><?=$this->lang->translate('Member')?></span>
				</li>
										
				<!-- <li class="button">
					<span class="gbtn radius"><a class="btn js-set-option" data-type=""><i class="icon-percent"></i></a></span>
					<span class="t">Discount</span>
				</li> -->

				<!-- <li class="button">
					<span class="gbtn radius"><a class="btn" data-bill-set="masseuse"><i class="icon-user-circle-o"></i></a></span>
					<span class="t"><?=$this->lang->translate('Masseuse')?></span>
				</li> -->

				<!-- <li class="button">
					<span class="gbtn radius"><a class="btn" data-bill-set="room"><i class="icon-bed"></i></a></span>
					<span class="t"><?=$this->lang->translate('Room')?>/<?=$this->lang->translate('Bed')?></span>
				</li> -->

			</ul>
		</nav>

		<!-- <div class="pay button">
			<span class="gbtn radius large"><a class="btn btn-blue" data-bill-action="pay"><i class="icon-thailand-baht"></i></a></span>
			<span class="t">Pay</span>
		</div> -->
	</footer>
	<!-- end: footer -->
</div>