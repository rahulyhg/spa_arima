<?php

$title = 'ความสามารถในการให้บริการของพนักงาน';

$form = new Form();
$form = $form->create()
	// set From
	->elem('div')
	->addClass('form-insert');

$skill = '';
$no=1;
foreach ($this->skill as $key => $value) {

	$sel = '';

	if( !empty($this->item) ){
		foreach ($this->item['skill'] as $val) {
			if( $val['id'] == $value['id'] ){
				$sel = ' checked="1"';
				break;
			}
		}
	}

	$skill .= '<tr>'.
			'<td class="ID">'.$no.'</td>'.
			'<td class="name">'.$value['name'].'</td>'.
			'<td class="status"><label class="checkbox"><input'.$sel.' type="checkbox" name="skill[]" value="'.$value['id'].'"></label></td>'.
		'</tr>';
	$no++;
}

$skill = '<table width="100%" class="table-permit">'.
			'<thead>'.
				'<tr>'.
					'<th> No. </th>'.
					'<th> ความสามารถ </th>'.
					'<th> เลือก </th>'.
				'<tr>'.
			'</thead>'.
			'<tbody>'.$skill.'</tbody>'.
		 '</table>';


$form 		->field('skill')
			->text( $skill );
        
# set form
$arr['form'] = '<form class="js-submit-form" method="post" action="'.URL. 'employees/set_skill"></form>';

# body
$arr['body'] = $form->html();

# title
if( !empty($this->item) ){
    $arr['title']= "{$title}";
    $arr['hiddenInput'][] = array('name'=>'id','value'=>$this->item['id']);
}
else{
    $arr['title']= "{$title}";
}

/*$arr['height'] = 'full';
$arr['overflowY'] = 'auto';*/
$arr['width'] = 450;

# fotter: button
$arr['button'] = '<button type="submit" class="btn btn-primary btn-submit"><span class="btn-text">Save</span></button>';
$arr['bottom_msg'] = '<a class="btn" role="dialog-close"><span class="btn-text">Cancel</span></a>';

echo json_encode($arr);