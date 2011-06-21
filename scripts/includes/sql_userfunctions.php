<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_connect.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sanitize.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/headers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/footers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/formfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_other.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_checks.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_prepared.php');

	
	function authenticate_user($username,$password){
	
	
	}
	
	/* Check if email exists. Returns array of user details if email exists, otherwise returns empty array */
	function getUserByEmail($email) { 
		
		$emailExists = 0;
		$userinfo = array();
		
		$query = $connection -> stmt_init();	
		$sql_checkEmail = "SELECT * from Armalit_tracey.User WHERE Email=?";
		
		if ($query -> prepare($sql_checkEmail)) { 

			$query -> bind_param("s", $em);
			$em = $email;		
			$results = dynamicBindResults($query);			
			#print_r($results);
			
			/* Check if the result returned equals to email we are searching for */
			if ($results[0]['Email'] == $email) { 	
				$emailExists = 1;
				$user = $results[0]['UserId'];
				$userinfo = getUserById($user);
			} else {
				echo "Email not found";
			}		
		}
		
		$query->close();	
		return $userinfo;
	}

	/* Check if openID exists. If it exists, it returns the UserID of the user it is mapped to. If not, it returns NULL. */
	function getUserByOpenId($openID) { 
		
		$userinfo = array();
		$openIdExists = 0;
		$user = NULL;
		$query = $connection -> stmt_init();
		$sql_checkOpenID = "SELECT * FROM Armalit_tracey.UserOpenID WHERE OpenID = ?";
		
		if ($query -> prepare($sql_checkOpenID)){
					
			$query -> bind_param("s", $oid);
			$oid = $openID;
			$results = dynamicBindResults($query);
			print_r($results);
			
			#This IF statement can be improved. There are better ways for checking whether a result was found @TODO.
			if ($results[0]['OpenID'] == $OpenID)  {
							
				$openIdExists = 1;
				$userid = $results[0]['UserId'];
				$userinfo = getUserById($userid);	
							
			}
			
		}
		$query->close();
		
		# if returned array is empty, can test with empty($userinfo)
		return $userinfo;
	}
	
	/* Get the OpenId of a user when an email is specified */
	function getOpenIdByEmail($email) {
		$query = $connection->stmt_init();
		$sql_getOpenId = "SELECT * FROM Armalit_tracey.UserOpenID uoi INNER JOIN Armalit_tracey.User u ON u.UserId = uoi.UserId WHERE u.Email = ?";
		$openid = "";	
		
		if ($query->prepare($sql_getOpenId)) {		
			$query->bind_param("s", $em);
			$em = $email;			
			$results = dynamicBindResults($query);
			$openidinfo = $results[0];	
				
			if (!empty($openidinfo)) {			
				$openid = $openidinfo['OpenId'];
			}			
		}	
		return $openid;
	}
	
	
	/* Create user record. After creating a record, the function returns the UserID that is assigned to the new user record. */
	function createUser($fName, $lName, $email, $phone, $nick, $password, $type) { 
		
		
		# need to implement a secure hashing method .. i will edit it later @TODO
		
		$result_getRegisteredUserId = "";
		$query = $connection->stmt_init();
		$sql_createUserRecord = 
		"INSERT INTO `Armalit_tracey`.`User` (`UserId`, `FirstName`, `LastName`, `Email`, `Phone`, `UserType`, `Nickname`, `Password`) 
		VALUES (NULL, ?, ?, ?, ?, ?, ?, ?);";
			
		if ($query->prepare($sql_createUserRecord)) {		
			$query->bind_param("ssssiss", $F, $L, $E, $P, $T, $N, $pass);		
			$F = $fName;
			$L = $lName;
			$E = $email;
			$P = $phone;
			$T = $type;
			$P = $phone;
			$pass = $password;		
			$query->execute();	
		}
		
		# Get the UserID registered for this user
		$sql_getRegisteredUserId = "SELECT UserId FROM Armalit_tracey.User WHERE Email = ?";
		
		if ($query -> prepare($sql_getRegisteredUserId)){
			$query->bind_param("s", $em);
			$em = $email;	
			$results = dynamicBindResults($query);
			$result_getRegisteredUserId = $results[0]['UserId'];	
			#need to check if a result was returned i.e. if the user creation was successful @TODO
		}	
		$query->close();
		return $result_getRegisteredUserId;
		
	}

	/* Create openID mapping */
	function createOpenID($userID, $openID) { 
		
		$sql_createOpenID = "INSERT INTO Armalit_tracey.UserOpenID (UserID, OpenID)
		VALUES (" . $userID . ", '" . $openID . "');";
		#VALUES (?, ?);
		$result_createOpenIDMapping = mysql_query($sql_createOpenIDMapping);
		
		echo "OpenID Mapping created";	
		return $result_createOpenIDMapping;	
	}
	
	
	
	/* Delete user record that has the specified email*/
	function deleteUserByEmail($email) {	
		$query = $connection->stmt_init();
		$sql_deleteOpenID = "DELETE FROM Armalit_tracey.UserOpenID uoi INNER JOIN Armalit_tracey.User u ON u.UserID = uoi.UserId WHERE u.Email = ?";
		$sql_deleteUser = "DELETE FROM Armalit_tracey.User WHERE Email = ?";
		$valid = 0;
		$openid = "";
		
		/* Check if this is a registered email */
		/*if (empty(getUserByEmail($email))) {
			$valid = 1;
			echo "Email not found in database";
			$query->close();
			return -1;
		}*/
		
		$openid = getOpenIdByEmail($email);
		
		/* Step one: Delete the openID Mapping from OpenID table */
		if ($query->prepare($sql_deleteOpenID) && !empty($openid)) {		
			$query->bind_param("s", $em);
			$em = $email;	
			$query->execute();	
		}
			
		/* Perform a test to confirm that the openID mapping has indeed been deleted. */	
		/*if (empty(getUserByOpenId($openid))) {
			echo "OpenId Mapping Deleted";
		}*/

		/* Step two: Delete the User record from User Table */	
		if ($query->prepare($sql_deleteUser)) {		
			$query->bind_param("s", $em);
			$em = $email;		
			$query->execute();					
		}		
		
		$query->close();
		return 0;	
	}	
	
	/* Returns an array of information for a particular user based on a specified UserId */
	function getUserById($id) {
		
		$userinfo = array();
		$query = $connection->stmt_init();
		$sql_getUser = "SELECT * FROM Armalit_tracey.User WHERE UserId = ?";	
		
		if ($query->prepare($sql_getUser)) {		
			$query->bind_param("i", $userid);
			$userid = $id;
			$results = dynamicBindResults($query);
			$userinfo = $results[0];		
		}
		$query->close();
		return $userinfo;
	}
	
	/* Update user details- TODO*/
	function updateUser() { 
		
	}

?>
