<?php 

$startDate = '';
if( !empty($this->item['start_date']) ){
    if( $this->item['start_date'] != '0000-00-00 00:00:00' ){
        $startDate = $this->item['start_date'];
    }
}
elseif( isset($_REQUEST['date']) ){
    $startDate = $_REQUEST['date'];
}

$endDate = '';
if( !empty($this->item['end_date']) ){
    if( $this->item['end_date'] != '0000-00-00 00:00:00' ){
        $endDate = $this->item['end_date'];
    }
}

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass('form-insert');

$form 	->field("name")
		->label( $this->lang->translate('Name') )
		->text( '<input class="inputtext" disabled="1" value="'.$this->item['fullname'].'">' );


$form   ->field("ex_time")
        ->label($this->lang->translate('Expiry Date'))
        ->text(

        '<div class="content" data-name="ex_time" data-plugins="setdate" data-options="'.$this->fn->stringify( array(

            'startDate' => $startDate,
            'endDate' => $endDate,

            'allday' => 'disabled',
            'endtime' => true,
            'time' => 'disabled',

            'str' => array(
                $this->lang->translate('Start'),
                $this->lang->translate('End'),
                $this->lang->translate('All day'),
                $this->lang->translate('End Time'),
            ),

            'lang' => $this->lang->getCode()

        ) ).'"></div>'

        )
        ->note( 'กำหนดวันหมดอายุสมาชิก' );

# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'customers/set_extend"></form>';

# body
$arr['body'] = $form->html();

$title = $this->lang->translate('Member').' (ต่ออายุ)';

if( !empty($this->item) ){
    $arr['title']= $title;
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}

$rolesubmit = '';
if( isset( $_REQUEST['callback'] ) ){
    $arr['hiddenInput'][] = array('name'=>'callback','value'=>$_REQUEST['callback']);
    $rolesubmit = ' role="submit"';
}

$arr['button'] = '<button type="submit"'.$rolesubmit.' class="btn btn-primary btn-submit"><span class="btn-text">บันทึก</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);