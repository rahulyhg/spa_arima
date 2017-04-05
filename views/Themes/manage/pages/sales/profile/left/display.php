<?php

$subname = '';
if( !empty($this->item['phone']) ){
    $subname .= !empty($subname) ? ', ':'';
    $subname .= '<i class="icon-phone mrs"></i>' . $this->item['phone'];
}

if( !empty($this->item['email']) ){
    $subname .= !empty($subname) ? ', ':'';
    $subname .= '<i class="icon-envelope-o mrs"></i>' .$this->item['email'];
}

if( !empty($this->item['lineID']) ){
    $subname .= !empty($subname) ? ', ':'';
    $subname .= 'Line ID: '.$this->item['lineID'].'<a target="_blank" href="http://line.me/ti/p/~'.$this->item['lineID'].'"><i class="mls icon-external-link"></i></a>';
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
if( !empty($this->permit['sales']['edit']) ){

    $dropdown[] = array(
        'text' => 'เปลี่ยนรหัสผ่าน',
        'href' => URL.'employees/password/'.$this->item['id'],
        'attr' => array('data-plugins'=>'dialog'),
    );
}

if( !empty($this->permit['sales']['del']) ){

    $dropdown[] = array(
        'text' => 'ลบ',
        'href' => URL.'employees/del/'.$this->item['id'].'?next='.URL.'sales',
        'attr' => array('data-plugins'=>'dialog'),
    );
}

if( !empty($dropdown) ){

    $dropdown = $this->fn->stringify( array(
        'select' => $dropdown,
        'settings'=> array('axisX'=>'right'),
    ) );

    $dropdown = '<a class="btn-icon" data-plugins="dropdown" data-options="'.$dropdown.'"><i class="icon-ellipsis-v"></i></a>';
}else{
    $dropdown = '';
}

$image = '';
if( !empty($this->item['image_arr']) ){
    $image = '<div class="avatar lfloat mrm"><img class="img" src="'.$this->item['image_url'].'" alt="'.$this->item['fullname'].'"></div>';
}
else{
    $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
}
?><div class="profile-left" role="left" data-width="340">

	<div role="leftHeader">
		
        <div class="profile-left_header clearfix">

            <div class="profile-left_actions clearfix">
                <div class="rfloat"><?=$dropdown?></div>
            </div>

            <div class="anchor clearfix">

                <?=$image?>
                
                <div class="content"><div class="spacer"></div><div class="massages">
                    <h3 class="fullname"><?=$this->item['fullname']?></h3>
                    <div class="subname fsm"><?=$subname?></div>
                </div></div>
            </div>

            <div class="mvs clearfix">

                <div class="fsm fcg"><i class="icon-clock-o mrs"></i>แก้ข้อมูลล่าสุด: <?=$this->fn->q('time')->live( $this->item['updated'] )?>
                    <!-- <div>โดย..</div> -->
                </div>
                
                
            </div>

        </div>
	</div>
	<!-- end: .profile-left-header -->

	<div class="phl" role="leftContent">

        <div class="profile-resume mtm"><?php 
            include 'sections/basic.php';
            include 'sections/contact.php';

        ?></div>

    </div>
    <!-- end: .profile-left-details -->
</div>