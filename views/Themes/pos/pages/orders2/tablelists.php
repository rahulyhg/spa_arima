<?php

$tr = "";
$tr_total = "";




    $seq = 0;
    for ($i=0; $i < 20; $i++) { 
        # code...
    }
  
        $cls = $i%2 ? 'even' : "odd";
        // set Name

        if( !empty($item['image_url']) ){
            $image = '<div class="avatar lfloat mrm"><img src="'.$item['image_url'].'"></div>';
        }
        else{
            $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
        }

        $total = 0;
        $skill = '';
        foreach ($this->skill as $index => $val) {

            $txt = '';

            if( $val['id']=='hr' ){

            }
            else if( $val['id']=='vip' ){
                $txt = $item['room_price'];

                $this->skill[$index]['total'] += $txt;
                $total += $txt;
                $txt = $txt==0 ? '-':number_format($txt, 0);
            }
            else if( $val['id']=='drink' ){
                $txt = $item['drink'];

                $this->skill[$index]['total'] += $txt;
                $total += $txt;
                $txt = $txt==0 ? '-':number_format($txt, 0);
            }
            else {

                if( $val['text']=='NO.' ){

                }
                else{
                    $txt = 0;
                    foreach ($item['items'] as $pack) {
                        if( $pack['pack']['id'] == $val['id']) {
                            $txt += $pack['balance'];
                        }
                    }

                    $this->skill[$index]['total'] += $txt;
                    $total += $txt;
                    $txt = $txt==0 ? '-':number_format($txt, 0);
                }
            }

           
            $checked = false;
            $skill .= '<td class="'.$val['key'].'">'.$txt.'</td>';
        }
        

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.
            
                
            '<td class="ID">'.
                '<div>'. sprintf("%03d",$item['number']) .'</div>'.
                '<div class="ui-status">'.$item['status'].'</div>'.
            '</td>'.

            '<td class="name">'.

                '<ul class="fsm">'.
                    '<li><a><label>สมาชิก</label> <span>-</span></a></li>'.
                    '<li><a><label>เวลา</label> <span>-</span></a></li>'.
                    // '<li><a><label>ห้อง/เตียง</label> <span>-</span></a></li>'.
                '<ul>'.

            '</td>'.
            
            // '<td class="status">'. $item['nickname'].'</div>'. '</td>'.
                
            $skill.

            // '<td class="phone"></td>'.

            '<td class="balance">'.number_format($total).'</td>'.

        '</tr>';
        
    } // end for


    $skill = '';
    $total = 0;
    foreach ($this->skill as $val) {

        $checked = false;

        if( $val['key']=='ID2 bl' ){
            continue;
        }

        $colspan = '';
        if( $val['key']=='status' ){
            $colspan = ' colspan="2"';
        }

        $total += $val['total'];
        $txt = $val['total']==0 ? '-':number_format($val['total']);

        $skill .= '<td'.$colspan.' class="'.$val['key'].'">'.$txt.'</td>';
    }

    $tr_total = '<tbody ref="insert"></tbody>';

    $tr_total .= '<tfoot><tr class="total">'.

        '<td class="check-box nobody"></td>'.
        '<td class="ID nobody"></td>'.
        '<td class="tar nobody">'.'ยอดรวม'.'</td>'.
        $skill.
        '<td class="balance">'.number_format($total, 0).'</td>'.

    '</tr></tfoot>';
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';