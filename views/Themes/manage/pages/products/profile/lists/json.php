<?php

require 'tableBody.php';
echo json_encode( array(
	'settings' => $this->results,
	'body' => $table,
	// 'selector' => $selector
));