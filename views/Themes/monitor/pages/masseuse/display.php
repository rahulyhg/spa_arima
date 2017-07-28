<div class="queue-wrap" style="position: fixed;right: 0;left: 0;top: 0;bottom: 0">
	<!-- Masseuse & OIL -->
	<div id="mainMasseuse"></div>

	<!-- Status RUN -->
	<div style="position: absolute;right: 0;width: 26%;top: 0;bottom: 0;background-color: #1f1f1f;border-right: 1px solid #4b4b4b;color: #fff">
		<div class="thedate" style="margin: 10px;" data-plugins="oclock" data-options="<?=$this->fn->stringify( array('lang'=>$this->lang->getCode() ) )?>">
			<div class="thedate-time" style="font-size: 250%">
				<div ref="time" class="time"></div>
			</div>
			<div class="thedate-date"><div ref="date" class="date"></div></div>
		</div>
		<div id="mainRun"></div>
	</div>
	
</div>

<!-- <div class="queue-alert">
	<div class="queue-alert-content">
		
		<div class="queue-alert-outer"><div class="queue-alert-inner"><span class="code">B16</span><span class="text">นวดออย</span></div></div>
		<div class="queue-alert-outer"><div class="queue-alert-inner"><span class="code">1</span><span class="text">นวดตัว</span></div></div>
		<div class="queue-alert-outer"><div class="queue-alert-inner"><span class="code">999</span><span class="text">นวดตัว+นวดเท้า</span></div></div>
	</div>
</div> -->

<script type="text/javascript">

	var getMasseuse = function(){
		$.get(Event.URL + 'masseuse/monitor', {main:'masseuse'}, function (res) {
			$('#mainMasseuse').html( res );
		});
		$.get(Event.URL + 'masseuse/monitor', {main:'run'}, function (res) {
			$('#mainRun').html( res );
		});
	};

	$( window ).on( "load", getMasseuse );
	setInterval(getMasseuse, 3000);

</script>