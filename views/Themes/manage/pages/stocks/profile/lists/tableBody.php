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

        $image = '';
        if( !empty($item['image_url']) ){
            $image = '<div class="avatar lfloat mrm"><img class="img" src="'.$item['image_url'].'" alt="'.$item['fullname'].'"></div>';
        }
        else{
            $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
        }

        $subtext = '';
        $express = '';
        if( !empty($item['phone_number']) ){
            $subtext .= !empty($subtext) ? ', ':'';
            $subtext.='<i class="icon-phone mrs"></i>'. $item['phone_number'];

            $express .= '<a href="tel:'.$item['phone_number'].'" class="btn-icon btn-border mrs"><i class="icon-phone"></i></a>';
        }

        if( !empty($item['email']) ){
            $subtext .= !empty($subtext) ? ', ':'';
            $subtext.='<i class="icon-envelope-o mrs"></i>'. $item['email'];

             $express .= '<a href="mailto:'.$item['email'].'" class="btn-icon btn-border mrs"><i class="icon-envelope"></i></a>';
        }

        if( !empty($item['line_id']) ){
            $subtext .= !empty($subtext) ? ', ':'';
            $subtext .= '<a target="_blank" href="http://line.me/ti/p/~'.$item['line_id'].'"><i class="mls icon-external-link"></i> '.$item['line_id'].'</a>';

            $express .= '<a class="btn-icon btn-border" href="line:'.$item['line_id'].'">Line</a>';
        }


        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            '<td class="name">'.

                '<a href="'.URL.'products/'.$item['id'].'"><h3>'.$item['name'].'</h3></a>'.
                '<div class="fsm fcg">'.
                    '<span><strong>cc: </strong>'.$item['cc'].'</span>'.
                    ' · <span><strong>mfy: </strong>'.$item['mfy'].'</span>'.
                '</div>'.

            '</td>'.
            '<td class="qty">'.$item['mfy'].'</td>'.

            '<td class="price">'.( !empty($item['price']) ? number_format($item['price']):'-' ).'</td>'.

                
            '<td class="status">'.( !empty($item['booking']) ? number_format($item['booking']):'-' ).'</td>'.

            '<td class="status">'.( !empty($item['balance']) ? number_format($item['balance']):'-' ).'</td>'.
            
            '<td class="status">'.( !empty($item['subtotal']) ? number_format($item['subtotal']):'-' ).'</td>'.
            
            '<td class="status">'.( !empty($item['order_total']) ? number_format($item['order_total']):'-' ).'</td>'.
                
           
        '</tr>';
        
    }
}

$table = '<table class="settings-table"><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';