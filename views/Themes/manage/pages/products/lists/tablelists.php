<?php

$tr = "";
$tr_total = "";
if( !empty($this->results['lists']) ){ 

    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 


        // $item = $item;
        $cls = $i%2 ? 'even' : "odd";
        // set Name

        $updatedStr = $this->fn->q('time')->stamp( $item['updated'] );
       


        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            // '<td class="check-box"><label class="checkbox"><input id="toggle_checkbox" type="checkbox" value="'.$item['id'].'"></label></td>'.

            '<td class="status">'.$item['model_name'].'</td>'.

            '<td class="name"><a href="'.URL.'products/'.$item['id'].'">'.$item['name'].'</a></td>'.

            '<td class="qty">'.$item['cc'].'</td>'.

            '<td class="qty">'.$item['mfy'].'</td>'.

            '<td class="price">'.number_format($item['price']).'</td>'.

            //'<td class="qty">-</td>'.

            '<td class="qty">'.$item['balance'].'</td>'.

            '<td class="date">'. $updatedStr. '</td>'.

            '<td class="actions tac">
                <span class="gbtn"><a class="btn btn-no-padding" data-plugins="dialog" href="'.URL.'products/edit/'.$item['id'].'"><i class="icon-pencil"></i></a></span>
                <span class="gbtn"><a class="btn btn-no-padding" data-plugins="dialog" href="'.URL.'products/del/'.$item['id'].'"><i class="icon-trash"></i></a></span>
            </td>'.

        '</tr>';
        
    }
}

$table = '<table><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';