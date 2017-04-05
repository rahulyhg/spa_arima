<?php 

$arr['title']= "แก้ไขรายการซ่อม";
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
$arr['hiddenInput'][] = array('name'=>'type','value'=>'options');

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert pal');

$options = '';
$no = 0;
foreach ($this->item['options'] as $key => $value) {
    $no++;
    $options .= '<tr>
                    <td class="no">'.$no.'</td>
                    <td class="type"><input type="text" name="items[name][]" class="inputtext" autocomplete="off" value="'.$value['name'].'"></td>
                    <td class="price"><input type="text" name="items[value][]" class="inputtext js-change-item input-price" autocomplete="off" value="'.$value['value'].'"></td>
                    <td class="actions">
                        <button type="button" class="i-btn-a1 js-add-item"><i class="icon-plus"></i></button>
                        <button type="button" class="i-btn-a1 js-remove-item"><i class="icon-remove"></i></button>
                    </td>
                </tr>';
}

$tr = '<div class="lists-items" role="listsitems">

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
                '.$options.'
                <tr>
                    <td class="label">TOTAL:</td>
                    <td class="data TOTAL">฿<span summary="total">0</span></td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

</div>';
foreach ($this->item['options'] as $key => $value) {
    
}

$form   ->field("service_options")
        ->label('รายการซ่อม')
        ->text($tr);

$form   ->field("service_note")
        ->type('textarea')
        ->label( 'หมายเหตุ' )
        ->autocomplete('off')
        ->addClass('inputtext')
        ->value('');

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'services/update"></form>';


# body
$arr['body'] = $form->html();

$arr['width'] = 720;
$arr['height'] = 'full';
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);