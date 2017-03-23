<?php

$this->steps = array();
$this->steps['owner'] = array('text'=>'ข้อมูลลูกค้า','name'=>'owner');
$this->steps['sender'] = array('text'=>'ผู้ส่งซ่อม','name'=>'sender');
$this->steps['car'] = array('text'=>'ข้อมูลรถ','name'=>'car');
$this->steps['items'] = array('text'=>'รายการซ่อม','name'=>'items');
$this->steps['plans'] = array('text'=>'นัดหมาย/หมายเหตุ','name'=>'plans');

?>
<div data-plugins="serviceform" data-options="<?=$this->fn->stringify( array(
	'steps' => $this->steps,
	'is_step' => 'owner',
) )?>" action="<?=URL?>orders/send/">

	<div class="datalist-main-header">
		<div class="clearfix">
			<div class="rfloat">
                            <a title="Cancel" href="<?=URL?>services/index" class="btn js-cancel"><i class="icon-remove mrs"></i>ยกเลิก</a>
		    </div>
			<div class="title">
				<h2><i class="icon-file-text-o mrs"></i>New Order</h2>
			</div>
		</div>
	</div>
	<!-- slipPaper-header -->

	<div class="datalist-main-content">

		<?php require 'search/display.php'; ?>
		<?php require 'newcus/display.php'; ?>

	</div>

</div>