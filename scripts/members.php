<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');

// Confirm if user is logged in.
confirmLogin();

?>

<!DOCTYPE html>
<html>
	<body>
		<h1>Welcome to Members Area!</h1>
		<p><a href="logout.php">Logout!</a></p>
	</body>
</html>
