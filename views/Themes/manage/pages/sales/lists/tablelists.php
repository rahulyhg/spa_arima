<?php
//print_r($this->results['lists']); die;
$tr = "";
$tr_total = "";

if( !empty($this->results['lists']) ){ 
    //print_r($this->results); die;

    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 
        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";
        // set Name
        //print_r($item);
        /*$updatedTime = strtotime( $item['updated'] );
        $updatedStr = date('j/m/Y', $updatedTime);
        $updatedStr .= '<div class="fsm fcg">' .date('H:i:s').'</div>';*/

        //$updatedStr = $this->fn->q('time')->stamp( $item['updated'] );
    
        $passportStr = '';
        if( !empty($item['options']['passport']) ){

            if( !empty($item['options']['passport']['id']) ){
                $passportStr .= $item['options']['passport']['id'];
            }
            
        }


        if( !empty($item['image_url']) ){
            $image = $this->fn->imageBox($item['image_url'], 48);
        }
        else{
            $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
        }


        $booking = !empty($item['total_booking'])
            ? $item['total_booking']
            : '-';
        
        $finish = !empty($item['total_finish'])
            ? $item['total_finish']
            : '-';
         $cancel= !empty($item['total_cancel'])
            ? $item['total_cancel']
            : '-';


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
        
        

 
//print_r($item['id']); die;
        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.

            '<td class="name">'.

                '<div class="anchor clearfix">'.
                    $image.
                    
                    '<div class="content"><div class="spacer"></div><div class="massages">'.

                        '<div class="fullname"><a class="fwb" href="'.URL .'sales/'.$item['id'].'">'.$item['fullname'].'</a></div>'.

                        '<div class="subname fsm fcg meta">'.$subtext.'</div>'.

                    '</div>'.
                '</div></div>'.

            '</td>'.
                
            '<td class="content">'.$item['pos_name'].'</td>'.
                
             '<td class="status">'. $booking.'</td>'.
                
             '<td class="status">'.$finish.'</td>'.
                
             '<td class="status">'.$cancel.'</td>'.
                
                
                
                

        '</tr>';
        
    }
  
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';