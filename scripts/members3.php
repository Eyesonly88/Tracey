<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');

// Confirm if user is logged in.
confirmLogin();

?>

<!DOCTYPE html>
<html>
	<body>
		<h1>Welcome to Members Area 3!</h1>
		<p><a href="members2.php">Go to Members Area 2 :)</a></p>
		<p><a href="members.php">Go to Members Area 1 :)</a></p>
		<p><a href="logout.php">Logout!</a></p>
	</body>
</html>