<div id="mainContainer" class="clearfix" data-plugins="main">

	<div role="content">

		<div role="toolbar">
			<div class="pvm phl">

				<ul class="ui-steps clearfix">
					<li class="anchor clearfix mg-anchor">
						<div class="lfloat mrm top-doc-logo"><div class="initials">MG</div></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">สต็อกรถยนต์</div></div></div>
					</li>
					<li>
						<label class="label">ยอดจอง</label>
						<span class="data"><?=(!empty($this->product['sum_booking']) ? $this->product['sum_booking']:'-')?></span>
					</li>
					<li>
						<label class="label">คงเหลือ</label>
						<span class="data"><?=(!empty($this->product['sum_balance']) ? $this->product['sum_balance']:'-')?></span>
					</li>
					<li>
						<label class="label">รอสั่งเพิ่ม</label>
						<span class="data"><?=(!empty($this->product['sum_ordertotal']) ? $this->product['sum_ordertotal']:'-')?></span>
					</li>
					<li>
						<label class="label">รวมทั้งหมด</label>
						<span class="data"><?=(!empty($this->product['sum_subtotal']) ? $this->product['sum_subtotal']:'-')?></span>
					</li>
					<li>
						<a href="<?=URL?>products/create" class="btn btn-primary"><i class="icon-plus mrs"></i><span class="btn-text">Add New</span></a>
					</li>
					<!-- <li>
						<a href="<?=URL?>products/create_event" data-plugins="dialog" class="btn btn-orange"><i class="icon-plus mrs"></i><span class="btn-text">Add Events</span></a>
					</li> -->
				</ul>
				
			</div>
		</div>

		<div role="main">

		

		<?php foreach ($this->model['lists'] as $key => $value) {

			// if( empty($this->product['lists']) ) continue;
			?>
			<div id="featured-products" class="featured-products">
				
				<header class="featured-products_header">
					<ul class="featured-products_step clearfix">
						<li><h2><?=$value['name']?></h2></li>
						<li>
							<label>จอง</label>
							<span><?=(!empty($value['total_booking']) ? $value['total_booking']:'-')?></span>
						</li>
						<li>
							<label>คงเหลือ</label>
							<span><?=(!empty($value['total_balance']) ? $value['total_balance']:'-')?></span>
						</li>
						<li>
							<label>รอสั่งเพิ่ม</label>
							<span><?=(!empty($value['total_order'])? $value['total_order']:'-')?></span>
						</li>
						<li>
							<label>รวมทั้งหมด</label>
							<span><?=(!empty($value['total_item']) ? $value['total_item']:'-')?></span>
						</li>
					</ul>


				</header>

				<table class="featured-products_table">
					<thead>
					<tr>
						<th>รถยนต์รุ่น/Model</th>
						<th class="nubmer">จอง</th>
						<th class="nubmer">คงเหลือ</th>
						<th class="nubmer">รอสั่งเพิ่ม</th>
						<th class="nubmer">รวมทั้งหมด</th>
						<!-- <th class="actions">จัดการ</th> -->
					</tr>
					</thead>

					<tbody>
					<?php 
						$booking = 0;
						$balance = 0;
						$subtotal = 0;
						$ordertotal = 0;
						foreach ($this->product['lists'] as $key => $product) { 
						if( $product['model_id'] != $value['id'] ) continue;

						$booking = $booking + $product['booking'];
						$balance = $balance + $product['balance'];
						$subtotal = $subtotal + $product['subtotal'];
						$ordertotal = $ordertotal + $product['order_total'];

						$disabled = '';
						if( empty($this->product['permit']['del']) ){
							$disabled = ' disabled';
						}

						?>
					<tr>
						<td><a href="<?=URL?>products/<?=$product['id']?>"><?=$product['name']?></a></td>
						<td class="nubmer"><?=(!empty($product['booking'])?$product['booking']:'-')?></td>
						<td class="nubmer"><?=(!empty($product['balance'])?$product['balance']:'-')?></td>
						<td class="nubmer"><?=(!empty($product['order_total'])?$product['order_total']:'-')?></td>
						<td class="nubmer"><?=(!empty($product['subtotal'])?$product['subtotal']:'-')?></td>
						<!-- <td class="actions" style="text-align: center;">
							<span class="gbtn"><a data-plugins="dialog" href="<?=URL?>products/edit/<?=$product['id'];?>" class="btn btn-no-padding btn-blue"><i class="icon-pencil"></i></a></span>
							<span class='gbtn'><a data-plugins="dialog" href="<?=URL?>products/del/<?=$product['id'];?>" class="btn btn-no-padding btn-red <?=$disabled?>"><i class="icon-trash"></i></a></span>
						</td> -->
					</tr>
					<?php } ?>
					</tbody>


					<tfoot>
						<tr>
							<th>รวมทั้งหมด</th>
							<th class="nubmer"><?=(!empty($booking) ? $booking:'-')?></th>
							<th class="nubmer"><?=(!empty($balance) ? $balance:'-')?></th>
							<th class="nubmer"><?=(!empty($ordertotal) ? $ordertotal:'-')?></th>
							<th class="nubmer"><?=(!empty($subtotal) ? $subtotal:'-')?></th>
							<!-- <th></th> -->
						</tr>
					</tfoot>
				</table>
			</div>
		<?php } ?>
		</div>

	</div>

</div>