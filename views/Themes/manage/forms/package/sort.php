<?php

$li = '';
foreach ($this->package['lists'] as $key => $value) {
    $li.='<li data-id="'.$value['id'].'">'.
        '<i class="icon-arrows-v"></i>'.$value['name'].
        '<input type="hidden" value="'.$value['id'].'" name="id[]">'.
    '</li>';
}
# set form
$arr['form'] = '<form class="js-submit-form" action="'.URL. 'package/sort"></form>';

# body
$arr['body'] ='<ul class="ui-list-sort" data-plugins="sortable">'.$li.'</ul>';

# title
$arr['title']= "เรียงลำดับ";


# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">'.$this->lang->translate('Save').'</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">'.$this->lang->translate('Cancel').'</span></a>';


echo json_encode($arr);