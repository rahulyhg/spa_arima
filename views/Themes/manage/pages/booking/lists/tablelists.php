<?php
//print_r($this->results['lists']); die;
$tr = "";
$tr_total = "";
$sum = array(0,0,0);
if( !empty($this->results['lists']) ){ 

    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 


        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";
        // set Name

        $time = strtotime( $item['date'] );
        $dateStr = date('j', $time) .' ' . $this->fn->q('time')->month( date('n', $time) ) .' '. ( date('Y', $time)+543 );
        // $dateStr .= '<div class="fsm fcg">' .date('H:i:s').'</div>';
        $status_td = '';
        foreach ($this->status as $key => $val) {
            $status_check = 0;
            if( $val['id'] == $item['status']['id'] ){
                $status_check = 1;
                $sum[$key]++;
            }
            $status_td .= '<td class="status">'.( $status_check ? '<i class="icon-check"></i>':'' ).'</td>';
        }

        /**/
        /* Customer */
        /**/
        $subtext = '';
        if( !empty($item['cus']['image_url']) ){
            $image = $this->fn->imageBox($item['cus']['image_url'], 48);
        }
        else{
            $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
        }

        if( !empty($item['cus']['phone']) ){
            $subtext .= !empty($subtext) ? ', ':'';
            $subtext.='<i class="icon-phone mrs"></i>'. $item['cus']['phone'];
        }

        /**/
        /* Sale */
        /**/
        $subtext_sale = '';
        if( !empty($item['sale']['image_url']) ){
            $image_sale = $this->fn->imageBox($item['sale']['image_url'], 48);
        }
        else{
            $image_sale = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
        }

        if( !empty($item['sale']['phone_number']) ){
            $subtext_sale .= !empty($subtext_sale) ? ', ':'';
            $subtext_sale.='<i class="icon-phone mrs"></i>'. $item['sale']['phone_number'];
        }

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.

            '<td class="date">'. $dateStr .'</td>'.

            '<td class="name">'.
                '<div class="anchor clearfix">'.
                $image.
                    '<div class="content"><div class="spacer"></div><div class="massages">'.
                        '<div class="fullname"><a class="fwb" href="'.URL.'booking/'.$item['id'].'">'.$item['cus']['fullname'].'</a></div>'.
                        '<div class="subname fsm fcg meta">'.$subtext.'</div>'.
                    '</div>'.
                '</div></div>'.
            '</td>'.

            '<td class="email">'.$item['model']['name'].'</td>'.

            '<td class="email">'.
                    $item['product']['name'].
                    '<div class="subname fsm fcg meta"><label style="background-color:#'.$item['color']['primary'].'">  </label> '.$item['color']['name'].'</div>'.
            '</td>'.

            '<td class="content">'.
                '<div class="anchor clearfix">'.
                $image_sale.
                    '<div class="content"><div class="spacer"></div><div class="massages">'.
                        '<div class="fullname"><a class="fwb" href="'.URL.'sales/'.$item['sale']['id'].'">'.$item['sale']['fullname'].'</a></div>'.
                        '<div class="subname fsm fcg meta">'.$subtext_sale.'</div>'.
                    '</div>'.
                '</div></div>'.
            '</td>'.

            $status_td.

        '</tr>';
        
    }

    $status_th = '';
    foreach ($sum as $value) {
        $status_th .= '<th class="status">'.($value == 0 ? '-':$value).'</th>';
    }

    $tr_total = '<tfoot><tr>'.
                    '<th colspan="5"><div class="tar">รวม</div></th>'.
                    $status_th.
                '</tr></tfoot>';

}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';