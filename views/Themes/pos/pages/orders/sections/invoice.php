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
							<span><label>No.</label> <strong data-invoice="number"></strong></span>
						</div>

						<div class="subtext hidden_elem" data-invoice="member">
							<span><label>Member:</label> <i class="icon-address-card-o mrs"></i><span class="text" data-invoice-set="member"></span> <a data-invoice-action="remove_member" class="btn-icon"><i class="icon-remove"></i></a></span>
						</div>
						
					</div>
					<div class="rfloat tar">
						<div data-invoice="itmelive" class="tableTime-text fsm fwn"></div>
						<span class="ui-status" data-invoice="status">RUN</span>
					</div>
				</div>	
			</div>
			<div class="slipPaper-bodyContent" style="padding-top: 29px; top: 70px; bottom: 140px;">
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
				<table class="slipPaper-bodyFooter-summary mvm">
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
								
							</tbody></table>
						</td>
						<td class="colright">
							<table><tbody>
								<tr>
									<td class="label"><?=$this->lang->translate('Drink')?>:</td>
									<td class="data"><span summary="drink">0</span> ฿</td>
								</tr>
								<tr>
									<td class="label TOTAL"><?=$this->lang->translate('Balance')?>:</td>
									<td class="data TOTAL"><span summary="balance">0</span> ฿</td>
								</tr>
							</tbody></table>
						</td>
					</tr>
				</tbody></table>	
			</div>
		</div>
	</div>
</div>
</div>

<div style="position: absolute;width: 100px;right: 0;top: 50px;bottom: 30px;">

	<ul class="ui-list">
		<!-- <li class="mbm tac">
			<div class="gbtn radius">
				<a class="btn btn-blue" data-type="print"><i class="icon-print"></i></a>
			</div>
			<div class="mts des-text">Print</div>
		</li> -->

		<li class="mbm tac">
			<div class="gbtn radius">
				<a class="btn js-set-option" data-type="tipAmounts"><i class="icon-pencil"></i></a>
			</div>
			<div class="mts des-text">Edit</div>
		</li>
		
	</ul>

	<ul class="bottom" style="position: absolute;bottom: 0;left: 0;right: 0">
		
		<!-- <li class="mbm tac">
			<div class="gbtn radius">
				<a class="btn btn-red" data-type="print"><i class="icon-remove"></i></a>
			</div>
			<div class="mts des-text">Cancel</div>
		</li> -->
		<!-- <li class="mbm tac">
			<div class="gbtn radius">
				<a class="btn btn-blue" data-type="print"><i class="icon-thailand-baht"></i></a>
			</div>
			<div class="mts des-text">Pay</div>
		</li> -->
	</ul>
	
</div>

</div>