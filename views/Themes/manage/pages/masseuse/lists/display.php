<div id="mainContainer" class="clearfix listpage2-container" data-plugins="main">

	<div role="content">
		<div role="main">

<?php require_once 'init.php'; ?>

<div class="listpage2 has-loading offline listpage2-mg" data-plugins="listpage2" data-options="<?= $this->fn->stringify( array(
		'url' => $this->getURL,
		'lists' => array(),
		'options' => array()
	) )?>">

	<!-- header -->
	<?php require 'header.php'; ?>

	<!-- table -->
	<div ref="table" class="listpage2-table table-mg">
		<div ref="tabletitle"><?php require 'tabletitle.php'; echo $tabletitle; ?></div>
		<div ref="tablelists"></div>
                

		<!-- <div class="listpage2-table-overlay"></div> -->
		<div class="listpage2-table-empty">
	        <div class="empty-icon"><i class="icon-users"></i></div>
	        <div class="empty-title">ไม่พบข้อมูล</div>
		</div>
		
	</div>

	<div class="listpage2-table-overlay-warp">
		<div class="listpage2-table-overlay"></div>
		<div class="listpage2-alert">
			<div class="listpage2-loading">
				<div class="listpage2-loading-icon loader-spin-wrap"><div class="loader-spin"></div></div>
				<div class="listpage2-loading-text">กำลังโหลด...</div> 
			</div>
		</div>
	</div>
</div>

		</div>
		<!-- end: main -->
	</div>
	<!-- end: content -->
</div>
<!-- end: container -->
<script type="text/javascript">
	
	self.$('[ref=table]').delegate('.js-change-skill', 'change', function() {
		var url = $(this).data('url') || $(this).attr('stringify'),
			name = $(this).attr('name')
			val = $(this).val(),
			box = $(this).closest('[data-id]');

		var formData = new FormData();

		// set field
		$.each(box.find(':input.js-change-skill'), function (index, field) {

			if( $(this).prop('checked') ){
				formData.append('value[]', field.value );
			} 
        });

		return $.ajax({
			type: "POST",
			url: Event.URL + 'masseuse/set/'+box.data('id')+'/skill',
			data: formData,
			dataType: 'json',
			processData: false,
    		contentType: false,
		}).done(function (res) {
			// console.log( res );
		}).always(function() {
		}).fail(function(  ) {

		});
	});


	if( $(window).width() < 1600 ){
		$('body').removeClass('is-pushed-left');

		setTimeout(function () {
			$('body').addClass('is-overlay-left');
		}, 200);
			
	}
</script>