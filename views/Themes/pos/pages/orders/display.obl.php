<?php

$th = array();

$th[] = array('cls' => 'ID', 'label'=> 'ลำดับ');
$th[] = array('cls' => 'name', 'label'=> 'ข้อมูล');

$th[] = array('cls' => 'no', 'label'=> 'HR');
$th[] = array('cls' => 'va', 'label'=> 'V.I.P');

$th[] = array('cls' => 'no', 'label'=> 'NO.');
$th[] = array('cls' => 'va', 'label'=> 'นวดตัว');

$th[] = array('cls' => 'no', 'label'=> 'NO.');
$th[] = array('cls' => 'va', 'label'=> 'นวดเท้า');

$th[] = array('cls' => 'no', 'label'=> 'NO.');
$th[] = array('cls' => 'va', 'label'=> 'นวดหัว');

$th[] = array('cls' => 'no', 'label'=> 'NO.');
$th[] = array('cls' => 'va', 'label'=> 'นวด OIL');

$th[] = array('cls' => 'no', 'label'=> 'NO.');
$th[] = array('cls' => 'va', 'label'=> 'นวดหน้า');

$th[] = array('cls' => 'no', 'label'=> 'NO.');
$th[] = array('cls' => 'va', 'label'=> 'แคะหู');

$th[] = array('cls' => 'no', 'label'=> 'NO.');
$th[] = array('cls' => 'va', 'label'=> 'เล็บมือ');

$th[] = array('cls' => 'no', 'label'=> 'NO.');
$th[] = array('cls' => 'va', 'label'=> 'เล็บเท้า');

$th[] = array('cls' => 'va', 'label'=> 'SAUNA');
$th[] = array('cls' => 'va', 'label'=> 'AKASUR');
$th[] = array('cls' => 'va', 'label'=> 'อาบน้ำ');
$th[] = array('cls' => 'va', 'label'=> 'DRINK');


$th[] = array('cls' => 'actions', 'label'=> '');
?>

<div id="mainContainer" class="clearfix listpage2-container" data-plugins="main">

	<div role="content">
		<div role="main">

<div class="" style="margin: 40px;">

	<div class="clearfix">
		<div class="rfloat">
			<input type="date" name="">
		</div>
	</div>

	<div style="">
		<table class="table-order2">
			<thead>
			<tr><?php
				foreach ($th as $key => $value) { ?>
				<th class="<?=$value['cls']?>"><?=$value['label']?></th>
			<?php } ?></tr>
			</thead>

			<tbody>
				<tr><?php
				foreach ($th as $key => $value) { ?>
					<td class="<?=$value['cls']?>">
						<?php if( $value['cls']=='va' ) {?>
						<label class="checkbox"><input type="checkbox" name=""></label>
						<?php }else{
							echo '2';
						} ?>
					</td>
				<?php } ?></tr>
			</tbody>

			<tbody>
				<?php for ($i=0; $i < 5; $i++) { ?>
					
				<tr><?php
				foreach ($th as $key => $value) { ?>
					<td class="<?=$value['cls']?>">
						<?php if( $value['cls']=='ID' ) {
							echo $i;
						} ?>
					</td>
				<?php } ?></tr>


				<?php } ?>
			</tbody>
		</table>
	</div>

</div>

		</div>
		<!-- end: main -->
	</div>
	<!-- end: content -->
</div>
<!-- end: container -->