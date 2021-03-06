<?php

$tr = "";
$tr_total = "";
if( !empty($this->results['lists']) ){ 

    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 


        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";
        // set Name

        /*$updatedTime = strtotime( $item['updated'] );
        $updatedStr = date('j/m/Y', $updatedTime);
        $updatedStr .= '<div class="fsm fcg">' .date('H:i:s').'</div>';*/

        $created = strtotime( $item['created'] );
        $createdStr = date('j', $created) .' ' . $this->fn->q('time')->month( date('n', $created) ) .' '. ( date('Y', $created)+543 );
       
        $passportStr = '';
        if( !empty($item['options']['passport']) ){

            if( !empty($item['options']['passport']['id']) ){
                $passportStr .= $item['options']['passport']['id'];
            }
            
        }

        $image = '';
        if( !empty($item['image_url']) ){
            $image = '<div class="avatar lfloat mrm"><img class="img" src="'.$item['image_url'].'" alt="'.$item['fullname'].'"></div>';
        }
        else{
            $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
        }

        $qty = !empty($item['total_item'])
            ? $item['total_item']
            : '-';


        $subtext = '';
        $express = '';
        if( !empty($item['phone']) ){
            $subtext .= !empty($subtext) ? ', ':'';
            $subtext.='<i class="icon-phone mrs"></i>'. $item['phone'];

            $express .= '<li><i class="icon-phone mrs"></i><a href="tel:'.$item['phone'].'">'.$item['phone'].'</a></li>';
        }

        if( !empty($item['email']) ){
            $subtext .= !empty($subtext) ? ', ':'';
            $subtext.='<i class="icon-envelope-o mrs"></i>'. $item['email'];

             $express .= '<li><i class="icon-envelope mrs"></i><a href="mailto:'.$item['email'].'" title="'.$item['email'].'">'.$item['email'].'</a></li>';
        }

        if( !empty($item['lineID']) ){
            $subtext .= !empty($subtext) ? ', ':'';
            $subtext .= '<a target="_blank" href="http://line.me/ti/p/~'.$item['lineID'].'"><i class="mls icon-external-link"></i> '.$item['lineID'].'</a>';

            $express .= '<li>Line ID: <a href="line:'.$item['lineID'].'">'.$item['lineID'].'</a></li>';
        }

        $age = '';
        if( $item['birthday'] !='0000-00-00' ){
            $age = '<span class="fsm fwn mls meta">(อายุ '.$this->fn->q('time')->age( $item['birthday'] ).' ปี)</sapn>';
        }


        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.

            '<td class="date">'. $createdStr. '</td>'.

            '<td class="name">'.
                '<div class="anchor clearfix">'.
                    $image.
                    '<div class="content"><div class="spacer"></div><div class="massages">'.
                        '<div class="fullname"><a class="fwb" href="'.URL .'customers/'.$item['id'].'">'. $item['fullname'].'</a></div>'.
                        // '<div class="subname fsm meta">'.$subname.'</div>'.
                    '</div>'.
                '</div></div>'.
            '</td>'.

            '<td class="express"><ul class="fsm">'.$express.'</ul></td>'.

            '<td class="status">'.(!empty($item['total_car']) ? $item['total_car'] : '-').'</td>'.

            '<td class="status">'.(!empty($item['total_booking']) ? $item['total_booking'] : '-').'</td>'.

            '<td class="status">'.(!empty($item['total_cancel']) ? $item['total_cancel'] : '-').'</td>'.

        '</tr>';
        
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';