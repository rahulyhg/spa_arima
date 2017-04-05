<?php

$time = strtotime($this->item['date']);
$date = $this->fn->q('time')->day( date('w', $time), 1 )
        . 'ที่ '
        . date('j', $time)
        . ' '
        . $this->fn->q('time')->month( date('n', $time) )
        . ' '
        . ( date('Y', $time)+543 );

$dropdown = array();

foreach ($this->status as $key => $value) {

    if( $value['id']==$this->item['status']['id'] ) continue;

    if( !empty($this->permit['booking']['edit']) || $this->me['id'] == $this->item['sale']['id'] ) {

        $url = URL.'booking/update/'.$this->item['id'].'/status/'.$value['id'];

        if( $value['id'] == 'finish' ){
            $url .= '?next='.URL.'customers/'.$this->item['cus']['id'].'/cars';
        }

        $dropdown[] = array(
            'text' => $value['name'],
            'href' => $url,
            'attr' => array('data-plugins'=>'dialog'),
        );
    }
}

if( !empty($this->permit['booking']['del']) || $this->me['id'] == $this->item['sale']['id'] ){
    
    if( !empty($dropdown) ){
        $dropdown[] = array( 'type' => 'separator');
    }

    $dropdown[] = array(
        'text' => 'ลบ',
        'href' => URL.'booking/del/'.$this->item['id'],
        'attr' => array('data-plugins'=>'dialog'),
    );
}

if( !empty($dropdown) ){

    $dropdown = $this->fn->stringify( array(
        'select' => $dropdown,
        'settings'=>array('axisX'=>'right')
    ) );

    $dropdown = ' <a class="btn-icon" data-plugins="dropdown" data-options="'.$dropdown.'"><i class="icon-ellipsis-v"></i></a>';
}
else{
    $dropdown = '';
}


$subtext = '';
$subtext .= 'เล่มที่ ' .( !empty($this->item['page']) ? "{$this->item['page']}":'-');
$subtext .= ' เลขที่ ' .( !empty($this->item['number']) ? "{$this->item['number']}":'-');

?><div class="profile-left" role="left" data-width="340">

	<div role="leftHeader">
		
        <div class="clearfix profile-left_header">

            <div class="clearfix profile-left_actions">
                <div class="rfloat">
                <?php if( !empty($this->permit['booking']['edit']) || $this->me['id'] == $this->item['sale']['id'] ){ ?>
                   <a class="btn-icon" href="<?=URL?>booking/update/<?=$this->item['id']?>/basic" data-plugins="dialog"><i class="icon-pencil"></i></a>
                <?php } 

                echo $dropdown;
                ?>
                  
                </div>
            </div>

            <div class="anchor clearfix">
                <div class="lfloat mrm avatar no-avatar"><div class="initials"><i class="icon-address-book-o"></i></div></div>
                <div class="content"><div class="spacer"></div><div class="massages">
                    <h3 class="fullname">ข้อมูลการจอง</h3>            
                    <div class="subtext"><?=$subtext?></div>
                </div></div>

            </div>

            <div class="mvs clearfix">
                <div><i class="icon-clock-o mrs"></i>จองเมื่อ<?=$date?></div>
            </div>

            <!-- <div class="lfloat"><a class="btn-icon" href="<?=URL?>booking"><i class="icon-arrow-left"></i></a></div> -->

        </div>
	</div>
	<!-- end: .profile-left-header -->

	<div class="phl" role="leftContent">

        <div class="profile-resume mtm"><?php 
            // include 'sections/basic.php';
            include 'sections/sales.php'; 
            include 'sections/customer.php';
            include 'sections/cars.php';
            include 'sections/deposit.php';
            include 'sections/payment.php';
            include 'sections/insurance.php';

            // รวมค่าใช้จ่ายทั้งสิ้น
        ?></div>

    </div>
    <!-- end: .profile-left-details -->
</div>