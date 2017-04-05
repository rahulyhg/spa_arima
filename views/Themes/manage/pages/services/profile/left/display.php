<?php

$subname = '';
if( !empty($this->item['cus']['phone']) ){
    $subname .= !empty($subname) ? ', ':'';
    
}



$dropdown = array();
/*foreach ($this->status as $key => $value) {
    if( $value['id']==$this->item['status']['id'] ) continue;
    $dropdown[] = array(
        'text' => $value['name'],
        'href' => URL.'booking/update/'.$this->item['id'].'/status/'.$value['id'],
        'attr' => array('data-plugins'=>'dialog'),
    );
}*/
// $dropdown[] = array( 'type' => 'separator');


if( !empty($dropdown) ){

    $dropdown = $this->fn->stringify( array(
        'select' => $dropdown,
        'settings'=> array('axisX'=>'right'),
    ) );

    $dropdown = '<a class="btn-icon" data-plugins="dropdown" data-options="'.$dropdown.'"><i class="icon-ellipsis-v"></i></a>';
}else{
    $dropdown = '';
}


    $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-handshake-o"></i></div></div>';

?><div class="profile-left" role="left" data-width="340">

	<div role="leftHeader">
		
        <div class="profile-left_header clearfix">

            <div class="profile-left_actions clearfix">
                <div class="rfloat"><?=$dropdown?></div>
            </div>

            <div class="anchor clearfix">

                <?=$image?>
                
                <div class="content"><div class="spacer"></div><div class="massages">
                        <h3 class="fullname"><h2>ข้อมูลการบริการ</h2></h3>
                    <div class="subname fsm"><?=$subname?></div>
                </div></div>
            </div>

            <div class="mvs clearfix">

                <div class="fsm fcg"><i class="icon-clock-o mrs"></i>แก้ข้อมูลล่าสุด: <?=$this->fn->q('time')->live( $this->item['created'] )?>
                    <!-- <div>โดย..</div> -->
                </div>
                
                
            </div>

        </div>
	</div>
	<!-- end: .profile-left-header -->

	<div class="phl" role="leftContent">

        <div class="profile-resume mtm"><?php 
            include 'sections/cars.php';
           // include 'sections/basic.php';
            include 'sections/customer.php';
            include 'sections/tec.php';

        ?></div>

    </div>
    <!-- end: .profile-left-details -->
</div>