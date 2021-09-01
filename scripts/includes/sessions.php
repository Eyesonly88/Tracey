<?php
	// Start session
	session_start();
	
	/* Redirects the browser to the desired page(file). @TESTED : OK*/
	function redirect_to($location = NULL){
		if (!$location == NULL){
			header("Location: {$location}");
			exit;
		}
	}
	
	/* Returns true if user is logged in otherwise false. @TESTED : OK*/
	function loggedIn() {
		return isset($_SESSION['email']);	
	}
	
	/* Redirects user to login page if not logged in. @TESTED : OK*/
	function confirmLogin(){
		if (!loggedIn()) {
	  		// redirect user to login page
	  		redirect_to("../index.php");
		} else {
			// do nothing because user is logged in
		}
	}
	
	function confirmLogin2(){
		if (!loggedIn()) {
	  		// redirect user to login page
	  		
		} else {
			redirect_to("../user_dashboard.php");
			// do nothing because user is logged in
		}
	}
	
	function boolConfirmLogin() {
		if (!loggedIn()) {
	  		// redirect user to login page
	  		return 0;
		} else {
			return 1;
		}
	}

?>