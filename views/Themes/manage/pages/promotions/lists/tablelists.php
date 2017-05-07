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

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.
            
                
            // '<td class="ID">'. $item['code'] .'</td>'.


            '<td class="name">'.$item['name'].'</td>'.
            
            '<td class="type">'. '</td>'.
            '<td class="price">'. '</td>'.
            '<td class="date">'. '</td>'.
            '<td class="status">'. '</td>'.
                
            // '<td class="phone">'.'</td>'.

            // '<td class="note"></td>'.

        '</tr>';
        
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';