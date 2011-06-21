<?php
	
	include 'scripts/includes/sanitize.php';
	include 'scripts/includes/functions.php';
	include 'scripts/includes/headers.php';
	include 'scripts/includes/footers.php';
	include 'scripts/includes/formfunctions.php';
	include 'scripts/includes/sql_connect.php';
	include 'scripts/includes/sql_prepared.php';

	
	function authenticate_user($username,$password){
	
	
	}
	
	/* Check if email exists. Returns 1 if email exists, return 0 otherwise */
	function getUserByEmail($email) { 
		
		$emailExists = 0;
		$userinfo = array();
		$query = $connection -> stmt_init();	
		$sql_checkEmail = "SELECT * from Armalit_tracey.User WHERE Email=?";
		
		if ($query -> prepare($sql_checkEmail)) { 
			
			$message = "";
			
			/* bind params */
			$query -> bind_param("s", $em);
			
			/* Set param */
			$em = $email;
			
			/* Execute the query and retrieve results dynamically */			
			$results = dynamicBindResults($query);		
			
			print_r($results);
			
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
	function checkOpenID($openID) { 
		
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

	/* Create user record. After creating a record, the function returns the UserID that is assigned to the new user record. */
	function createUser($fName, $lName, $email, $phone, $nick, $password, $type) { 
		
		$result_getRegisteredUserId = NULL;
		# need to implement a secure hashing method .. i will edit it later @TODO
		
		$query = $connection->stmt_init();
		/* Create user record (table: User) */
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
	function deleteUser($email) {
		 
		
		$query = $connection->stmt_init();
		/* Step one: Delete the openID Mapping from OpenID table */
		$sql_deleteOpenID = "DELETE FROM Armalit_tracey.UserOpenID uoi INNER JOIN Armalit_tracey.User u ON u.UserID = uoi.UserID WHERE u.Email = ?";
		
		
		if ($query->prepare($sql_deleteOpenID)) {
			
			$query->bind_param("s", $em);
			$em = $email;
			
		}
		
		
		/* Perform a test to confirm that the openID mapping has indeed been deleted. @TODO */
		
		$query = NULL;
		$query = $connection->stmt_init();
		
		/* Step two: Delete the User record from User Table */
		$sql_deleteUser = "DELETE FROM Armalit_tracey.User WHERE Email = ?";
		
		if ($query->prepare($sql_deleteUser)) {
			
			$query->bind_param("s", $em);
			$em = $email;
			
			$results = dynamicBindResults($query);
			
			#...do something with results @TODO
			
		}
		
		$query->close();
	
	}	
	
	
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
