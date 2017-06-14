<div id="payment">
	
	<div class="payment-wrapper clearfix">
		<div class="payment-btn-hide">
			Hide <span class="gbtn"><a class="js-link-back btn" data-global-action="menu"><i class="icon-arrow-right"></i></a></span>
		</div>
		<div class="payment-right">

			<ul>
				<li>
					<div class="gbtn radius">
						<a class="btn js-set-option" data-type="tipAmounts"><i class="icon-heart"></i></a>
					</div>
					<div class="mts des-text">Tip</div>
				</li>
				<li class="hidden_elem">
					<div class="gbtn radius">
						<a class="btn js-set-option" data-type="print"><i class="icon-print"></i></a>
					</div>
					<div class="mts des-text">Reprint</div>
				</li>
			</ul>
			
		</div>
		<div class="payment-left">

			<div class="payment-content">
			<header class="payment-header phs mbm">
				<table class="payment-number-summary">
					<tbody><tr>
						<td>
							<div class="label clearfix">
								<span class="lfloat"><?=$this->lang->translate('Total')?></span><!-- Balance Due -->
								<span class="rfloat"><?=$this->lang->translate('Pay')?></span><!-- Amount Tendered -->
							</div>
							<div class="input clearfix">
								<div class="lfloat">฿<span summary="total">0</span></div>
								<div class="rfloat Payment">฿<span summary="pay">0</span></div>
							</div>
							<div class="label Tip"><?=$this->lang->translate('Tip')?>: ฿<span summary="tip">0</span></div>
						</td>
						<td class="change">
							<div class="label"><?=$this->lang->translate('Change')?></div>
							<div class="input">฿<span summary="change-text">0</span></div>
						</td>
					</tr>
				</tbody></table>
			</header>

			<div class="payment-pay-number">
				<ul class="clearfix">
					 
					<li><a class="js-enter-pay btn" data-event="next" data-value="7">7</a></li>
					 
					<li><a class="js-enter-pay btn" data-event="next" data-value="8">8</a></li>
					 
					<li><a class="js-enter-pay btn" data-event="next" data-value="9">9</a></li>
					 
					<li><a class="js-enter-pay btn btn-blue" data-event="plus" data-value="50">฿20</a></li>

					<li class="clear"></li>
					 
					<li><a class="js-enter-pay btn" data-event="next" data-value="4">4</a></li>
					 
					<li><a class="js-enter-pay btn" data-event="next" data-value="5">5</a></li>
					 
					<li><a class="js-enter-pay btn" data-event="next" data-value="6">6</a></li>
					 
					<li><a class="js-enter-pay btn btn-blue" data-event="plus" data-value="20">฿100</a></li>
					<li class="clear"></li>
					 
					<li><a class="js-enter-pay btn" data-event="next" data-value="1">1</a></li>
					 
					<li><a class="js-enter-pay btn" data-event="next" data-value="2">2</a></li>
					 
					<li><a class="js-enter-pay btn" data-event="next" data-value="3">3</a></li>
					 
					<li><a class="js-enter-pay btn btn-blue" data-event="plus" data-value="50">฿500</a></li>
					<li class="clear"></li>
					 
					<li><a class="js-enter-pay btn" data-event="clear" data-value="1">C</a></li>
					 
					<li><a class="js-enter-pay btn" data-event="next" data-value="0">0</a></li>
					 
					<li><a class="js-enter-pay btn" data-event="prev" data-value="1"><i class="icon-arrow-left"></i></a></li>
					 
					<li><a class="js-enter-pay btn btn-blue fsmall" data-event="plus" data-value="100">฿1000</a></li>
														</ul>
			</div>

			</div>
		</div>
		

		<footer class="payment-footer clearfix">
			<div class="payment-footer-right rfloat">
				<div class="gbtn radius jumbo">
					<a class="js-done btn btn-blue disabled">Done</a>
				</div>
			</div>
			<div class="payment-footer-left">
				<ul class="clearfix">
					<li><div class="gbtn"><a class="btn btn-large btn-blue" data-id="1">Cash</a></div></li><li><div class="gbtn"><a class="btn btn-large" data-id="2">Credit</a></div></li><li><div class="gbtn"><a class="btn btn-large" data-id="3">Check</a></div></li>
				</ul>
			</div>
			
		</footer>
	</div>
</div>