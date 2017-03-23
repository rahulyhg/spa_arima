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


        if( !empty($item['image_url']) ){
            $image = $this->fn->imageBox($item['image_url'], 48);
        }
        else{
            $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
        }


        $qty = !empty($item['total_item'])
            ? $item['total_item']
            : '-';


        $subname = '';

        $express = '';
        if( !empty($item['phone']) ){
            $subname .= !empty($subname) ? ', ':'';
            $subname .= '<i class="icon-phone mrs"></i>' . $item['phone'];

            $express .= '<a href="tel:'.$item['phone'].'" class="btn-icon btn-border mrs"><i class="icon-phone"></i></a>';
        }

        if( !empty($item['email']) ){
            $subname .= !empty($subname) ? ', ':'';
            $subname .= '<i class="icon-envelope-o mrs"></i>' .$item['email'];

            $express .= '<a href="mailto:'.$item['email'].'" class="btn-icon btn-border mrs"><i class="icon-envelope"></i></a>';
        }

        if( !empty($item['lineID']) ){
            $subname .= !empty($subname) ? ', ':'';
            $subname .= 'Line ID: '.$item['lineID'].'<a target="_blank" href="http://line.me/ti/p/~'.$item['lineID'].'"><i class="mls icon-external-link"></i></a>';

            $express .= '<a class="btn-icon btn-border" href="line:'.$item['lineID'].'">Line</a>';
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
                        '<div class="fullname"><a class="fwb" href="'.URL .'customers/'.$item['id'].'">'. $item['fullname'].'</a>'.$age.'</div>'.
                        '<div class="subname fsm meta">'.$subname.'</div>'.
                    '</div>'.
                '</div></div>'.
            '</td>'.

            '<td class="email"><div class="profile-express">'.$express.'</div></td>'.

        '</tr>';
        
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';