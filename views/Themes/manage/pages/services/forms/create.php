<?php 

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('');


$fieldname = array();
$fieldname[] = array( 
    'id' => 'cus_prefix_name', 
    'name' => 'cus[prefix_name]', 
    'label' => 'คำนำหน้าชื่อ',
    'type' => 'select',
    'options' => $this->prefixName
);

$fieldname[] = array( 
    'id' => 'cus_first_name', 
    'name' => 'cus[first_name]', 
    'label' => 'ชื่อ',
);

$fieldname[] = array( 
    'id' => 'cus_last_name', 
    'name' => 'cus[last_name]', 
    'label' => 'นามสกุล',
);

$fieldname[] = array( 
    'id' => 'cus_nickname', 
    'name' => 'cus[nickname]', 
    'label' => 'ชื่อเล่น',
);

$form   ->field("cus_name")
        ->label('ข้อมูลเจ้าของรถ')
        ->text( '<div class="u-table"><div class="u-table-row">'.$this->fn->uTableCell($fieldname).'</div></div>' );

$form   ->field("cus_mobile_phone")
        ->name('cus[mobile_phone]')
        ->label( 'เบอร์มือถือ' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->field("cus_tel")
        ->name('cus[tel]')
        ->label( 'โทรศัพท์บ้าน/ทำงาน' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->field("cus_line_id")
        ->name('cus[line_id]')
        ->label( 'Line ID' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

// ที่อยู่
$address = array( 0=> 

	array( 0 => 
		array(
			'id' => 'address_number', 
		    'name' => 'address[number]', 
		    'label' => 'บ้านเลขที่',
		),
		array(
			'id' => 'address_mu', 
		    'name' => 'address[mu]', 
		    'label' => 'หมู่ที่',
		),
		array(
			'id' => 'address_village', 
		    'name' => 'address[village]', 
		    'label' => 'หมู่บ้าน',
		),
		array(
			'id' => 'address_alley', 
		    'name' => 'address[alley]', 
		    'label' => 'ซอย',
		),
	),

	array( 0 => 
		array(
			'id' => 'address_street', 
		    'name' => 'address[street]', 
		    'label' => 'ถนน',
		),
		array(
			'id' => 'address_district', 
		    'name' => 'address[district]', 
		    'label' => 'แขวง/ตำบล',
		),
		array(
			'id' => 'address_amphur', 
		    'name' => 'address[amphur]', 
		    'label' => 'เขต/อำเภอ'
		),
	),

	array( 0 => 
		array(
			'id' => 'address_city', 
		    'name' => 'address[city]', 
		    'label' => 'จังหวัด',
		    'type' => 'select',
		    'options' => $this->city['lists'],
		    'value' => 1
		),
		array(
			'id' => 'address_zip', 
		    'name' => 'address[zip]', 
		    'label' => 'รหัสไปรษณีย์'
		),
	),
);

$form   ->field("cus_address")
        ->name('cus[address]')
        ->label('ที่อยู่')
        ->text( $this->fn->uTableAddress($address) );

$form->hr('<div class="clearfix"></div>');

$fieldcar[] = array( 
    'id' => 'cus_prefix_name', 
    'name' => 'cus[prefix_name]', 
    'label' => '',
    'type' => 'select',
    'options' => $this->prefixName
);

$fieldcar[] = array( 
    'id' => 'cus_first_name', 
    'name' => 'cus[first_name]', 
    'label' => '',
);

$fieldcar[] = array( 
    'id' => 'cus_nickname', 
    'name' => 'cus[nickname]', 
    'label' => 'สี/Color',
);


$form   ->field("receiver_name")
        ->label('รถยนต์รุ่น/Model')
        ->text( $this->fn->uTableCell($fieldcar) );

$form   ->field("car_VIN")
        ->name('car[VIN]')
        ->label( 'VIN(เลขตัวถัง)' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->field("car_engine")
        ->name('car[engine]')
        ->label( 'เลขเครื่องยนต์' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form->hr('<div class="clearfix"></div>');

$form   ->field("car_license_plate")
        ->name('car[license_plate]')
        ->label( 'ป้ายทะเบียนรถ' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$form   ->field("car_mile")
        ->name('car[mile]')
        ->label( 'ไมล์รถ' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');


?><form class="form-insert form-orders" action="<?=URL?>orders/send/">

	<div class="datalist-main-header">
		<div class="clearfix">
			<div class="rfloat">
		          <span class="gbtn mrm"><a title="Cancel" class="btn js-cancel"><i class="icon-remove mrs"></i>ยกเลิก</a></span>
		    </div>

			<div class="title">
				<h2><i class="icon-file-text-o mrs"></i>New Order</h2>
			</div>
		</div>
		<div class="mts"><?php require 'sections/date.php'; ?></div>
	</div>
	<!-- slipPaper-header -->

	<div class="datalist-main-content">

		<div class="slipPaper-main">

		<div class="slipPaper-content clearfix">

			<div class="slipPaper-bodyHeader clearfix">
				<?= $form->html() ?>
			</div>
			<!-- end: slipPaper-bodyHeader -->
			
			<fieldset id="items_fieldset" class="control-group mtm">
			<label for="order_cus_name" class="control-label slipPaper-label">รายการซ่อม</label>

			<div class="controls">
			<div class="slipPaper-bodyContent">

				<table>
					<thead>
					<tr>				
						<th class="no">No.</th>
						<th class="type">ประเภทการซ่อม</th>
                        <th class="price">ราคา</th>
						<th></th>
					</tr>
					</thead>
					<tbody role="listsitem"></tbody>
				</table>
				<div class="clearfix mvs mhl tac">
					<span class="gbtn"><a class="btn js-add-item btn-no-padding"><i class="icon-plus"></i></a></span>
				</div>
				
			</div>
			<!-- end: slipPaper-bodyContent -->

			<div class="slipPaper-bodyFooter">
				<div class="slipPaper-bodyFooter-summary-wrap">
				<table class="slipPaper-bodyFooter-summary mvm"><tbody>
                    <tr>
                        <td class="colleft">
                            <table>
                                <!-- <tr>
                                    <td class="label">ค่าบริการ:</td>
                                    <td class="data">฿<span summary="service-text">0</span></td>
                                </tr> -->
                            </table>
                        </td>
                        <td class="colright">
                            <table><tbody>
                               
                                <tr>
                                    <td class="label">TOTAL:</td>
                                    <td class="data TOTAL">฿<span summary="total">0</span></td>
                                </tr>
                               	
                            </tbody></table>
                        </td>
                    </tr>
				</tbody></table>
				</div>
			</div>
			<!-- end: slipPaper-bodyFooter -->

			<div class="notification"></div>
			</div>
			
			
			</fieldset>
			<!-- end: items -->

			<!-- order_note -->
			<fieldset id="note_license_plate_fieldset" class="control-group"><label for="order_note" class="control-label">หมายเหตุ</label><div class="controls"><textarea id="order_note" name="order[note]" autocomplete="off" class="inputtext"></textarea><div class="notification"></div></div></fieldset>
			<!-- end: order_note -->

		</div>
		<!-- end: slipPaper-content -->

		<div class="slipPaper-footer">
			
			<div class="pay button">
                <span class="gbtn radius large"><a class="btn btn-blue btn-submit js-done _disabled"><i class="icon-save"></i></a></span>
                <span class="t">Save</span>
            </div>
		</div>
		<!-- end: slipPaper-footer -->

		</div>
		<!-- slipPaper-main -->

	</div>
	<!-- end: datalist-main-content -->

</form>
<!-- end: slipPaper -->