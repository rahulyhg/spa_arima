<div class="datalist-left-content">
<header role="leftHeader" class="datalist-left-header">
	<div class="header clearfix">
		<div class="rfloat"><span class="gbtn radius"><a title="New Invoices" class="btn btn-red btn-radius fsxxl js-new"><i class="icon-plus"></i></a></span></div>
		<div>

			<h2><i class="icon-address-book-o mrs"></i><span>Booking</span></h2>

			<ul class="clearfix tap-meta">
				<li><strong>Today</strong><span view-text="count-today">0</span></li>
				<li><strong>Yesterday</strong><span view-text="count-yesterday">0</span></li>
				<li><strong>Total</strong><span view-text="count-total">0</span></li>
			</ul>
		</div>
	</div>
	
	<ul class="datalist-search-options clearfix mtm">
		<li data-select="date"><strong class="mrs">Date:</strong><input class="js-setDate inputtext" type="text" name="date"></li>
		<li><strong class="mrs">Status:</strong><select role="selection" name="status"><?php foreach ($this->status as $key => $value) { 

			echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
		} ?></select></li>
	</ul>

	<div class="datalist-left-search"><input class="inputtext input-search" name="q" autocomplete="off" maxlength="100" role="search" placeholder="Search: Sender's Name, Invoices ID"></div>


	<div class="clearfix fsm datalist-left-summary">
		<div><strong class="mrs">Total:</strong><span view-text="total">0</span></div>
	</div>
</header>
<!-- end: leftHeader -->
	
<div role="leftContent" class="datalist-left-listsbox-wrap has-loading">

	<ul role="listsbox"></ul>
	
	<div class="empty">
		<div class="empty-loader">
			<div class="empty-loader-icon loader-spin-wrap"><div class="loader-spin"></div></div>
			<div class="empty-loading-text">Loading...</div> 
		</div>

		<div class="empty-text">Empty</div>
		
	</div>

</div>
<!-- end: leftContent -->

</div>
<!-- end: datalist-left-content -->