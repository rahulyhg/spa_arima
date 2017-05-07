<?php
// print_r($this->results);die;
$tr = "";
$tr_total = "";
if( !empty($this->results['lists']) ){ 

    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 

        $status = '';
        foreach ($this->status as $key => $value) {

            $see = '';
            if( $item['status']['id'] == $value['id'] ){
                $see = ' selected="1"';
            }            

            $status .= '<option'.$see.' value="'.$value['id'].'">'.$value['name'].'</option>';
        }

        $status = '<select data-id="'.$item['id'].'" selector name="status" data-plugins="_update" data-options="'.$this->fn->stringify( array('url'=> URL.'promotions/setdata/'.$item['id'].'/status') ).'">'.$status.'</select>';

        $time = 'ไม่มีกำหนด';
        if( $item['start_date'] != '0000-00-00 00:00:00' ){
            $time = $this->fn->q('time')->str_event_date($item['start_date'], $item['end_date']);
        }
          
        // print_r($item['type']['name']);        die();
        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";
        // set Name

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.
            
                
            // '<td class="ID">'. $item['code'] .'</td>'.


            '<td class="name"><a data-plugins="dialog" href="'.URL.'promotions/edit/'.$item['id'].'">'.$item['name'].'</a></td>'.
            
            '<td class="type">'.$item['type']['name'].
                '<div class="date-float fsm fcg">'.$item['type']['note'].'</div>'.
            '</td>'.

            '<td class="price">'.$item['discount'].'</td>'.
            '<td class="date">'.$time.'</td>'.

            //'<td class="status">'.$item['status']['name'].'</td>'.

            '<td class="status">'.$status.'</td>'.
                
            // '<td class="phone">'.'</td>'.

            // '<td class="note"></td>'.

        '</tr>';
        
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';