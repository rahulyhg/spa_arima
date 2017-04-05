<?php 

$tr = '';
$no = 0;
$total_price = 0;

if( !empty($this->services['lists']) ){

foreach ($this->services['lists'] as $key => $item) {
    $no++;

    $date_repair = date('j/m/Y', strtotime($item['date_repair']));
    $date_repair .= '<div class="fcg fsm">'.date('H:i', strtotime($item['date_repair'])).'</div>';

    $tr .= '<tr>'.
        '<td class="status" align="center">'.$no.'.</td>'.
        '<td class="date" align="center">'.$date_repair.'</td>'.
        '<td class="name"><a href="'.URL.'services/'.$item['id'].'">'.$item['pro']['name'].'</a>'.
        '<br/>สี : '.$item['car']['color_text'].
        '</td>'.
        '<td class="status" align="center">'.$item['status']['name'].'</td>'.
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