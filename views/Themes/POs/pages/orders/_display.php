<?php

$actions = array();
$actions[] = array('id'=>'qty','name'=>'จำนวนลูกค้า','icon'=>'users');
$actions[] = array('id'=>'room_name','name'=>'ห้อง/เตียง','icon'=>'building');
// $actions[] = array('id'=>'cancel','name'=>'ยกเลิก','icon'=>'building');



?>


<div class="add-order" data-plugins="addorder" data-options="<?= $this->fn->stringify( array(
	'date' => date('Y-m-d'),

) ) ?>">
	
	<!-- actions -->
	<section data-section="actions" class="section-actions">
		<ul class="clearfix actions-order3"><?php

		foreach ($actions as $key => $value) { ?>
			<li data-action="<?=$value['id']?>">
				<div class="gbtn radius"><a class="btn"><i class="icon-<?=$value['icon']?>"></i></a></div>
				<div class="txt"><?=$value['name']?></div>
				<div class="countValue"></div>
			</li>
		<?php } ?>

		</ul>
		<ul class="clearfix actions-order3" style="position: absolute;bottom: 0">
			<li >
				<div class="gbtn radius"><a class="btn"><i class="icon-remove"></i></a></div>
				<div class="txt">ยกเลิก</div>
			</li>
		</ul>
		<?php //echo $form->html(); ?>
	</section>
	<!-- end: actions -->
	
	<ul class="section-zone table-zone" data-section="zone"></ul>

	<div class="section-list-warp" data-section="list" >
		
		<section class="section-list" data-ref="list">

			<?php for ($i=0; $i < 4; $i++) { ?>
			<div class="table-order3-wrap">
				<div class="table-order3-inner">
					<ul class="stap-order3 clearfix">

						<li class="check-box">
							<label class="checkbox"><input type="checkbox" name=""></label>
						</li>
						<li>
							<strong>ลำดับ</strong>
							<span>001</span>
						</li>
						<li>
							<strong>สมาชิก</strong>
							<span>-</span>
						</li>
						<li>
							<strong>Drink</strong>
							<span>-</span>
						</li>
						<!-- <li>
							<strong>สถานะ</strong>
							<span class="ui-status">order</span>
						</li> -->

						<li>
							<strong>รวม</strong>
							<span>3,000</span>
						</li>

						<li class="toggle">
							<a><i class="icon-angle-down"></i></a>
						</li>
					</ul>	
				
					<table class="table-order3">
						<thead>
							
							<tr>
								<!-- <th class="check-box"><label class="checkbox"><input type="checkbox" name=""></label></th> -->
								<th class="name">รายการ</th>
								<th class="masseuse">พนง.ผู้บริการ</th>
								<!-- <th class="price">ราคา</th> -->
								<th class="time">เวลา</th>
								<th class="total price">ราคา</th>
								<th class="actions"></th>
							</tr>
						</thead>

						<tbody>
						
						<?php for ($q=0; $q < 2; $q++) { ?><tr>
							<!-- <td class="check-box"><label class="checkbox"><input type="checkbox" name=""></label></td> -->
							<td class="name">
								<div class="rfloat">
									<span class="ui-status">สั่ง</span>
								</div>
								<div class="lfloat"><strong>นวดเท้า</strong></div>
							</td>
							<td class="masseuse">
								<ul class="ui-list-masseuse">
									<li><a class="control" data-control="change" data-type="masseuse" data-id="198"><span class="ui-status lfloat mrm">110</span><div class="avatar lfloat mrs"><img src="http://arima.vm101.net/public/uploads/1/87d2c0e7_2a15e949a7eed35ab76874ef19541574_a.jpg"></div><span class="">นก</span></a></li>
								</ul>
							</td>
							<!-- <td class="price">sds</td> -->
							<td class="time">
								<strong>2 Hour</strong>
								<span>10.00 - 12.00</span>
							</td>
							<td class="total price">
			
								<div class="cost">350</div>
								<div class="discount">-50</div>
								<div class="box-total"><span class="ui-status coupon mrs">C</span><span class="total">9,999</span></div>

							</td>
							<td class="actions">
								<span class=""><a class="btn btn-large"><i class="icon-ellipsis-v"></i></a></span>
							</td>
						</tr>
						<?php } ?>
						</tbody>

					</table>
				</div>
			</div>
			<?php } ?>
		</section>

		<section class="section-summary" data-ref="summary">
			
			<div class="pvm phl">
				<table class="table-order3-summary">
					<tbody><tr>
						<td class="colleft">
							<table><tbody>
								
								<tr>
									<td class="label">รวม:</td>
									<td class="data"><span data-summary="total">0</span> ฿</td>
								</tr>
								<tr>
									<td class="label">ส่วนลด (สมาชิก):</td>
									<td class="data discount">-<span data-summary="discount_member">0</span> ฿</td>
								</tr>
								<tr>
									<td class="label">รวมลด:</td>
									<td class="data discount">-<span data-summary="discount">0</span> ฿</td>
								</tr>
							</tbody></table>
						</td>
						<td class="colright">
							<table><tbody>
								<tr>
									<td class="label"><?=$this->lang->translate('Drink')?>:</td>
									<td class="data"><span data-summary="drink">0</span> ฿</td>
								</tr>
								<tr>
									<td class="label">ค่าห้อง (V.I.P.):</td>
									<td class="data"><span data-summary="room_price">0</span> ฿</td>
								</tr>
								<tr>
									<td class="label TOTAL">รวมทั้งหมด:</td>
									<td class="data TOTAL"><span data-summary="balance">0</span> ฿</td>
								</tr>
							</tbody></table>
						</td>
					</tr>
				</tbody></table>
			</div>

			<div class="pvm phl clearfix">
				<div class="gbtn large radius rfloat"><a class="btn btn-blue">Save</a></div>
			</div>
		</section>
	</div>

	<div class="section-menu-warp">
		<nav class="section-menu-nav">
			<ul class="clearfix pll">
				<li><a>Package</a></li>
			</ul>
		</nav>
		<div class="section-menu-main">
			<div class="section-menu-countent">
				<ul class="section-menu-lists ui-menu-items ui-list-v clearfix" data-ref="menu"><?php foreach ($this->package['lists'] as $key => $value) { ?><li class="ui-menu-item" data-id="<?=$value['id']?>" data-type="package"><a class="inner clearfix"><div class="image" style=""><div class="gradient-overlay"></div></div><div class="text clearfix"><div class="title-block"><div class="category"></div><div class="title"><?=$value['name']?></div></div></div></a></li><?php } ?></ul>
			</div>
		</div>
	</div>

</div>