<?php 

$this->skill = array();

$this->skill[] = array('cls'=>'ID2 hr', 'text'=>'HR.', 'id'=>'hr', 'key'=>'mas');
$this->skill[] = array('cls'=>'status vip', 'text'=>'V.I.P.', 'id'=>'vip', 'total'=>0,'has_mas'=>1);

$this->skill[] = array('cls'=>'ID2 bl mas', 'text'=>'NO.', 'id'=>'2', 'key'=>'mas');
$this->skill[] = array('cls'=>'status menu', 'text'=>'นวดตัว', 'id'=>'2', 'total'=>0,'has_mas'=>1);

$this->skill[] = array('cls'=>'ID2 bl mas', 'text'=>'NO.', 'id'=>'4', 'key'=>'mas');
$this->skill[] = array('cls'=>'status menu', 'text'=>'นวดเท้า', 'id'=>'4', 'total'=>0,'has_mas'=>1);

$this->skill[] = array('cls'=>'ID2 bl mas', 'text'=>'NO.', 'id'=>'3', 'key'=>'mas');
$this->skill[] = array('cls'=>'status menu', 'text'=>'นวดหัว', 'id'=>'3', 'total'=>0,'has_mas'=>1);

$this->skill[] = array('cls'=>'ID2 bl mas', 'text'=>'NO.', 'id'=>'8', 'key'=>'mas');
$this->skill[] = array('cls'=>'status menu', 'text'=>'นวด OIL', 'id'=>'8', 'total'=>0,'has_mas'=>1);

$this->skill[] = array('cls'=>'ID2 bl mas', 'text'=>'NO.', 'id'=>'9', 'key'=>'mas');
$this->skill[] = array('cls'=>'status menu', 'text'=>'นวดหน้า', 'id'=>'9', 'total'=>0,'has_mas'=>1);

$this->skill[] = array('cls'=>'ID2 bl mas', 'text'=>'NO.', 'id'=>'5', 'key'=>'mas');
$this->skill[] = array('cls'=>'status menu', 'text'=>'แคะหู', 'id'=>'5', 'total'=>0,'has_mas'=>1);

$this->skill[] = array('cls'=>'ID2 bl mas', 'text'=>'NO.', 'id'=>'6', 'key'=>'mas');
$this->skill[] = array('cls'=>'status menu', 'text'=>'เล็บมือ', 'id'=>'6', 'total'=>0,'has_mas'=>1);

$this->skill[] = array('cls'=>'ID2 bl mas', 'text'=>'NO.', 'id'=>'7', 'key'=>'mas');
$this->skill[] = array('cls'=>'status menu', 'text'=>'เล็บเท้า', 'id'=>'7', 'total'=>0,'has_mas'=>1);

$this->skill[] = array('cls'=>'status bl menu', 'text'=>'SAUNA', 'id'=>'12', 'total'=>0);
$this->skill[] = array('cls'=>'status bl menu', 'text'=>'AKASURI', 'id'=>'13', 'total'=>0);
$this->skill[] = array('cls'=>'status bl menu', 'text'=>'อาบน้ำ', 'id'=>'11', 'total'=>0);
$this->skill[] = array('cls'=>'status bl drink', 'text'=>'DRINK', 'id'=>'drink', 'total'=>0);


$head_left = array();
$head_left[] = array('name'=>'สมาชิก', 'key'=>'member');
// $head_left[] = array('name'=>'พนง.ผู้บริการ', 'key'=> '');
$head_left[] = array('name'=>'เวลา', 'key' => 'start_time');
// $head_left[] = array('name'=>'เวลาออก', 'key' => 'end_time');
$head_left[] = array('name'=>'ห้อง/เตียง', 'key' => 'room_name');

?>
<div class="phl pvm" _data-plugins="TableOrder">
	<div class="mbs clearfix actions-wrap" style="position: absolute;z-index: 10;top: 20px;left: 20px;right: 30px">
		<ul class="lfloat clearfix" role="title">
			<li>	
				<h2><i class="icon-file-text-o"></i><span class="mls">รายรับประจำวัน</span></h2>
				<!-- <div class="fss tar fcg" data->วันพฤหัสบดีที่ 6 มิถุนายน 2562</div> -->
			</li>
		</ul>

		<ul class="lfloat clearfix" role="actions">
			
			<li><div class="help">รีเฟรช</div><span class="gbtn radius"><a class="btn"><i class="icon-refresh"></i></a></span></li>
			<!-- <li><div class="help">เพิ่ม</div><span class="gbtn radius"><a class="btn btn-blue" data-action="create"><i class="icon-plus"></i></a></span></li> -->
		</ul>

		<ul class="lfloat clearfix hidden_elem" role="selection">
			
			<li><div class="help">จ่าย</div><span class="gbtn radius"><a class="btn btn-blue" data-action="create"><i class="icon-thailand-baht"></i></a></span></li>
		</ul>

		<ul class="rfloat clearfix" role="actions">
			<li>
				<span class="fwb">หน้า</span>
				<ul class="ui-pages" role="pages"><?php
	
					for ($i=1; $i <= 1; $i++) { 
						echo '<li data-id="'.$i.'"><span class="gbtn radius"><a class="btn">'.$i.'</a></span></li>';
					}
				?></ul>
			</li>
		</ul>
	</div>
	<div class="table-custom-warp" style="position: absolute;left: 0;right: 0;top: 0;bottom: 0;overflow-y: scroll;">
	
		<!-- head -->
		<div data-table="head_left" style="position: fixed;left: 20px;top: 0;z-index: 5;padding-top: 20px">
			<table class=""><thead>
				<tr>
					<th class="check-box" rowspan="2" data-col="0">ลำดับ</th>
					<th colspan="<?=count($head_left)?>">ข้อมูล</th>
				</tr>
				<tr><?php 
				$c = 0;
				foreach ($head_left as $key => $value) {
					$c++;
					echo '<th data-col="'.$c.'">'.$value['name'].'</th>';
				}
				?></tr>
			</thead></table>
		</div>

		<div data-table="head_middle" style="position: fixed;left: 261px;top: 0;right:100px;z-index: 4;overflow-x: hidden;padding-top: 20px">
			<table style="position: relative;"><thead>
				<tr>
					<th class="tal" colspan="<?=count($this->skill)?>"><div class="plm">รายการ</div></th>
				</tr>
				<tr>
				<?php foreach ($this->skill as $i => $value) { ?>
					<th class="<?=$value['cls']?>" data-col="<?=$i?>"><?=$value['text']?></th>
				<?php } ?>
				</tr>
			</thead></table>
		</div>
		
		<div data-table="head_right" style="position: fixed;right: 30px;top: 0;z-index: 5;padding-top: 20px">
			<table style="width: 70px"><thead>
				<tr>
					<th class="bl" style="height: 42px">รวม</th>
				</tr>
			</thead></table>
		</div>
	
		<!-- end: head -->
		

		<!-- body -->
		<div data-table="body_left" style="padding-top: 43px;position: absolute;top: 20px;left: 20px;">

			<table><tbody>
			<?php for ($i=1; $i <= 20; $i++) { ?>
				<tr data-number="<?=$i?>">
					<td class="tac check-box" data-col="0"><label class="checkbox"><input type="checkbox" name=""><span class="mls"><?=sprintf("%03d",$i)?></span></label></td>
					<?php 
					$c = 0;
					foreach ($head_left as $key => $value) {
						$c++;
						echo '<td data-col="'.$c.'"><div class="inner" data-key="'.$value['key'].'"></div></td>';
					}
					?>
				</tr>
			<?php } ?></tbody></table>		
		</div>
		

		<div data-table="body_middle" style="padding-top: 43px;position: absolute;left: 261px;top: 20px;overflow-x: auto;right:83px;">
			
			<table style="position: relative;"><tbody>
			<?php for ($i=1; $i <= 20; $i++) { ?>
				<tr>
					<?php foreach ($this->skill as $key => $value) { 


					?>
						
					<td class="<?=$value['cls']?> tac" data-package="<?=$value['id']?>" data-col="<?=$key?>"><div class="inner">-</div></td>
					<?php } ?>
				</tr>
			<?php } ?></tbody></table>
		</div>


		<div data-table="body_right" style="position: absolute;right: 13px;top: 20px;z-index: 3;padding-top: 43px;padding-bottom: 40px">
			<table style="width: 70px"><tbody>
				<?php for ($i=1; $i <= 20; $i++) { ?>
				<tr>
					<td class="tac bl"><div class="inner">-</div></td>
				</tr>
				<?php } ?>
			</tbody></table>
		</div>
		<!-- end: body -->
		
		<!-- foot -->
		<div data-table="foot_left" style="position: fixed;left: 20px;bottom: 0;z-index: 5;padding-bottom: 18px">
			<table><tfoot>
				<tr>
					<th class="text">รวมทั้งหมด</th>
				</tr>
			</tfoot></table>
		</div>
		<div data-table="foot_middle" style="position: fixed;left: 261px;bottom: 0;overflow-x: hidden;right:100px;z-index: 4;padding-bottom: 18px">
			<table style="position: relative;"><tfoot>
				<tr>
					<?php 

					$c = 0;
					foreach ($this->skill as $key => $value) {

						if( isset($value['total']) ){
							$cls = $c>0 ? 'bl': '';
							$c++;

							$cls .= isset($value['has_mas']) ? ' has_mas':'';

							echo '<th class="'.$cls.'" data-col="'.$key.'"><div>-</div></th>';
						}
					} ?>
				</tr>
			</tfoot></table>
		</div>

		<div data-table="foot_right" style="position: fixed;right: 30px;bottom: 0;z-index: 5;padding-bottom: 18px">
			<table><tfoot>
				<tr>
					<th class="total bl"><div>0</div></th>
				</tr>
			</tfoot></table>
		</div>
		<!-- end: foot -->
		

		<div data-table="overflowX" style="position: fixed;left: 261px;bottom: 0;overflow-x: auto;right:100px;z-index: 5">
			<table><thead>
				<tr>
					<?php foreach ($this->skill as $key => $value) { ?>
					<th style="padding: 0;border:none;" data-col="<?=$key?>"><div style="height: 1px;overflow: hidden;"><?=$i?></div></th>
					<?php } ?>
				</tr>
			</thead></table>
		</div>


	</div>
</div>