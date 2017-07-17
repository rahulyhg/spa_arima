<?php


$tr = '';
foreach ($this->skill as $key => $value) {
        


        $check = '-';
        foreach ($this->item['skill'] as $skill) {
            if( $skill['id'] == $value['id'] ){
                $check = '<i class="icon-check"></i>';
                break;
            }
        }
        // $input = '<label class="checkbox disabled"><input'.$check.' type="checkbox" class="disabled" disabled></label>';

        $tr .= '<tr>'.
            '<td>'.$value['name'].'</td>'.
            '<td class="tac">'.$check.'</td>'.
        '</tr>';


}

$image = !empty($this->item['image_url'])
    ? '<div class="avatar size168"><img src="'.$this->item['image_url'].'"></div>'
    : '<div class="avatar size168 no-avatar"><div class="initials">'.$this->item['code'].'</div></div>';


$infoArr = array();
$infoArr[] = array('key'=>'code','label'=>'เบอร์');
$infoArr[] = array('key'=>'fullname','label'=>'ชื่อ');
$infoArr[] = array('key'=>'nickname','label'=>'ชื่อเล่น');
// $infoArr[] = array('key'=>'age','label'=>'อายุ');
$infoArr[] = array('key'=>'phone','label'=>'เบอร์โทร');
// $infoArr[] = array('key'=>'email','label'=>'อีเมล์');
$infoArr[] = array('key'=>'line','label'=>'Line ID');

$info = '';
foreach ($infoArr as $key => $value) {
    
    $info .= '<tr>'.
        '<td class="label">'.$value['label'].'</td>'.
        '<td class="data">'.( !empty($this->item[ $value['key'] ]) ? $this->item[ $value['key'] ]: '-' ).'</td>'.
    '</tr>';

}

$info = '<table class="table-info-warp"><tbody><tr>'.
            '<td class="image" width="168" align="top">'.$image.'</td>'.
            '<td class="details"><table class="table-info fsm"><tbody>'. $info. '</tbody></table></td>'.
        '</tr></tbody></table>';

$skill = '<table class="table-standard">'.
    '<tbody>'.$tr.'</tbody>'.
 '</table>';

# body
$arr['body'] = $info.'<div class="pam"><strong class="fss">ความสามารถ</strong>'.$skill.'</div>';

# form
$arr['form'] = '<div class="model-body-warp">';

$type = '';
if( $this->job['type']=='oil' ){
    $type = 'หมอออย';
}
# title
$arr['title']= '<div class="clearfix">'.
    '<div class="lfloat fsm">คิว'.$type.'ลำดับ '.$this->job['job_sequence'].' <br>วันที่ '.date('j/m/Y', strtotime($this->date)).'</div>'.
    '<div class="rfloat"><a class="btn btn-red js-del" ajaxify="'.URL.'masseuse/queue_del/'.$this->item['id'].'?date='.$this->date.'">ยกเลิกคิว</a><a class="btn" role="dialog-close"><i class="icon-remove mrs"></i>ปิด</a></div>'.
'</div>'; 

//$this->item['fullname'];

# fotter: button
/*$arr['button'] = '<a class="btn btn-red btn-submit"><span class="btn-text">ยกเลิกคิว</span></a>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">ปิด</span></a>';*/

$arr['is_close_bg'] = 1;
$arr['width'] = 550;

echo json_encode($arr);

?>
