<?php 
	
	# Server side script that returns the email of the currently authenticated user. (Can be called by client-side script via AJAX or other)
	
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');
	
	
	echo $_SESSION['email'];

?>
