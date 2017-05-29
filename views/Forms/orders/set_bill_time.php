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

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert form-set-time');

$form   ->field("ex_time")
        // ->label( $this->lang->translate('Expiry Date') )
        ->text(

        '<div class="content" data-name="ex_time" data-plugins="setdate" data-options="'.$this->fn->stringify( array(

            'startDate' => $startDate,
            'endDate' => $endDate,

            'allday' => 'disabled',
            // 'endtime' => true,
            // 'time' => 'disabled',

            'str' => array(
                $this->lang->translate('Start'),
                $this->lang->translate('End'),
                $this->lang->translate('All day'),
                $this->lang->translate('End Time'),
            ),

            'lang' => $this->lang->getCode()

        ) ).'"></div>'

        );

$form   ->hr('<div class="clearfix"></div>');

# set form
$arr['form'] = '<form>';

# body
$arr['body'] = $form->html();

# title
$arr['title']= $this->lang->translate('Set Time');

$arr['width'] = 450;

# fotter: button
$arr['button'] = '<button type="submit" role="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';


echo json_encode($arr);