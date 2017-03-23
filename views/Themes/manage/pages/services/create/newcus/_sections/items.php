<?php 

$form = new Form();
$form = $form->create()
	// set From
	->elem('div');


$form   ->field("items")
        ->text('note[]')
        // ->label( 'รายการซ่อม' )
        ->text('<div class="lists-items">

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
                    <td class="data TOTAL">฿<span summary="total-price">0</span></td>
                </tr>
               	
            </tbody></table>
        </td>
    </tr>
</tbody></table>

</div>');

$form   ->hr('<div class="clearfix">'.
    '<div class="lfloat"><a class="btn js-prev">กลับ</a></div>'.
    '<div class="rfloat"><a class="btn btn-blue js-next" data-type="items">ต่อไป</a></div>'.
'</div>');

echo $form->html();