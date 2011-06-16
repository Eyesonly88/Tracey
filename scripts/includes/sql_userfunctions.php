<?php
	
	include 'scripts/includes/sanitize.php';
	include 'scripts/includes/functions.php';
	include 'scripts/includes/headers.php';
	include 'scripts/includes/footers.php';
	include 'scripts/includes/formfunctions.php';
	include 'scripts/includes/sql_connect.php'

	
	function authenticate_user($username,$password){
	
	
	}
	
	
	/* Check if email exists. Returns 1 if email exists, return 0 otherwise */
	function checkEmail($email) { 
		
		$emailExists = 0;
		$sql_checkEmail = "SELECT Email from Armalit_tracey.User WHERE Email= '" . $email . "'";
		$result_checkEmail = mysql_query($sql_checkEmail, $connection);
		if (mysql_num_rows($result_checkEmail) { 
			$emailExists = 1;
			echo "Email already exists";
		}
		return $emailExists;
	}

	/* Check if openID exists. If it exists, it returns the UserID of the user it is mapped to. If not, it returns NULL. */
	function checkOpenID($openID) { 
		
		$user = NULL;
		$sql_checkOpenID = "SELECT * FROM Armalit_tracey.UserOpenID WHERE OpenID = '" . $openID . "'";
		$result_checkOpenID = mysql_query($sql_checkOpenID, $connection);
		if (mysql_num_rows($result_checkEmail) { 
			$openIDExists = 1;
			$user = mysql_result($result_checkOpenID, 0);
			echo "OpenID Exists for user: " . $user;
		}
		return $user;
	
	}

	/* Create user record. After creating a record, the function returns the UserID that is assigned to the new user record. */
	function createUser($fName, $lName, $email, $phone, $nick, $password, $type) { 
		
		$result_getRegisteredUserId = NULL;
		// need to implement a secure hashing method .. i will edit it later
		
		
		# Create user record (table: User)
		$sql_createUserRecord = 
		"INSERT INTO `Armalit_tracey`.`User` (`UserId`, `FirstName`, `LastName`, `Email`, `Phone`, `UserType`, `Nickname`, `Password`) 
		VALUES (NULL, '" . $fName . "', '" . $lName . "', '" . $email . "', '" . $phone . "', '" . $type . "', '" . $nick . "','" . $password . "');";

		# Get the UserID registered for this user
		$sql_getRegisteredUserId = "SELECT UserId FROM Armalit_tracey.User WHERE Email = '" . $email . "'";
		
		$result_createUserRecord = mysql_query($sql_getRegisteredUserId, $connection);
		$result_getRegisteredUserId = mysql_query($sql_getRegisteredUserId, $connection);
		
		return $result_getRegisteredUserId;
		
	}

	/* Create openID mapping */
	function createOpenID($userID, $openID) { 
		
		$sql_createOpenID = "INSERT INTO Armalit_tracey.UserOpenID (UserID, OpenID)
		VALUES (" . $userID . ", '" . $openID . "');";
	
		$result_createOpenIDMapping = mysql_query($sql_createOpenIDMapping);
		
		echo "OpenID Mapping created";
		
		return $result_createOpenIDMapping;
		
	}
	
	/* Delete user record that has the specified email*/
	function deleteUser($email) { 
	
		/* Step one: Delete the openID Mapping from OpenID table */
		
		/* Step two: Delete the User record from User Table */
	
	}	
	
	/* Update user information - TODO*/
	function updateUser() { 
		
	}

?>
