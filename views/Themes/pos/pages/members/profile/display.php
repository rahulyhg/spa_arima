<?php

$options = array(
    'url' => URL.'media/set',
    'data' => array(
        'album_name'=>'my', 
        'minimize'=> array(128,128),
        'has_quad'=> true,
     ),
    'autosize' => true,
    'show'=>'quad_url',
    'remove' => true
);

if( !empty($this->item['id']) ){
    $options['setdata_url'] = URL.'customers/setdata/'.$this->item['id'].'/cus_image_id/?has_image_remove';
}

$image_url = '';
$hasfile = false;
if( !empty($this->item['image_url']) ){
    $hasfile = true;
    $image_url = '<img class="img" src="'.$this->item['image_url'].'?rand='.rand(100, 1).'">';

    $options['remove_url'] = URL.'media/del/'.$this->item['image_id'];
    
}

$picture_box = '<div class="anchor"><div class="clearfix">'.

        '<div class="ProfileImageComponent lfloat size80 radius mrm is-upload'.($hasfile ? ' has-file':' has-empty').'" data-plugins="uploadProfile" data-options="'.$this->fn->stringify( $options ).'">'.
            '<div class="ProfileImageComponent_image">'.$image_url.'</div>'.
            '<div class="ProfileImageComponent_overlay"><i class="icon-camera"></i></div>'.
            '<div class="ProfileImageComponent_empty"><i class="icon-camera"></i></div>'.
            '<div class="ProfileImageComponent_uploader"><div class="loader-spin-wrap"><div class="loader-spin"></div></div></div>'.
            '<button type="button" class="ProfileImageComponent_remove"><i class="icon-remove"></i></button>'.
        '</div>'.
    '</div>'.

'</div>';

$form = new Form();
$form = $form->create()
    // set From
    ->elem('div')
    ->addClass(' pal');

// $form   ->field("image")
//         ->text( $picture_box );

$form   ->field("name")
        ->label($this->lang->translate('Name'))
        ->text( $this->fn->q('form')->fullname( !empty($this->item)?$this->item:array(), array('field_first_name'=>'cus_', 'prefix_name'=>$this->prefixName) ) );

$form   ->field("birthday")
        ->label('วันเกิด')
        ->text( $this->fn->q('form')->birthday( !empty($this->item)?$this->item:array(), array('field_first_name'=>'cus_') ) );

$form   ->field("cus_card_id")
        ->label($this->lang->translate('ID Card / Passport'))
        ->autocomplete('off')
        ->addClass('inputtext')
        ->placeholder('')
        ->value( !empty($this->item['card_id'])? $this->item['card_id']:'' );

$form   ->field("cus_address")
        ->name('cus[address]')
        ->label($this->lang->translate('Address'))
        ->text( $this->fn->q('form')->address( !empty($this->item['address'])? $this->item['address']:array(), array('city'=>$this->city ) ) );

// email
$form->hr( $this->fn->q('form')->contacts( 
    'email',
    !empty($this->item['options']['email'])? $this->item['options']['email']:array(), 
    array( 'field_first_name'=>'options[email]' )
) );

// phone
$form->hr( $this->fn->q('form')->contacts( 
    'phone',
    !empty($this->item['options']['phone'])? $this->item['options']['phone']:array(), 
    array( 'field_first_name'=>'options[phone]' )
) );

// social
$form->hr( $this->fn->q('form')->contacts( 
    'social',
    !empty($this->item['options']['social'])? $this->item['options']['social']:array(), 
    array( 'field_first_name'=>'options[social]' )
) );

?><div style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;overflow-y: hidden;">


	<div style="position: absolute;padding-top: 30px;padding-left: 30px;right: 0;left: 0;background-color: rgba(245,248,250,.98);z-index: 5;max-width: 700px;">
		
		<div class="clearfix" style="max-width: 600px;">

			<div class="lfloat">
				<span class="gbtn"><a class="btn"><i class="icon-arrow-left mrs"></i>Hide</a></span>
			</div>

			<div class="rfloat">
				<span class="gbtn"><a class="btn btn-red"><i class="icon-remove mrs"></i>Cancel</a></span>
			</div>

		</div>
	</div>

	<div style="position: absolute;top: 0;left: 30px;right: 0;bottom: 0;overflow-y: auto;"><div style="padding-top: 65px;padding-bottom: 30px; max-width: 600px;">

		<?=$form->html()?>

		<!-- <div class="profile-menu-action clearfix">
			<span class="gbtn"><a class="btn btn-large">Discount</a></span>
		</div> -->

	</div></div>

</div>