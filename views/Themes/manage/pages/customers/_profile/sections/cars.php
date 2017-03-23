<div class="mvm">
	<button type="button" class="btn btn-blue active">คันที่ 1</a>
	<button type="button" class="btn">คันที่ 2</a>
</div>


<?php


?>
<div class="customers-content has-right">
	<div class="customers-main"><div class="mbl">

	<?php 
 	$a = array();
 	$a[] = array('text'=>'จอง','name'=>'booking');
 	$a[] = array('text'=>'ยื่นขอไฟแนนซ์','name'=>'ยื่นขอไฟแนนซ์');
 	$a[] = array('text'=>'จองเลขทะเบียน','name'=>'จดทะเบียน');
 	$a[] = array('text'=>'รับรถ','name'=>'รับรถ');

 	echo '<div class="mbl">'.$this->fn->stepList($a,'booking').'</div>';

 	include 'booking/showroom.php';
	include 'booking/sale.php';
	include 'booking/book.php';
	include 'booking/conditions.php';
	include 'booking/insurance.php';
	?>

	</div></div>
	<!-- end: customers-main -->
	<div class="customers-right">
		
			<section class="right-section">
				<header><h3>ประวัติการซ่อม</h3></header>
				<div class="content">
					<ul></ul>
				</div>
			</section>
			
			<section class="right-section">
				<header><h3>Files</h3></header>
				<div class="content">
					<ul></ul>
				</div>
			</section>

			<section class="right-section">
				<header><h3>นัดหมาย</h3></header>
				<div class="content">
					<ul></ul>
				</div>
			</section>

			<section class="right-section">
				<header><h3>Notes</h3></header>
				<div class="content">
					<ul></ul>
				</div>
			</section>

		
	</div>

</div>