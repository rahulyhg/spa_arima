<?php require 'init.php'; ?>

<div id="mainContainer" class="clearfix" data-plugins="main">

	<div role="content">
		<?php require 'sections/toolbar.php'; ?>
		<!-- End: toolbar -->

		<div role="main" id="dashboard_main"></div>
		<!-- end: main -->

	</div>
	<!-- end: content -->

</div>
<!-- end: mainContainer -->

<script type="text/javascript">
	$('[selector=closedate]').closedate({
		leng:"th",
		options: [
			{
				text: 'วันนี้',
				value: 'daily',
			},
			{
				text: 'เมื่อวานนี้',
				value: 'yesterday',
			},
			{
				text: 'สัปดาห์นี้',
				value: 'weekly',
			},
			{
				text: 'เดือนนี้',
				value: 'monthly', 
			},
			{
				text: 'กำหนดเอง',
				value: 'custom',
			}
		],
		onChange:function(date){
			$.get(Event.URL + 'dashboard', {period_start:date.startDateStr, period_end:date.endDateStr, main:1}, function(res){
				$('#dashboard_main').html( res );
				Event.plugins( $('#dashboard_main') );
			});
		},
	});
</script>
