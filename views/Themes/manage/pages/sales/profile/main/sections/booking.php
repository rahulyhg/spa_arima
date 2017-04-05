<?php 

$tr = '';
$no = 0;
$total_price = 0;

if( !empty($this->booking['lists']) ){

foreach ($this->booking['lists'] as $key => $item) {
    $no++;

    $date = date('j/m/Y', strtotime($item['date']));
    $date .= '<div class="fcg fsm">'.date('H:i', strtotime($item['date'])).'</div>';

    $tr .= '<tr>'.
        '<td class="status" align="center">'.$no.'.</td>'.
        '<td class="date">'.$date.'</td>'.
        '<td class="name"><a href="'.URL.'booking/'.$item['id'].'">'.$item['pro']['name'].'</a>'.
        '<br/>สี : '.$item['color']['name'].
        '</td>'.
        '<td class="status"><a href="'.URL.'customers/'.$item['cus']['id'].'">'.$item['cus']['fullname'].'</a>
        <br/>โทร : <a href="tel:'.$item['cus']['phone'].'">'.$item['cus']['phone'].'</a></td>'.
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