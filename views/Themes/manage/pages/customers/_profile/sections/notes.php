<?php


// echo sprintf("%02d",1);


?><div class="mal" style="max-width: 540px;">
	
	<div id="posts" class="posts" data-plugins="posts" data-options="<?=$this->fn->stringify( array(
		'load'=> URL .'customers/notes?cus_id='.$this->item['id'],
		'settings' => array(
			'parent' => '#profile-main',
			'axisX' => 'right'
		),
		'actions' => array( 0=> 
			array(
				'text' => 'แก้ไข',
	            'attr' => array('data-type'=>'edit'),
	            'icon' => 'pencil'
			),
			array(
				'type' => 'separator',
			),
			array(
				'text' => 'ลบ',
	            'attr' => array('data-type'=>'remove'),
	            'icon' => 'remove'
			)
		),
		'edit_post_url' => URL .'customers/edit_note'. (!empty($this->hasMasterHost) ? '?company='.$this->company['id']:''),
		'del_post_url' => URL .'customers/del_note'. (!empty($this->hasMasterHost) ? '?company='.$this->company['id']:''),
	) )?>">
		
		<form class="post post-form" method="post" action="<?=URL?>customers/save_note<?=!empty($this->hasMasterHost) ? '?company='.$this->company['id']:''?>">
			<div class="post-form--loader"></div>
			<input type="hidden" name="cus_id" value="<?=$this->item['id']?>" />
			<div class="post-form--content post-form--input">
				
				<div class="title-field"></div>
				<div class="editor-wrapper"><textarea data-plugins="autosize" name="text" class="inputtext js-input"></textarea></div>
			</div>

			<div class="post-form--bottom">
				<div class="post-form--controls">
					<div class="control left"></div>
					<div class="control right"><button class="btn btn-blue">Save</button></div>
				</div>
				<div class="post-form--error-bar"></div>
			</div>
		</form>

		<div class="post post-empty">
			<div class="empty">
				<div class="post-loader empty-loader">
					<div class="loader-spin-wrap"><div class="loader-spin"></div></div>
					<div>กำลังโหลด...</div>
				</div>
				<div class="empty-text"></div>
			</div>
		</div>
	</div>
</div>