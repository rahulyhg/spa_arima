<?php

$top = array();

if( !empty($this->permit['models']['edit']) ){
    $top[] = array('text'=>'แก้ไข','href'=>URL.'models/edit/'.$this->item['id'],'attr'=> array('data-plugins'=>'dialog'),'icon'=>'pencil');
}

if( !empty($this->permit['models']['del']) && !empty($this->item['permit']['del']) ){
    $top[] = array('text' => 'ลบ','href' => URL.'models/del/'.$this->item['id'],'attr' => array('data-plugins'=>'dialog'),'icon' => 'remove');
}

$updated ='';
//if( $this->item['updated']!='0000-00-00 00:00:00' ){
//    $updated = '<div class="mts fsm" style="opacity: .8">แก้ไขล่าสุด: '.$this->fn->q('time')->live( $this->item['updated'] ).'</div>';
//}
?><div class="profile-left" role="left" data-width="300">

<div class="profile-left-header" role="leftHeader">

    <div class="ptm mhl mbm clearfix">
        <div class="lfloat"><a class="btn-icon" href="<?=URL?>stocks"><i class="icon-arrow-left"></i></a></div>
        <div class="rfloat">
            <?php if( !empty($top) ){ ?>
            <a class="btn-icon" data-plugins="dropdown" data-options="<?=$this->fn->stringify( array(
                'select' => $top
                ) )?>"><i class="icon-ellipsis-v"></i></a>
                <?php } ?>
            </div>
        </div>
        <div class="mhl pbl">
                 <div class="anchor clearfix">
                <?php 
                if( !empty($this->item['image_url']) ){
            $image = '<div class="lfloat mrm"><img class="img" src="'.$this->item['image_url'].'"style="width: 114px;margin-top:-9px"></div>';
        }
        else{
            $image = '<div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div>';
        }
                ?>
               <?=$image?>
                <div class="content">
                    <div class="spacer"></div>
                    <div class="massages">
                        <div class="fullname"><?=$this->item['name']?>
                        </div><div class="subname fsm">
                            
                        </div>
                            
                    </div></div></div><?=$updated?>
        </div>
    </div>
    <!-- end: .profile-left-header -->

    <div class="profile-left-details" role="leftContent">

    <?php require_once 'sections/summary.php'; ?>
    <?php require_once 'sections/basic.php'; ?>

    </div>
    <!-- end: .profile-left-details -->
</div>