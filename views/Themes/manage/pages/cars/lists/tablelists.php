<?php

$tr = "";
$tr_total = "";
if( !empty($this->results['lists']) ){ 

    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 
          
       // print_r($item);        die();
        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";
        // set Name

        /*$updatedTime = strtotime( $item['updated'] );
        $updatedStr = date('j/m/Y', $updatedTime);
        $updatedStr .= '<div class="fsm fcg">' .date('H:i:s').'</div>';*/

        $updatedStr = $this->fn->q('time')->stamp( $item['updated'] );
       

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
            $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-car"></i></div></div>';
        }


        $qty = !empty($item['total_item'])
            ? $item['total_item']
            : '-';


        $subname = '';

        $express = '';
        if( !empty($item['cus_phone']) ){
            $subname .= !empty($subname) ? ', ':'';
            $subname .= '<i class="icon-phone mrs"></i>' . $item['cus_phone'];

            $express .= '<a href="tel:'.$item['cus_phone'].'" class="btn-icon btn-border mrs"><i class="icon-phone"></i></a>';
        }

        if( !empty($item['cus_email']) ){
            $subname .= !empty($subname) ? ', ':'';
            $subname .= '<i class="icon-envelope-o mrs"></i>' .$item['cus_email'];

            $express .= '<a href="mailto:'.$item['cus_email'].'" class="btn-icon btn-border mrs"><i class="icon-envelope"></i></a>';
        }

        if( !empty($item['cus_lineID']) ){
            $subname .= !empty($subname) ? ', ':'';
            $subname .= 'Line ID: '.$item['cus_lineID'].'<a target="_blank" href="http://line.me/ti/p/~'.$item['cus_lineID'].'"><i class="mls icon-external-link"></i></a>';

            $express .= '<a class="btn-icon btn-border" href="line:'.$item['cus_lineID'].'">Line</a>';
        }

       
        $item['bookmark'] = 0;

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.
            
                
            '<td class="bookmark"><a class="ui-bookmark js-bookmark'.( $item['bookmark']==1 ? ' is-bookmark':'' ).'" data-value="" data-id="'.$item['id'].'" stringify="'.URL.'customers/bookmark/'.$item['id']. (!empty($this->hasMasterHost) ? '?company='.$this->company['id']:'') .'"><i class="icon-star yes"></i><i class="icon-star-o no"></i></a></td>'.


            '<td class="name">'.

                '<div class="anchor clearfix">'.
                    $image.
                    
                    '<div class="content"><div class="spacer"></div><div class="massages">'.

                        '<div class="fullname"><a class="fwb" href="'.URL .'cars/'.$item['id'].'">'. $item['pro_name'].'</a></div>'.

                       

                    '</div>'.
                '</div></div>'.

            '</td>'.
            
                '<td class="status">'.
                        '<div class="fullname">'. $item['license_plate'].'</div>'.
                  '</td>'.
                
                '<td class="email">'.
                        '<div class="fullname">'. $item['cus_fullname'].'</div>'.
                         '<div class="subname fsm meta">'.$subname.'</div>'.
                '</td>'.

            '<td class="email"><div class="profile-express">'.$express.'</div></td>'.

            '<td class="status">'. $updatedStr. '</td>'.

        '</tr>';
        
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';