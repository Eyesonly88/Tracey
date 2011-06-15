<?php
require_once('/scripts/includes/sanitize.php');

if (isset($_POST['submit'])){

// sanitize login details
$username = sanitize($_POST['username']);
$password = sanitize($_POST['password']);
$errorMessage = "";

if (!empty($username))
// authenticate user


}else {
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




