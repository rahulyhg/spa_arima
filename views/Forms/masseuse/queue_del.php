<?php

$arr['title'] = 'ยืนยันการลบข้อมูล';


$arr['form'] = '<form class="js-submit-form" action="'.URL. 'masseuse/queue_del"></form>';
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
$arr['hiddenInput'][] = array('name'=>'date','value'=>$this->date);

$arr['body'] = "คุณต้องการลบคิวนี้หรือไม่?";

$arr['button'] = '<button type="submit" role="submit" class="btn btn-red btn-submit"><span class="btn-text">ลบ</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';



echo json_encode($arr);