<?php
// print_r($this->results);die;
$tr = "";
$tr_total = "";
if( !empty($this->results['lists']) ){ 

    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 

        $desc = '';


        if( !empty($item['has_qty']) ){
            $desc .= " เมื่อซื้อสินค้าครบ {$item['qty']} ชิ้น";
        }
          
        // print_r($item['type']['name']);        die();
        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";
        // set Name

        $status = '<span class="ui-status" style="background-color: rgb(219, 21, 6);">RUN</span>';

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.     
                
            // '<td class="ID">'. $item['code'] .'</td>'.

            '<td class="name">'.
                '<a class="fwb link-hover" data-plugins="dialog" href="'.URL.'package/edit/'.$item['id'].'"><span>'.$item['name'].'</span><i class="icon-pencil mls"></i></a>'.
                '<div class="fsm fcg">'. $desc . '</div>'.
            '</td>'.
            
            '<td class="qty"><div class="tar">'.$item['qty'].'</div></td>'.
            '<td class="unit">'.$item['unit'].'</td>'.

            '<td class="price">'. number_format( $item['price'], 0 ).' ฿</td>'.

            '<td class="status">'.$status.'</td>'.

        '</tr>';
        
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';