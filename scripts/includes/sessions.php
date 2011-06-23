<?php

	session_start();
	
	/* Redirects the browser to the desired page(file). */
	function redirect_to($location = NULL){
		if (!$location == NULL){
			header("Location: {$location}");
			exit;
		}
	}
	
	function loggedIn() {
		return isset($_SESSION['email']);	
	}
	
	function confirmLogin(){
		if (!loggedIn()) {
	  		// redirect user to login
	  		redirect_to("../index.html");
		} else {
			// do nothing because user is logged in
		}
	}

?>