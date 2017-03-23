<?php

$form = new Form();
$form = $form->create()
		->url(URL."me/updated/password?run=1")
		->addClass('js-submit-form form-insert')
		->method('post');

$form->field("password_old")
        ->label('รหัสผ่านเดิม')
        ->type('password')
        ->addClass('inputtext')
        ->maxlength(30)
        ->required(true)
        ->autocomplete("off")

    ->field("password_new")
        ->label('รหัสผ่านใหม่')
        ->type('password')
        ->addClass('inputtext')
        ->maxlength(30)
        ->required(true)
        ->autocomplete("off")

    ->field("password_confirm")
        ->label('ยืนยันรหัสผ่านใหม่')
        ->type('password')
        ->addClass('inputtext')
        ->maxlength(30)
        ->required(true)
        ->autocomplete("off");

$form  	->submit()
		->addClass("btn-submit btn btn-blue")
		->value("Save");
        
echo $form->html();