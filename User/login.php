<?php
include_once('/scripts/includes/sanitize.php');

if (isset($_POST['submit'])){

// sanitize login details
$email = sanitize($_POST['email']);
$password = sanitize($_POST['password']);
$errorMessage = "";

	if (!empty($email)){
	
	// authenticate user
	$user = checkPass($email,$password);
	// if user is authenticated then the function should return 1 or true otherwise 0.
	
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
	
	}

}

?>





