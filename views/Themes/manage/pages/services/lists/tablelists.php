<?php
//print_r($this->results['lists']); die;
$tr = "";
$tr_total = "";
if( !empty($this->results['lists']) ){ 

    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 

        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";
        // set Name    

        $date_repair = date('j/m/Y', strtotime($item['date_repair']));
        $date_repair .= '<div class="fcg fsm">'.date('H:i', strtotime($item['date_repair'])).'</div>';


        $disc = '';
        if( !empty($item['car']['plate']) ){
            $disc .= !empty($disc)? ' · ':'';
            $disc .= '<span class="car-plate">ป้ายทะเบียน '. $item['car']['plate']. '</span>';
        }
        else if( !empty($item['car']['red_plate']) ){
            $disc .= !empty($disc)? ' · ':'';
            $disc .= '<span class="car-plate">ป้ายแดง '. $item['car']['red_plate']. '</span>';
        }

        if( !empty($item['car']['plate']) ){
            $disc .= !empty($disc)? ' · ':'';
            $disc .= '<span class="car-color">สี ' . $item['car']['color_text'] . '</span>';
        }


        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.

            '<td class="date">'.
                $date_repair.
            '</td>'.

            // รถ
            '<td class="name">'. 
                '<strong class="fsm"><a class="fwb" href="'.URL .'services/'.$item['id'].'">'.$item['pro']['name'].'</a></strong>'.
                '<div class="fcg">'. $disc .'</div>'.
            '</td>'.


            // ลูกค้า
            '<td class="content fsm">'.
                '<div class="fcg">เจ้าของ</div><strong>'.$item['cus']['fullname'].'</strong>'.

                ( !empty($item['sender']) 
                    ? '<div class="fcg mts">ผู้ส่งซ่อม</div><strong>'.$item['cus']['fullname'].'</strong>'
                    : ''
                ).
                
            '</td>'.

             // พนักงาน
            '<td class="content fsm">'.
                '<div class="fcg">รับเรื่อง</div><strong>'.$item['emp']['fullname'].'</strong>'.

                ( !empty($item['tec']) 
                    ? '<div class="fcg mts">ช่างซ่อม</div><strong>'.$item['tec']['fullname'].'</strong>'
                    : ''
                ).

            '</td>'.

            // รายการซ่อม
            '<td class="qty"><div class="tac">'. 
                ( !empty($item['total_list']) 
                    ? $item['total_list'].' รายการ'
                    : '-'
                ).
            '</div></td>'.
            
            // ราคาซ่อม
            '<td class="price">'. number_format($item['total_price'], 0) .'</td>'.                
                 
            // status
            '<td class="status">'.( $item['status']['id']=='due'? '<i class="icon-check"></i>':'' ).'</td>'.
            '<td class="status">'.( $item['status']['id']=='run'? '<i class="icon-check"></i>':'' ).'</td>'.
            '<td class="status">'.( $item['status']['id']=='finish'? '<i class="icon-check"></i>':'' ).'</td>'.
            '<td class="status">'.( $item['status']['id']=='cancel'? '<i class="icon-check"></i>':'' ).'</td>'.

        '</tr>';
        
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';