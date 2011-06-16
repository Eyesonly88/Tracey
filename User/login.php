<?php
require_once('/scripts/includes/sanitize.php');

if (isset($_POST['submit'])){

// sanitize login details
$username = sanitize($_POST['username']);
$password = sanitize($_POST['password']);
$errorMessage = "";

	if (!empty($username)){
	
	// authenticate user
	$user = authenticate_user($username,$password);
	// if user is authenticated then the function should return 1 or true otherwise 0.
	
		if($user){
		// authenticated successfully
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		// redirect user to members page
		
		}else{
		// display error message (authenticaion failed)
		$errorMessage = "Authentication failed";
		}
	
	}else{
	// display error message
	$errorMessage = "Invalid Input";
	
	}


?>

<html>
<head></head>
<body>


<form action="login.php" method="post">
	<p><label for="login-username">Username: </label><input type="text" name="username" maxlength="30" value="" /></p>
	<br>
	<p><label for="login-password">Password: </label><input type="password" name="password" maxlength="30" value="" /></p>
	<br>
	<input id="submit_login" type="submit" name="submit" value="Login" />
</form>

</body>
</html>




