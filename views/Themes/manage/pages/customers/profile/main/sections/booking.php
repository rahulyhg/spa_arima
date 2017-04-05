<?php 

$tr = '';
$no = 0;
$total_price = 0;

if( !empty($this->booking['lists']) ){

foreach ($this->booking['lists'] as $key => $value) {
    $no++;
    $tr .= '<tr>'.
        '<td class="status" align="center">'.$no.'.</td>'.
        '<td class="name"><a href="'.URL.'booking/'.$value['id'].'">'.$value['pro']['name'].'</a>'.
        '<br/>สี : '.$value['color']['name'].
        '</td>'.
        '<td class="status" align="center">'.$value['status']['name'].'</td>'.
        // '<td class="baht">บาท/baht</td>'.
    '</tr>';
}

echo '<table class="mtl table-accessory">'.

    '<tbody class="income">'. $tr. '</tbody>'.

'</table>';
}
else{
    echo '<table class="mtl table-accessory"><tbody><tr><td colspan="3" class="td-empty">ไม่มีรายการ</td></tr></tbody></table>';
}

?>