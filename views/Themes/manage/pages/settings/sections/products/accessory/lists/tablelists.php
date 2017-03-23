<?php

$tr = "";
$tr_total = "";
$url = URL .'accessory/';
if( !empty($this->results['lists']) ){ 

    $seq = 0;
    foreach ($this->results['lists'] as $i => $item) { 
      
        $cls = $i%2 ? 'even' : "odd";
        // set Name

        $dropdown = array();
        $dropdown[] = array(
            'text' => 'Change Password',
            'href' => $url.'password/'.$item['id'],
            'attr' => array('data-plugins'=>'dialog'),
            'icon' => 'key'
        );

        $actions = '';

        if( !empty($this->permit['accessory']['edit']) ){
            $actions .= '<a data-plugins="dialog" href="'.$url.'edit/'.$item['id'].'" class="btn"><i class="icon-pencil"></i></a>';
        }

        $dropdown = array();
        if( !empty($this->permit['accessory']['edit']) ){
            $dropdown[] = array(
                'text' => 'Delete',
                'href' => $url.'del/'.$item['id'],
                'attr' => array('data-plugins'=>'dialog'),
                'icon' => 'remove'
            );
        }

        if( !empty($dropdown) ){
            $actions .= '<a data-plugins="dropdown" class="btn" data-options="'.$this->fn->stringify( array(
                'select' => $dropdown,
                'settings' =>array(
                    'axisX'=> 'right',
                    'parent'=>'.setting-main'
                ) 
            ) ).'"><i class="icon-ellipsis-v"></i></a>';
        }

        $tr .= '<tr class="'.$cls.'" data-id="'.$item['id'].'">'.

            '<td class="name"><a class="fwb">'.$item['name'].'</a></td>'.
            '<td class="status whitespace">'. $item['model_name'].'</td>'.
            '<td class="number">'. number_format($item['cost'],0) .'</td>'.
            '<td class="number">'. number_format($item['price'],0) .'</td>'.
            '<td class="actions"><div class="whitespace group-btn">'.$actions.'</div></td>'.
              
        '</tr>';
        
    }
}

$table = '<table class="settings-table"><tbody>'. $tr. '</tbody>'.$tr_total.'</table>';