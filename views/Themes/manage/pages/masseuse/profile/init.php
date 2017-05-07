<?php 

$this->url = URL.'employees/';
$this->obj_type = 'employees/';
$this->obj_id = $this->item['id'];

$this->tab = isset($this->tab)? $this->tab: '';

$this->tabs = array();
$this->tabs[] = array('id'=>'services','name'=>'ประวัติบริการ', 'icon'=>'handshake-o');

$this->tabs_right = array();
// $this->tabs_right[] = array('id'=>'files','name'=>'Files', 'icon'=>'file-o');
// $this->tabs_right[] = array('id'=>'plans','name'=>'นัดหมาย', 'icon'=>'history', 'active'=>1);
$this->tabs_right[] = array('id'=>'notes','name'=>'Notes', 'icon'=>'comments-o', 'active'=>1);


$this->has_edit = !empty($this->permit['employees']['edit']) || $this->me['id'] == $this->item['id'];



$dropdown = array();
/*foreach ($this->status as $key => $value) {

    if( $value['id']==$this->item['status']['id'] ) continue;
    $dropdown[] = array(
        'text' => $value['name'],
        'href' => URL.'booking/update/'.$this->item['id'].'/status/'.$value['id'],
        'attr' => array('data-plugins'=>'dialog'),
    );
}*/

// $dropdown[] = array( 'type' => 'separator');
if( $this->has_edit ){
    $this->dropdown[] = array(
        'text' => 'ลบ',
        'href' => URL."{$this->obj_type}/del/{$this->obj_id}",
        'attr' => array('data-plugins'=>'dialog'),
    );

    $this->dropdown = $this->fn->stringify( array(
        'select' => $this->dropdown,

        'setttings' => array(
            'axisX' => 'right'
        )
    ) );
    $this->dropdown = '<a class="btn-icon" data-plugins="dropdown" data-options="'.$this->dropdown.'"><i class="icon-ellipsis-v"></i></a>';
}
else{

    $this->dropdown = '';
}