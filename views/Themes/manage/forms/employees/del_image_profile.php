<?php

$arr['title'] = 'ยืนยันการลบรูป';
$arr['body'] = "ลบรูปหน้าปกหรือไม่?";
$arr['form'] = '<form action="'.URL.'employees/del_image_profile"></form>';
$arr['hiddenInput'][] = array('name'=>'id','value'=>$this->id);
$arr['button'] = '<a href="#" class="btn btn-link btn-cancel" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>';
$arr['button'] .= '<button type="submit" role="submit" class="btn btn-submit btn-red"><span class="btn-text">ลบ</span></button>';

echo json_encode($arr);