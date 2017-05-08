<?php
// print_r($this->results);die;
$tr = "";
$tr_total = "";
if( !empty($this->results['lists']) ){ 

    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 

        $status = '';
        foreach ($this->status as $key => $value) {

            $see = '';
            if( $item['status']['id'] == $value['id'] ){
                $see = ' selected="1"';
            }            

            $status .= '<option'.$see.' value="'.$value['id'].'">'.$value['name'].'</option>';
        }

        $status = '<select data-id="'.$item['id'].'" selector name="status" data-plugins="_update" data-options="'.$this->fn->stringify( array('url'=> URL.'promotions/setdata/'.$item['id'].'/status') ).'">'.$status.'</select>';

        $time = '<div class="tac">-</div>';
        if( $item['start_date'] != '0000-00-00 00:00:00' ){
            $time = $this->fn->q('time')->str_event_date($item['start_date'], $item['end_date']);
        }


        $desc = '';
        // $desc .= $item['type']['id'];

        switch ($item['type']['id']) {
            case 'item_amount':
                $desc .= 'ลดราคาต่อชิ้น ชิ้นละ';
                break;

            case 'percent':
                $desc .= 'ลดราคาจากผลรวมทั้งหมด';
                break;
            
            default:
                $desc .= $item['type']['note'];
                break;
        }

        $desc .= ' ' . number_format( $item['discount'], 0 );
        switch ($item['type']['id']) {
            case 'item_amount':
                $desc .= '฿';
                break;

            case 'percent':
                $desc .= '%';
                break;
        }


        if( !empty($item['has_qty']) ){
            $desc .= " เมื่อซื้อสินค้าครบ {$item['qty']} ชิ้น";
        }
          
        // print_r($item['type']['name']);        die();
        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";
        // set Name

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.
            
                
            // '<td class="ID">'. $item['code'] .'</td>'.


            '<td class="name">'.
                '<a class="fwb link-hover" data-plugins="dialog" href="'.URL.'promotions/edit/'.$item['id'].'"><span>'.$item['name'].'</span><i class="icon-pencil mls"></i></a>'.
                '<div class="fsm fcg">'. $desc . '</div>'.
            '</td>'.
            
            '<td class="type">'.$item['type']['name'].
                '<div class="date-float fsm fcg">'.$item['type']['note'].'</div>'.
            '</td>'.

            '<td class="price">'. number_format( $item['discount'], 0 ).'</td>'.
            '<td class="date">'.$time.'</td>'.

            //'<td class="status">'.$item['status']['name'].'</td>'.

            '<td class="status">'.$status.'</td>'.
                
            // '<td class="phone">'.'</td>'.

            // '<td class="note"></td>'.

        '</tr>';
        
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';