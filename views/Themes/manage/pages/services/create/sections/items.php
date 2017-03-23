<?php 

$form = new Form();
$form = $form->create()
	// set From
	->elem('div');

$form   ->field("service_tec_id")
        ->name('service[tec_id]')
        ->label( 'ช่างซ่อม' )
        ->addClass('inputtext w-auto')
        ->type('select')
        ->select( $this->tec, 'id', 'fullname' );

$form   ->field("items")
        ->text('note[]')
        // ->label( 'รายการซ่อม' )
        ->text('<div class="lists-items" role="listsitems">

<table class="lists-items-listbox">
	<thead>
	<tr>				
		<th class="no">No.</th>
		<th class="type">ประเภทการซ่อม</th>
        <th class="price">ราคา</th>
		<th class="actions"></th>
	</tr>
	</thead>
	<tbody role="listsitem"></tbody>
</table>

<table class="lists-items-summary"><tbody>
    <tr>
        <td class="colleft">
            <table></table>
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

</div>');

$form   ->field("service_note")
        ->type('textarea')
        ->name('service[note]')
        ->label( 'หมายเหตุ' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

$section .= $form->html();