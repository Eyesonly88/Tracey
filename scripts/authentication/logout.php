<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');
	
	//4 steps to close a seasion(logout)
	
	//.1 find session
	
	// Already done when including sessions.php
	
	//2. unset all session vars
	
	$_SESSION = array();
	
	//3. Destroy the session cookie
	
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '',time()-42000, '/');
	}
	
	//4. Destroy the session
	
	session_destroy();
	
	redirect_to("login.php?out=1");

?>