<?php

$arr['title'] = 'ยืนยันการลบข้อมูล';

$arr['form'] = '<form class="js-submit-form" action="'.URL. 'products/del_item"></form>';
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
$arr['body'] = "คุณต้องการลบ <span class=\"fwb\">\"{$this->item['pro_name']}\"</span> เลขตัวถัง \"<span class=\"fwb\">{$this->item['vin']}\"</span> หรือไม่?";

$arr['button'] = isset($_REQUEST['callback'])
? '<button type="submit" role="submit" class="btn btn-danger btn-submit"><span class="btn-text">ลบ</span></button>'
: '<button type="submit" class="btn btn-danger btn-submit"><span class="btn-text">ลบ</span></button>';

$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';

echo json_encode($arr);