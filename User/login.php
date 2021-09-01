<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sanitize.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');
	
	if (loggedIn()) {
		redirect_to('members.php');
	}
	
	if (isset($_POST['submit'])){
	
	// sanitize login details
	$email = sanitize($_POST['email']);
	$password = sanitize($_POST['password']);
	$errorMessage = "";
	
		if (!empty($email)){
		
		// authenticate user
		$user = checkPass($email,$password);
		// if user is authenticated then the function should return true otherwise false.
		
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
		if (isset($_GET['out']) && $_GET['out'] == 1 ){
			$message = "You are now logged out ^^";
			echo $message;
		}
	}
?>

?>





