<?php

$form = new Form();
$form = $form 	->create()
    			->elem('div');

if( count($this->dealer)==1 ){

$form   ->field("book_dealer_id")
		->label('บริษัท/Dealer Name')
        ->text( '<select id="book_dealer_id" disabled="1" class="inputtext disabled js-data" name="book[dealer_id]"><option value="'.$this->dealer[0]['id'].'">'.$this->dealer[0]['name'].'</option></select><input type="hidden" autocomplete="off" name="book[dealer_id]" value="'.$this->dealer[0]['id'].'" autocomplete="off">' );
}
else{

$form   ->field("book_car")
		->name('book[dealer_id]')
        ->autocomplete('off')
        ->label('บริษัท/Dealer Name')
        ->addClass('inputtext js-data')
        ->select( $this->dealer );
}


if( !empty($this->me['dep_is_sale']) ){

$form   ->field("book_sale_id")
		->label('ที่ปรึกษาการขาย/Sales Consultant')
        ->text( '<select id="book_sale_id" disabled="1" class="inputtext disabled js-data" name="book[sale_id]"><option value="'.$this->me['id'].'">'.$this->me['fullname'].'</option></select><input type="hidden"  name="book[sale_id]" value="'.$this->me['id'].'">' );
}
else{

$li = '';
foreach ($this->sales as $key => $value) {

    $contact = '';
    if( !empty($value['phone_number']) ){
        $contact = '<i class="icon-phone mrs"></i>'.$value['phone_number'];
    }
    elseif( !empty($value['email']) ){
        $contact = '<i class="icon-envelope-o mrs"></i>: '.$value['email'];
    }
    elseif( !empty($value['line_id']) ){
        $contact = 'Line ID: '.$value['phone'];
    }

    $checked = false;
    if( isset($_REQUEST['checked']) ){
        if( is_array($_REQUEST['checked']) ){
            foreach ($_REQUEST['checked'] as $id) {
                if( $value['id']==$id ){
                    $checked = true;
                    break;
                }
            }
        }
        else if( $value['id']==$_REQUEST['checked'] ){
            $checked = true;
        }
    }

    $li .= '<li class="checklist-item'.( $checked ? ' checked':'' ).'"><div class="anchor clearfix"><div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user i-before"></i><i class="icon-check i-after"></i></div></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">'.$value['fullname'].'</div><div class="subname fsm meta">'.$contact.'</div></div></div></div>'.

        '<div class="checklist-item-hiden">'.
            '<input type="checkbox" name="book[sale_id]" value="'.$value['id'].'"'.( $checked ? ' checked="1"':'' ).'>'.
        '</div>'.
    '</li>';
}

$form   ->field("book_sale_id")
		->name('book[sale_id]')
        ->label('ที่ปรึกษาการขาย/Sales Consultant')
        ->text( '<div class="checklist-main" data-plugins="checklist" data-options="'.$this->fn->stringify( array( 'limit' => 1 ) ).'">'.
    '<ul class="checklist-items checklist-horizontal count-3" ref="listsbox">'.$li.'</ul>'.
'</div>' );

}


$section .= $form->html();