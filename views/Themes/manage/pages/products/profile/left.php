<?php
$top = array();

$top[] = array('text'=>'แก้ไข','href'=>URL.'products/edit/'.$this->item['id'],'attr'=> array('data-plugins'=>'dialog'),'icon'=>'pencil');

$top[] = array('text' => 'ลบ','href' => URL.'products/del/'.$this->item['id'],'attr' => array('data-plugins'=>'dialog'),'icon' => 'remove');

$updated ='';
if( $this->item['updated']!='0000-00-00 00:00:00' ){
    $updated = '<div class="mts fsm" style="opacity: .8">แก้ไขล่าสุด: '.$this->fn->q('time')->live( $this->item['updated'] ).'</div>';
}
?><div class="profile-left" role="left" data-width="300">

<div class="profile-left-header" role="leftHeader">

    <div class="ptm mhl mbm clearfix">
        <div class="lfloat"><a class="btn-icon" href="<?=URL?>stocks/<?=$this->item['model_id']?>"><i class="icon-arrow-left"></i></a></div>
        <div class="rfloat">
            <?php if( !empty($top) ){ ?>
            <a class="btn-icon" data-plugins="dropdown" data-options="<?=$this->fn->stringify( array(
                'select' => $top
                ) )?>"><i class="icon-ellipsis-v"></i></a>
                <?php } ?>
            </div>
        </div>
        <div class="mhl pbs">
            <div class="anchor clearfix"><div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-car"></i></div></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname"><?=$this->item['name']?></div><div class="subname fsm"><?=$this->item['cc']?></div></div></div></div><?=$updated?>
        </div>
    </div>
    <!-- end: .profile-left-header -->

    <div class="profile-left-details" role="leftContent">

    <?php require_once 'sections/summary.php'; ?>
    <?php require_once 'sections/basic.php'; ?>

    </div>
    <!-- end: .profile-left-details -->
</div>