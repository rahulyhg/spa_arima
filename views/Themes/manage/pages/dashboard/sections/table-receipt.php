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
	    				<th class="qty">QUANTITY</th>
	    				<th class="unit">UNIT COST</th>
	    				<th class="price">Discount</th>
	    				<th class="total">TOTAL</th>
	    			</tr>
	    		</thead>

	    		<tbody>
	    		<?php foreach ($this->package['lists'] as $key => $value) { ?>
	    			<tr>
	    				<td class="name"><?=$value['name']?></td>
	    				<td class="unit"><?=(!empty($value['total_customer']) ? $value['total_customer'] : 0)?></td>
	    				<td class="qty"><?=(!empty($value['total_qty']) ? $value['total_qty'] : 0)?></td>
	    				<td class="qty"><?=$value['price']?></td>
	    				<td class="price"><?=(!empty($value['total_discount']) ? $value['total_discount'] : 0)?></td>
	    				<td class="total">
	    					<?php
	    					$total = 0; 
	    					if( !empty($value['total_qty']) ) {
	    						$discount = !empty($value['total_discount']) ? $value['total_discount'] : 0;
	    						$total = ($value['total_qty'] * $value['price']) - $discount;
	    					}

	    					echo number_format($total);
	    					?>
	    				</td>
	    			</tr>
	    		<?php } ?>
	    		</tbody>
	    							    		
	    	</tbody></table>
	    	</div>
	    </div>
	</div>

</div>