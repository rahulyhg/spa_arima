<?php 

$tr = '';
$no = 0;
$total_price = 0;

if( !empty($this->booking['lists']) ){

    foreach ($this->booking['lists'] as $key => $item) {
        $no++;

        $tr .= '<tr>'.
        '<td class="status" align="center">'.$no.'.</td>'.
        '<td class="name"><a href="'.URL.'customers/'.$item['cus']['id'].'">'.$item['cus']['fullname'].'</a></td>'.
        '<td class="phone" align="center"><a href="tel:'.$item['cus']['phone'].'">'.$item['cus']['phone'].'</a></td>';
        if( !empty($item['cus']['lineID']) ){
            $tr .= '<td class="social">'.$item['cus']['lineID'].'</td>';
        }
        // '<td class="baht">บาท/baht</td>'.
        $tr .= '</tr>';
    }

    echo '<table class="mtl table-accessory"><tbody>'.

    '<tbody class="income">'. $tr. '</tbody>'.

    '</tbody></table>';

}
else{
    echo '<table class="mtl table-accessory"><tbody><tr><td colspan="3" class="td-empty">ไม่มีรายการ</td></tr></tbody></table>';
}

?>