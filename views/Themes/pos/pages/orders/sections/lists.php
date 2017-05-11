 <section class="section section-package">

	<header class="section-package-header">
		<form class="">
		<table>
			<tr>
				<td class="prm theDate">
					<label>Date:</label>
					<div class=""><input type="date" name="date" data-plugins="datepicker" data-options="<?=$this->fn->stringify( array('lang'=>$this->lang->getCode() ) )?>"></div>
				</td>
				
				<td class="prs">
					<label>Search:</label>
					<input type="text" class="inputtext input-search" maxlength="100" placeholder="">
				</td>
				<td class="" style="width: 30px">
					<span class="gbtn radius"><a class="btn btn-blue" data-global-action="bill"><i class="icon-plus"></i></a></span>
				</td>
			</tr>
		</table>
		
		</form>
	</header>
	<div class="section-package-content">
		<ul class="ui-list ui-list-orders">

			<li class="ui-item head">10:00 PM</li>
			<li class="ui-item active">
				<div class="ui-item-inner clearfix">
					
					<div class="rfloat"><abbr class="timestamp fsm">9:25</abbr></div>
					
					<div class="text">
						<span><label>No.</label> <strong>1</strong></span>
						<span><i class="icon-address-card-o"></i>ภุชงค์</span>
					</div>
					
					<div class="subtext clearfix">
						<span><label>Package:</label> AKASURI, SAUNA</span>
						<div class="rfloat"><span class="ui-status">RUN</span></div>
					</div>

					<div class="subtext clearfix">
						<span><label>Total Time:</label> 10.00 - 11.00 PM</span>

						<div class="rfloat">
							<!-- <span><i class="icon-cube"></i>4/฿4,000</span> -->
						</div>
						<!-- <span><i class="icon-user-circle-o"></i>ภุชงค์</span>
						<span><i class="icon-cube"></i>4/฿4,000</span>
						<span><i class="icon-shower"></i></span> -->
					</div>
				</div>
			</li>

			<li class="ui-item head">10:00 PM</li>
			<?php for ($i=0; $i < 20; $i++) { ?>
			<li class="ui-item" data-id="<?=$i?>">
				<div class="ui-item-inner clearfix">
					<abbr class="rfloat timestamp fcg fsm">9:25</abbr>
					
					<div class="text">
						<span><label>No.</label> <strong>102</strong></span>
						<!-- <span><i class="icon-address-card-o"></i>ภุชงค์</span> -->
					</div>
					
					<div class="subtext clearfix">
						<span><label>Room Number:</label> 101</span>
						<div class="rfloat"><span class="ui-status">RUN</span></div>
					</div>

					<div class="subtext clearfix">
						<span><i class="icon-user"></i>ภุชงค์</span>
						
						<div class="rfloat"><i class="icon-cube"></i>4/฿4,000</div>
					</div>
				</div>
			</li>
			<?php } ?>
		</ul>

		<a class="ui-more btn" role="more">โหลดเพิ่มเติม</a>
		<div class="ui-alert">
			<div class="ui-alert-loader">
				<div class="ui-alert-loader-icon loader-spin-wrap"><div class="loader-spin"></div></div>
				<div class="ui-alert-loader-text">กำลังโหลด...</div> 
			</div>

			<div class="ui-alert-error">
				<div class="ui-alert-error-icon"><i class="icon-exclamation-triangle"></i></div>
				<div class="ui-alert-error-text">ไม่สามารถเชื่อมต่อได้</div> 
			</div>

			<div class="ui-alert-empty">
				<div class="ui-alert-empty-text">ไม่มีนัดหมาย </div> 
			</div>
		</div>
	</div>
</section>