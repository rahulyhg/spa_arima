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


        if( !empty($item['image_url']) ){
            $image = '<div class="avatar lfloat mrm"><img src="'.$item['image_url'].'"></div>';
        }
        else{
            $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
        }

        $fullname = $item['fullname'];

        if( !empty($this->permit['employees']['edit']) ){
            $fullname = '<a class="fwb" data-plugins="dialog" href="'.URL .'employees/edit/'.$item['id'].'">'. $item['fullname'].'</a>';
        }

        $updatedTime = strtotime( $item['updated'] );
        $updatedStr = date('j', $updatedTime) .' ' . $this->fn->q('time')->month( date('n', $updatedTime) ) .' '. ( date('Y', $updatedTime)+543 );
        $updatedStr .= '<div class="fsm fcg">' .date('H:i', $updatedTime).'</div>';


        if( !empty($item['nickname']) ){
            $fullname.=" <span class=\"fwn\">({$item['nickname']})</span>";
        }

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.
            
            '<td class="name">'.

                '<div class="anchor clearfix">'.
                    $image.
                    '<div class="content"><div class="spacer"></div><div class="massages">'.
                        '<div class="fullname">'.$fullname.'</div>'.
                    '</div>'.
                '</div></div>'.

            '</td>'.
            
            '<td class="status">'. $item['dep_name'].'</td>'.
            '<td class="status">'. $item['pos_name'].'</td>'.

            '<td class="phone">'.$item['phone_number'].'</td>'.
            '<td class="phone">'.$item['line_id'].'</td>'.

            '<td class="date">'.$this->fn->q('time')->live( $item['updated'] ).'</td>'.

        '</tr>';
        
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';