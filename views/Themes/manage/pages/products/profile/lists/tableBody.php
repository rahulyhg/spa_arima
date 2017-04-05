<?php

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

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.

            // '<td class="bookmark"><a class="ui-bookmark js-bookmark'.( $item['bookmark']==1 ? ' is-bookmark':'' ).'" data-value="" data-id="'.$item['id'].'" stringify="'.URL.'customers/bookmark/'.$item['id']. (!empty($this->hasMasterHost) ? '?company='.$this->company['id']:'') .'"><i class="icon-star yes"></i><i class="icon-star-o no"></i></a></td>'.
            '<td class="image">'.
                '<span class="ui-color" title="'.$item['color_name'].'" style="background-color:'.$item['color_primary'].';width:50px;height:50px;"></span>'.
            '</td>'.


            '<td class="name">'.

                '<h3>'.$item['vin'].'</h3>'.
                '<div class="fsm fcg"><strong>VIN: </strong>'.$item['vin'].'</div>'.

            '</td>'.

   
            '<td class="status">'.
                '<span class="btn btn-status" style="min-width:120px;background-color:'.$item['status_arr']['color'].';color:#fff">'.$item['status_arr']['name'].'</span>'.
            '</td>'.
            '<td class="actions whitespace">';

            if( $item['status_arr']['id'] != 'sold' ){

                if( $this->me['id'] == $item['act']['emp_id'] || !empty($this->permit['stocks']['edit']) ){
                    $tr .='<span class="gbtn"><a data-plugins="dialog" href="'.URL.'products/edit_item/'.$item['id'].'" class="btn btn-no-padding"><i class="icon-pencil"></i></a></span>';
                }

                if( $this->me['id'] == $item['act']['emp_id'] || !empty($this->permit['stocks']['del']) ){
                    $tr .='<span class="gbtn"><a data-plugins="dialog" href="'.URL.'products/del_item/'.$item['id'].'" class="btn btn-no-padding"><i class="icon-trash"></i></a></span>';
                }
            }

            $tr.='</td>'.
        '</tr>';
        
    }
}

$table = '<table class="settings-table"><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';