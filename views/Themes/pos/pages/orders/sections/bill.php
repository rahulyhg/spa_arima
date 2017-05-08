<div class="slipPaper-container has-bottom">
	<div class="slipPaper-main">
		<div class="slipPaper-content clearfix">
			<div class="slipPaper-bodyHeader">

				<div class="clearfix">
					<div class="orderID"><span header="code"></span></div>
					<div class="lfloat order-title">
						<div class="text">
							<span><label>Date:</label> <span><?=Date('j F Y')?></span></span>
							<span><label>No.</label> <strong data-title="number"></strong></span>
						</div>

						<!-- <div class="subtext">
							<span><label>Time:</label> 8:10 PM</span>
							<span><label>-</label> 10:10 PM</span>
							<span> 30:45:11</span>
						</div> -->

						<!-- <div class="subtext">
							<span><label>Member:</label> <i class="icon-address-card-o"></i><span>ภุชงค์ 08436359502</span></span>
						</div> -->
						<!-- <div class="subtext">
							<span><label>Room No.</label> 101</span>
						</div>
						<div class="subtext">
							<span><label>By:</label> <i class="icon-user-circle-o"></i><a>ภุชงค์</a></span>
						</div> -->
						
					</div>
					<div class="rfloat">
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
							<th class="time">Time</th>
							<th class="unittime"></th>
							<th class="price">Price</th>
						</tr>
					</tbody></table>
				</div>
				<div class="slipPaper-bodyContent-body"><table><tbody role="orderlists">
					<?php for ($i=0; $i < -1; $i++) { ?>
					<tr>
						<td class="no">1.</td>
						<td class="name">
							<div class="title">
								<strong>SHOWER ROOM</strong>
								<span class="ui-status">50%</span>
							</div>
							<div class="order-title fsm">
								<span><label>Room: </label> 101</span>
								<span><label>By:</label> <i class="icon-user-circle-o"></i>ภุชงค์</span>
							</div>
						</td>
						<td class="time">1</td>
						<td class="unittime">TIME</td>
						<td class="price has-discount">
							<div class="full">0</div>
							<div class="discount">0</div>
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
									<td class="label">ส่วนลด:</td>
									<td class="data">฿<span summary="total-discount-text">0</span></td>
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
									<td class="label">รวม:</td>
									<td class="data">฿<span summary="subtotal-text">0</span></td>
								</tr>
								<tr>
									<td class="label">รวมหัก:</td>
									<td class="data">- ฿<span summary="subtotal-text">0</span></td>
								</tr>
								<tr>
									<td class="label">รวมทั้งหมด:</td>
									<td class="data Balance">฿<span summary="balance-text">0</span></td>
								</tr>
							</tbody></table>
						</td>
					</tr>
				</tbody></table>

				<div class="slipPaper-bodyFooter-actions mvm clearfix">
					<div class="lfloat">
						
						<span class="gbtn"><a class="btn"><i class="icon-clone mrs" data-bill-action="clone"></i>Clone</a></span>
						
						<!-- <span class="gbtn"><a class="btn"><i class="icon-envelope"></i></a></span> -->
					</div>
					<div class="rfloat">

						<span class="gbtn"><a class="btn btn-red" data-bill-action="cancel"><i class="icon-remove mrs"></i>Cancel</a></span>


						<span class="gbtn"><a class="btn" data-bill-action="hold"><i class="icon-arrow-up mrs"></i>Hold</a></span>

						<span class="gbtn"><a class="js-send-order btn btn-blue"><i class="icon-floppy-o mrs" data-bill-action="send"></i>Send</a></span>
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
					<span class="gbtn radius"><a class="btn js-set-option" data-type=""><i class="icon-address-card-o"></i></a></span>
					<span class="t">สมาชิก</span>
				</li>
										
				<li class="button">
					<span class="gbtn radius"><a class="btn js-set-option" data-type=""><i class="icon-retweet"></i></a></span>
					<span class="t">ส่วนลด</span>
				</li>

			</ul>
		</nav>

		<div class="pay button">
			<span class="gbtn radius large"><a class="btn btn-blue" data-bill-action="pay"><i class="icon-thailand-baht"></i></a></span>
			<span class="t">Pay</span>
		</div>
	</footer>
	<!-- end: footer -->
</div>