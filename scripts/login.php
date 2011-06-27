<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sanitize.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
	
	// If user is already logged in then go to members page.
	if (loggedIn()) {
		redirect_to('../user_dashboard.php');
	}
	
	// check if user details are correct and log user in.
	if (isset($_POST['submit'])){
	
	// sanitize login details
	$email = sanitize($_POST['email']);
	$password = sanitize($_POST['password']);
	$errorMessage = "";
	
		if (!empty($email)){
		
		// Authenticate user
		$user = checkPass($password,$email);
		
			if($user){
				// authenticated successfully
				$_SESSION['email'] = $email;
				$_SESSION['password'] = $password;
				
				// redirect user to members page
				redirect_to('members.php');
			}else{
				// display error message (authenticaion failed)
				$errorMessage = "Authentication failed";
				echo $errorMessage;
			}
		
		}else{
			// display error message
			$errorMessage = "Invalid Input";
			echo $errorMessage;
			
		}

	} else {
		// Form wasnt submitted
		
		// Display logout message
		if (isset($_GET['out']) && $_GET['out'] == 1 ){
			$message = "You are now logged out ^^";
			echo $message;
		}
	}
?>





