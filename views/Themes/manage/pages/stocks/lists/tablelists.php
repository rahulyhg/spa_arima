<?php //print_r($this->results['lists']); die;
$tr = "";
$tr_total = "";

if( !empty($this->results['lists']) ){ 
    //print_r($this->results); die;

    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 
        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";
    
        $passportStr = '';
        if( !empty($item['options']['passport']) ){

            if( !empty($item['options']['passport']['id']) ){
                $passportStr .= $item['options']['passport']['id'];
            }
        }

        if( !empty($item['image_url']) ){
            $image = '<div class="lfloat mrm"><img class="img" src="'.$item['image_url'].'"style="width: 114px;"></div>';
        }
        else{
            $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-car"></i></div></div>';
        }

        $booking = !empty($item['total_booking'])
            ? $item['total_booking']
            : '-';
        
        $finish = !empty($item['.'
            . '0'])
            ? $item['total_finish']
            : '-';
         $cancel= !empty($item['total_cancel'])
            ? $item['total_cancel']
            : '-';

 
//print_r($item['id']); die;
        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.

            '<td class="name">'.

                '<div class="anchor clearfix"><a class="fwb" href="'.URL .'stocks/'.$item['id'].'">'.
                    $image.'</a>'.
                    
                    '<div class="content"><div class="spacer"></div><div class="massages">'.

                        '<div class="fullname"><a class="fwb" href="'.URL .'stocks/'.$item['id'].'">'.$item['name'].'</a></div>'.

                       

                    '</div>'.
                '</div></div>'.

            '</td>'.
                
       
                
            '<td class="status">'. ($item['amount_reservation']==0 ? '-': number_format($item['amount_reservation'])) .'</td>'.
                
            '<td class="status">'. ($item['amount_balance']==0 ? '-': number_format($item['amount_balance'])) .'</td>'.

            '<td class="status">'. ($item['amount_total']==0 ? '-': number_format($item['amount_total'])) .'</td>'.
                
            '<td class="status">'. ($item['amount_order']==0 ? '-': number_format($item['amount_order'])) .'</td>'.
                
             
                
                
                
                

        '</tr>';
        
    }
  
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';