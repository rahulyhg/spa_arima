<?php


$title = array(
	0 =>   

	  array('key'=>'name', 'text'=>$this->lang->translate('Full Name'),'sort'=>'first_name')
	, array('key'=>'phone', 'text'=>$this->lang->translate('Nick Name') )
	, array('key'=>'express', 'text'=>$this->lang->translate('Contact') )

	, array('key'=>'date', 'text'=>$this->lang->translate('Expired Date') )

	, array('key'=>'status', 'text'=>$this->lang->translate('Status') )
	 // , array('key'=>'date', 'text'=>$this->lang->translate('Last Update'))
	
);

// $this->titleStyle = 'row-2';

$this->tabletitle = $title;
$this->getURL =  URL.'customers/';