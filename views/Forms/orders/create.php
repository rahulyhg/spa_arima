<?php


$today = date('c');

$startDate = isset($_GET['start']) 
    ? date('Y-m-d H:i:s', strtotime($_GET['start']))
    : date('Y-m-d H:i:s', strtotime($today));

$sHour = date('H', strtotime($startDate));
$sHour = $sHour < 10? "0{$sHour}":$sHour;
$sM = date('i', strtotime($startDate));
$sM = round( $sM / 5 , 0, PHP_ROUND_HALF_UP) * 5;

$endDate = isset($_GET['end']) 
    ? date('Y-m-d H:i:s', strtotime($_GET['end']))
    : date('Y-m-d H:i:s', strtotime($today));

if( isset($_GET['time']) && isset($_GET['unit']) && !isset($_GET['end']) ){
    
    $time = strtotime("+{$_GET['time']} {$_GET['unit']}", strtotime($endDate));
    $endDate = date('Y-m-d H:i:s', $time);
}

$eHour = date('H', strtotime($endDate));
$eHour = $eHour < 10? "0{$eHour}":$eHour;
$eM = date('i', strtotime($endDate));
$eM = round( $eM / 5 , 0, PHP_ROUND_HALF_UP) * 5;

$hour = array();
for ($h=0; $h < 24; $h++) { 
    $hh = $h<10?"0{$h}": $h;
    $hour[] = array('id'=>$hh, 'name'=> $hh);
}

$minute = array();
for ($m=0; $m < 60; $m+=5) { 
    $mm = $m<10?"0{$m}": $m;
    $minute[] = array('id'=>$mm, 'name'=> $mm);
}

/**/
/* $package */
/**/
$package = '';
// print_r($this->package); die;
foreach ($this->package['lists'] as $key => $value) {
	// $package .= '<tr data-type="package" data-id="'.$value['id'].'">'.

	// 	'<td class="qty">

	// 		<div class="minusplus-btn">'.
	// 			'<button type="button" class="btn-icon"><i class="icon-minus"></i></button>'.
	// 			'<input type="text" name="item['.$value['id'].'][qty][]" class="inputtext inputqty" value="0">'.
	// 			'<button type="button" class="btn-icon"><i class="icon-plus"></i></button>'.
	// 		'</div>
	// 	</td>'.

	// 	'<td class="name">'.
	// 		'<span class="fwb">'.$value['name'].'</span>'.
	// 		'<ul class="ui-list-masseuse">'.
	// 			'<li><span class="code mrs">P5</span><span>ชง</span></li>'.
	// 			// '<li><span class="code mrs">P5</span><span>ชง</span></li>'.
	// 		'</ul>'.

	// 		'<ul class="ui-list-masseuse">'.
	// 			'<li><span class="code mrs">P5</span><span>ชง</span></li>'.
	// 			// '<li><span class="code mrs">P5</span><span>ชง</span></li>'.
	// 		'</ul>'.

	// 		'<ul class="ui-list-masseuse">'.
	// 			'<li><span class="code mrs">P5</span><span>ชง</span></li>'.
	// 			// '<li><span class="code mrs">P5</span><span>ชง</span></li>'.
	// 		'</ul>'.
	// 	'</td>'.
		
	// 	'<td class="time">'.$value['qty'].'</td>'.
	// 	'<td class="unit">'.$value['unit'].'</td>'.

	// 	'<td class="price">'. number_format($value['price'], 0).' ฿</td>'.


	// '</tr>';
}

$package = '<table class="table-package-manu"><tbody ref="ordermanu">'.$package.'</tbody></table>';


$manu = '';
foreach ($this->package['lists'] as $key => $value) {
	$manu .= '<li data-type="package" data-id="'.$value['id'].'">'.$value['name'].'</li>';
}

$formMenu = '<ul class="ul-package-manu">'.$manu.'</ul>';

/* set Form */
$form = new Form();
$form = $form->create()
    // set From
    ->addClass('form-insert pal');

$form   ->field("number")
        ->autocomplete('off')
        ->type('number')
        ->addClass('inputtext')
        ->label('ลำดับ')
        ->value( 1 );

$form   ->field("count")
        ->autocomplete('off')
        ->addClass('inputtext')
        ->label('จำนวนลูกค้า')
        ->type('number')
        ->value( 1 );

/*$form   ->field("member")
        ->label('สมาชิก')
        ->autocomplete('off')
        ->addClass('inputtext')
        // ->attr('data-name', 'bed')
        ->value( '' );*/

// $form   ->field("date")
//         ->label( $this->lang->translate('Date') )
//         ->text(

// '<div class="content" data-name="date" data-plugins="setdate" data-options="'.$this->fn->stringify( array(

//     'startDate' => $startDate,
//     'endDate' => $endDate,

//     'allday' => 'disabled',
//     // 'endtime' => true,
//     // 'time' => 'disabled',

//     'str' => array(
//         $this->lang->translate('Start'),
//         $this->lang->translate('End'),
//         $this->lang->translate('All day'),
//         $this->lang->translate('End Time'),
//     ),

//     'lang' => $this->lang->getCode()

// ) ).'"></div>'

// 		);

// $form   ->field("room_floor")
//         ->label($this->lang->translate('Floor'))
//         ->autocomplete('off')
//         ->addClass('inputtext')
//         ->attr('data-name', 'floor')
//         ->select( $this->floors, 'id','name' ,0 );

// $form   ->field("room_name")
//         ->label($this->lang->translate('Room Name'))
//         ->autocomplete('off')
//         ->addClass('inputtext')
//         ->attr('data-name', 'room')
//         ->select( array() );

// $form   ->field("room_number")
//         ->label($this->lang->translate('Bed Name'))
//         ->autocomplete('off')
//         ->addClass('inputtext')
//         ->attr('data-name', 'bed')
//         ->select( array() );


$formDetail = $form->html();


$form = new Form();
	$form = $form->create()->elem('div')->addClass('form-insert pal');
	$form 	->field("package")
			// ->label('Package')
			->text( $package );
$formPackage = $form->html();


# set form
$arr['form'] = '<form data-plugins="createOrder2"></form>';
// data-plugins="chooseRooms"
# body
$arr['body'] = '<div class="table-order2-wrap"><div class="table-order2-form">'.
	'<div class="td-order2-detail" >'. $formDetail .'</div>'.
	'<div class="td-order2-package">'.$formPackage.'</div>'.
	'<div class="td-order2-menu">'.$formMenu.'</div>'.
'</div></div>';


# title
$arr['title']= $this->lang->translate('Order');

# fotter: button
$arr['button'] = '<button type="submit" role="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';

// $arr['is_close_bg'] = 1;
$arr['width'] = 1150;

echo json_encode($arr);