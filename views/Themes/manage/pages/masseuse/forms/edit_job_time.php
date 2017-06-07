<?php

$startDate = '';
if( !empty($this->item['clock_start_date']) ){
    if( $this->item['clock_start_date'] != '0000-00-00 00:00:00' ){
        $startDate = $this->item['clock_start_date'];
    }
}
elseif( isset($_REQUEST['date']) ){
    $startDate = $_REQUEST['date'];
}

$endDate = $this->item['clock_start_date'];
if( !empty($this->item['clock_end_date']) ){
    if( $this->item['clock_end_date'] != '0000-00-00 00:00:00' ){
        $endDate = $this->item['clock_end_date'];
    }
}

$title = 'แก้ไขเวลาเข้างาน';

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form   ->field('date')
        ->label("เวลาทำงาน")
        ->text( '<div class="content" data-name="has_time" data-plugins="setdate" data-options="'.$this->fn->stringify( array(

            'startDate' => $startDate,
            'endDate' => $endDate,

            'allday' => 'disabled',
            'endtime' => true,
            // 'time' => 'disabled',

            'str' => array(
                $this->lang->translate('Start'),
                $this->lang->translate('End'),
                $this->lang->translate('All day'),
                $this->lang->translate('End Time'),
            ),

            'lang' => $this->lang->getCode()

        ) ).'"></div>' );


# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'masseuse/edit_time"></form>';

# body
$arr['body'] = $form->html();

# title
if( !empty($this->item) ){
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['clock_id']);
}
$arr['title'] = $title;

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">Save</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">Cancel</span></a>';

// $arr['width'] = 782;

echo json_encode($arr);