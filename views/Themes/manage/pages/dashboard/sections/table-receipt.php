<div class="clearfix mvl">
	<div class="ui-card u-boxShadow-2 mvl bg-green">
		<div class="ui-card_header">
	        <h3 class="ui-card_headerTitle">สรุปยอดรายรับ</h3>
	        <div class="ui-card_headerDesc"><?=$this->date_str?></div>
	    </div>
	    <div class="ui-card_content">
	    	<div class="ui-card_tableWrap">
	    	<table class="ui-card_table"><tbody>

	    		<thead>
	    			<tr>
	    				<th class="name">รายการ</th>
	    				<th class="qty">จำนวนลูกค้า</th>
	    				<th class="qty">จำนวนครั้ง</th>
	    				<th class="unit">ราคาต่อหน่วย</th>
	    				<th class="price">เป็นเงิน</th>
	    				<th class="price">ส่วนลด</th>
	    				<th class="total">เงินนำส่ง</th>
	    			</tr>
	    		</thead>

	    		<tbody>
	    			<tr>
	    				<td class="name">ห้อง VIP</td>
	    				<td class="unit">-</td>
	    				<td class="qty">-</td>
	    				<td class="qty">-</td>
	    				<td class="price"><?=number_format($this->room[0]['sum_room_price'])?></td>
	    				<td class="price">-</td>
	    				<td class="total"><?=number_format($this->room[0]['sum_room_price'])?></td>
	    			</tr>
	    		<?php 

	    		$total_price = 0;
	    		$total_customer = 0;
	    		$total_qty = 0;
	    		$total_discount = 0;
	    		$total_all = $this->room[0]['sum_room_price'];

	    		foreach ($this->package['lists'] as $key => $value) { ?>
	    			<tr>
	    				<td class="name"><?=$value['name']?></td>
	    				<td class="unit"><?=$customer = !empty($value['total_customer']) ? $value['total_customer'] : 0?></td>
	    				<td class="qty"><?=$qty = !empty($value['total_qty']) ? $value['total_qty'] : 0?></td>
	    				<td class="qty"><?=round($value['price'])?></td>
	    				<td class="price"><?=$price = !empty($value['total']) ? round($value['total']) : 0?></td>
	    				<td class="price"><?=$discount = !empty($value['total_discount']) ? round($value['total_discount']) : 0?></td>
	    				<td class="total">
	    					<?php
	    					$total = $value['total_balance']; 

	    					echo number_format($total);

	    					$total_customer = $total_customer + $customer;
	    					$total_qty = $total_qty + $qty;
	    					$total_price = $total_price + $price;
	    					$total_discount = $total_discount + $discount;
	    					$total_all = $total_all + $total;
	    					?>
	    				</td>
	    			</tr>
	    		<?php } ?>
	    			<tr>
	    				<td class="name">ค่า Drink</td>
	    				<td class="unit">-</td>
	    				<td class="qty">-</td>
	    				<td class="qty">-</td>
	    				<td class="price"><?=number_format($this->revenue['sum_drink'])?></td>
	    				<td class="price">-</td>
	    				<td class="total"><?=number_format($this->revenue['sum_drink'])?></td>
	    				<?php $total_all = $total_all + $this->revenue['sum_drink'] ?>
	    			</tr>
	    		</tbody>
	    		<tfoot>
	    			<tr>
	    				<th class="name"></th>
	    				<th class="unit"><?=number_format($total_customer)?></th>
	    				<th class="qty"><?=number_format($total_qty)?></th>
	    				<th class="qty">-</th>
	    				<th class="price"><?=number_format($total_price)?></th>
	    				<th class="price"><?=number_format($total_discount)?></th>
	    				<th class="total"><?=number_format($total_all)?></th>
	    			</tr>
	    		</tfoot>
	    							    		
	    	</tbody></table>
	    	</div>
	    </div>
	</div>

</div>