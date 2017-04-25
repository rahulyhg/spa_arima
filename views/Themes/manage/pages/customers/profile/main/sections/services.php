<?php 

$tr = '';
$no = 0;
$total_price = 0;

if( !empty($this->car['lists']) ){

foreach ($this->car['lists'] as $key => $value) {
    $no++;
    $tr .= '<tr>'.
        '<td class="status" align="center">'.$no.'.</td>'.
        '<td class="name"><div><span class="fwb">'.$value['pro']['name'].'</div>'.
            '<span class="fwb">สี</span> : '.$value['color']['text'].
        '</td>'.
        '<td class="status">'.
        '   <div><span class="fwb">เลขตัวถัง</span> : '.$value['VIN'].'</div>'.
            '<span class="fwb">เลขเครื่องยนต์</span> : '.$value['engine'].
        '</td>'.
        // '<td>'.
        //     '<div><span class="fwb">ทะเบียน</span> : '.$value['plate'].'</div>'.
        //     '<span class="fwb">ทะเบียน(ป้ายแดง)</span> : '.$value['red_plate'].'</div>'.
        // '</td>'.
        // '<td class="baht">บาท/baht</td>'.
    '</tr>';
}

echo '<table class="mtl table-accessory"><tbody>'.

    '<tbody class="income">'. $tr. '</tbody>'.

'</tbody></table>';
}
else{
    echo '<table class="mtl table-accessory"><tbody><tr><td colspan="3" class="td-empty">ไม่มีรายการ</td></tr></tbody></table>';
}

?>