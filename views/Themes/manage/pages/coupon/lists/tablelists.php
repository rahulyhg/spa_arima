<?php

$tr = "";
$tr_total = "";
if( !empty($this->results['lists']) ){ 

    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 

        $startDateStr = '';
        $endDateStr = '';

        $startDate = strtotime($item['start_date']);
        $endDate = strtotime($item['end_date']);

        $startDateStr = date('j', $startDate) .' ' . $this->fn->q('time')->month( date('n', $startDate) ) .' '. ( date('Y', $startDate)+543 );
        $endDateStr = date('j', $endDate) .' ' . $this->fn->q('time')->month( date('n', $endDate) ) .' '. ( date('Y', $endDate)+543 );

        $dateNow = date("Y-m-d");

        $arrDate1 = explode("-",$item['end_date']);
        $arrDate2 = explode("-",$dateNow);
        $timStmp1 = mktime(0,0,0,$arrDate1[1],$arrDate1[2],$arrDate1[0]);
        $timStmp2 = mktime(0,0,0,$arrDate2[1],$arrDate2[2],$arrDate2[0]);

        if( $timStmp1 < $timStmp2 ){
            $strDate = 'หมดอายุ';
        }
        else{
            $strDate = $this->fn->q('time')->DateDiff( $dateNow, $item['end_date'] ).' วัน';
        }

        $td_date = $startDateStr.' - '.$endDateStr.' ('.$strDate.')';

        $status = '';
        foreach ($this->status as $key => $value) {

            $see = '';
            if( $item['status']['id'] == $value['id'] ){
                $see = ' selected="1"';
            }            

            $status .= '<option'.$see.' value="'.$value['id'].'">'.$value['name'].'</option>';
        }

        $status = '<select data-id="'.$item['id'].'" selector name="status" data-plugins="_update" data-options="'.$this->fn->stringify( array('url'=> URL.'coupon/setdata/'.$item['id'].'/status') ).'">'.$status.'</select>';

        $name = '';
        foreach ($item['package'] as $key => $value) {
            $name .= !empty( $name ) ? ' + ' : '';
            $name .= $value['name'].'('.$value['time'].' '.$value['unit'].')';
        }

        $desc = '';
          
        // print_r($item['type']['name']);        die();
        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";
        // set Name

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.
            
                
            '<td class="ID">'. $item['code'] .'</td>'.


            '<td class="name">'.
                '<a class="fwb link-hover" data-plugins="dialog" href="'.URL.'coupon/edit/'.$item['id'].'"><span>'.$name.'</span><i class="icon-pencil mls"></i></a>'.
                '<div class="fsm fcg">'. $desc . '</div>'.
            '</td>'.

            '<td class="date">'.$td_date.'</td>'.
            
            '<td class="price">'.$item['price'].'</td>'.

            '<td class="status">'.$item['qty'].'</td>'.

            '<td class="status">'.$item['used'].'</td>'.
            
            '<td class="status">'.$item['balance'].'</td>'.

            //'<td class="status">'.$item['status']['name'].'</td>'.

            '<td class="status">'.$status.'</td>'.
                
            // '<td class="phone">'.'</td>'.

            // '<td class="note"></td>'.

        '</tr>';
        
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';