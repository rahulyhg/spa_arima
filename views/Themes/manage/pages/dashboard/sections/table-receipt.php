<div class="clearfix mvl">
	<div class="ui-card ">
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
	    				<th class="qty">QUANTITY</th>
	    				<th class="unit">UNIT COST</th>
	    				<th class="price">Discount</th>
	    				<th class="total">TOTAL</th>
	    			</tr>
	    		</thead>

	    		<tbody>
	    		<?php 

	    		$total_price = 0;
	    		$total_customer = 0;
	    		$total_qty = 0;
	    		$total_discount = 0;
	    		$total_all = 0;

	    		foreach ($this->package['lists'] as $key => $value) { ?>
	    			<tr>
	    				<td class="name"><?=$value['name']?></td>
	    				<td class="unit"><?=$customer = !empty($value['total_customer']) ? $value['total_customer'] : 0?></td>
	    				<td class="qty"><?=$qty = !empty($value['total_qty']) ? $value['total_qty'] : 0?></td>
	    				<td class="qty"><?=$price = round($value['price'])?></td>
	    				<td class="price"><?=$discount = !empty($value['total_discount']) ? round($value['total_discount']) : 0?></td>
	    				<td class="total">
	    					<?php
	    					$total = 0; 
	    					if( !empty($value['total_qty']) ) {
	    						$discount = !empty($value['total_discount']) ? $value['total_discount'] : 0;
	    						$total = ($value['total_qty'] * $value['price']) - $discount;
	    					}

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
	    		</tbody>
	    		<tfoot>
	    			<tr>
	    				<th class="name"></th>
	    				<th class="unit"><?=number_format($total_customer)?></th>
	    				<th class="qty"><?=number_format($total_qty)?></th>
	    				<th class="qty"><?=number_format($total_price)?></th>
	    				<th class="price"><?=number_format($total_discount)?></th>
	    				<th class="total"><?=number_format($total_all)?></th>
	    			</tr>
	    		</tfoot>
	    							    		
	    	</tbody></table>
	    	</div>
	    </div>
	</div>

</div>