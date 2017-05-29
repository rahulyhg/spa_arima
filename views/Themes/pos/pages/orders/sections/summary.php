<div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;">

<div style="position: absolute;top: 0;left: 0; right: 100px;background-color: rgba(245,248,250,.98);z-index: 1">

<header class="clearfix" style="padding-top: 60px;padding-left: 30px;padding-right: 30px">
	<div class="lfloat"><h1 style="display: inline-block;"><i class="icon-line-chart mrs"></i><span>สรุปยอดรายรับ</span></h1>
	</div>
	<div class="tar fsm mbm">วันที่ <span data-summary="date"></span></div>
</header>
</div>

<div style="position: absolute;top: 0;left: 30px;overflow-y: auto;bottom: 0;right: 0">

<div style="margin-right: 100px;padding-top: 100px">
	

	<div data-content="summary" class="mvm pbl " style="background-color: #fff;box-shadow:0 1px 3px rgba(0,0,0,.3); padding: 10px;border:1px solid rgba(0,0,0,.3);border-radius: 3px;">

		
		<?php // require '_summary.php'; ?>

	</div>
</div>

</div>

<div style="position: absolute;width: 100px;right: 20px;top: 40px;bottom: 30px;">

	<ul class="ui-list">
		<!-- <li class="mbm tac">
			<div class="gbtn radius">
				<a class="btn btn-blue" data-type="print"><i class="icon-print"></i></a>
			</div>
			<div class="mts des-text">Print</div>
		</li>

		<li class="mbm tac">
			<div class="gbtn radius">
				<a class="btn js-set-option" data-type="tipAmounts"><i class="icon-pencil"></i></a>
			</div>
			<div class="mts des-text">Edit</div>
		</li> -->

	</ul>

	<ul class="bottom" style="position: absolute;bottom: 0;left: 0;right: 0">
		
		<!-- <li class="mbm tac">
			<div class="gbtn radius">
				<a class="btn btn-red" data-type="print"><i class="icon-remove"></i></a>
			</div>
			<div class="mts des-text">Cancel</div>
		</li> -->
	</ul>
	
</div>

</div>

<div style="position: absolute;top:10px;right:20px;z-index:100;">
	<div class="group-btn"><a class="btn" href="<?=URL?>pos/orders?style=2"><i class="icon-list"></i></a><a class="btn active"><i class="icon-television"></i></a></div>
</div>