<?php
	
	include 'loginservice.php';
	include 'includes/sanitize.php';
	include 'includes/functions.php';
	include 'includes/headers.php';
	include 'includes/footers.php';
	include 'includes/formfunctions.php';
	include 'includes/sql_connect.php'

	/* Check if email exists */
	function checkEmail($email) { 
		
		$emailExists = 0;
		$sql_checkEmail = "SELECT Email from Armalit_tracey.User WHERE Email= '" . $email . "'";
		$result_checkEmail = mysql_query($sql_checkEmail, $connection);
		if (mysql_num_rows($result_checkEmail) { 
			$emailExists = 1;
			PRINT "Email already exists";
		}
		return $emailExists;
	}

	/* Check if openID exists */
	function checkOpenID($openID) { 
	
		
	}

	/* Create user record */
	function createUser($fName, $lName, $email, $phone, $nick, $password, $type) { 
		
		
		# Create user record (table: User)
		$sql_createUserRecord = 
		"INSERT INTO `Armalit_tracey`.`User` (`UserId`, `FirstName`, `LastName`, `Email`, `Phone`, `UserType`, `Nickname`) 
		VALUES (NULL, '" . $fName . "', '" . $lName . "', '" . $email . "', '" . $phone . "', '" . $type . "', '" . $nick . "');";

		# Get the UserID registered for this user
		$sql_getRegisteredUserId = "SELECT UserId FROM Armalit_tracey.User WHERE Email = '" . $email . "'";
		
		$result_createUserRecord = mysql_query($sql_getRegisteredUserId, $connection);
		$result_getRegisteredUserId = mysql_query($sql_getRegisteredUserId, $connection);
		
		return $result_getRegisteredUserId;
		
	}

	/* Create openID mapping */
	function createOpenID($userID, $openID) { 

	}
	
	/* Delete user record */
	function deleteUser() { 
	
	
	}
	
	
	/* Update user information */
	function updateUser() { 
	
	}

?>
