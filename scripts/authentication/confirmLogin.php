<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');
	# Server-side script that confirms user-login to client-side script. Returns 1 if logged in, 0 otherwise.
	
	echo boolConfirmLogin();
	
?>