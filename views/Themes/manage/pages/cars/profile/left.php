<?php

$subname = '';
if( !empty($this->item['cus_phone']) ){
    $subname .= !empty($subname) ? ', ':'';
    $subname = '<i class="icon-phone mrs"></i>' . $this->item['cus_phone'];
}else if( !empty($this->item['cus_email']) ){
    $subname .= !empty($subname) ? ', ':'';
    $subname = '<i class="icon-envelope-o mrs"></i>' .$this->item['cus_email'];
}else if( !empty($this->item['cus_lineID']) ){
    $subname .= !empty($subname) ? ', ':'';
    $subname = 'Line ID: '.$this->item['cus_lineID'].'<a target="_blank" href="http://line.me/ti/p/~'.$this->item['cus_lineID'].'"><i class="mls icon-external-link"></i></a>';
}




$updated ='';
if( $this->item['updated']!='0000-00-00 00:00:00' ){
	$updated = '<div class="mts fsm" style="opacity: .8">แก้ไขล่าสุด: '.$this->fn->q('time')->live( $this->item['updated'] ).'</div>';
}

$boxAnchor = '<div class="anchor clearfix"><div class="avatar lfloat no-avatar mrm"><div class="initials"><i class="icon-user"></i></div></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname">'.$this->item['cus_fullname'].' </div><div class="subname fsm">'.$subname.'</div></div></div></div>'.
    $updated;
$bookmark = 0;
$bookmark = '<a class="ui-bookmark js-bookmark'.( $this->item['cus_bookmark']==1 ? ' is-bookmark':'' ).'" data-value="" data-id="'.$this->item['id'].'" stringify="'.URL.'cars/bookmark/'.$this->item['id'].'"><i class="icon-star yes"></i><i class="icon-star-o no"></i></a>';
?><div class="profile-left" role="left">

	<div class="profile-left-header" role="leftHeader">
		
        <div class="ptm mhl mbm clearfix">
            <div class="lfloat"><a class="btn-icon" href="<?=URL?>cars"><i class="icon-arrow-left"></i></a></div>
            <div class="rfloat">
                <?=$bookmark?>
                <a class="btn-icon" data-plugins="dropdown" data-options="<?=$this->fn->stringify( array(
                    'select' => array( 0=> 
                        array(
                            'text' => 'ลบ',
                            'href' => URL.'cars/del/'.$this->item['id'],
                            'attr' => array('data-plugins'=>'dialog'),
                            'icon' => 'remove'
                        ),
                    )
                    ) )?>"><i class="icon-ellipsis-v"></i></a>
            </div>
        </div>
		<div class="mhl pbs">
			
			<?=$boxAnchor?>	

<?php
if( !empty($subname) ){
echo '<div class="clearfix profile-express mtm pbm">';
    
    if( !empty($this->item['cus_phone']) ){
        echo '<a href="tel:'.$this->item['cus_phone'].'" class="btn-icon btn-border mrs"><i class="icon-phone"></i></a>';
    }

    if( !empty($this->item['cus_email']) ){
        echo '<a href="mailto:'.$this->item['cus_email'].'" class="btn-icon btn-border mrs"><i class="icon-envelope"></i></a>';
    }
    
    if( !empty($this->item['cus_lineID']) ){
        echo '<a class="btn-icon btn-border mrs" _target="_blank" href="line:'.$this->item['cus_lineID'].'">Line</a>';
    }

echo '</div>';
}

?>
	
		</div>
	</div>
	<!-- end: .profile-left-header -->

	<div class="profile-left-details" role="leftContent">

    <?php require_once 'sections/info.php'; ?>

    </div>
    <!-- end: .profile-left-details -->
</div>