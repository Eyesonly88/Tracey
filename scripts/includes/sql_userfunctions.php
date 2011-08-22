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
	
	#$connection = $conn;
	
	/* hashes the hashed password 1000 times so it takes more time for attackers
	 to build a rainbow table. @TESTED: OK.*/
	function repeatHash($hash){
		for ($i = 0; $i < 1000; $i++){
			$hash = sha1($hash);
		}
		return $hash;
	}
	
	/* returns a unique 22 characters hashed string. @TESTED: OK */
	function uniqueSalt(){
		return substr(sha1(mt_rand()), 0, 22);
	}
	
	/* checks if the entered password is valid or not. Returns true if password is correct, false otherwise. @TESTED: OK */
	function checkPass($password, $email){
		
		$uniqueSalt = getUserInfo($email,'Salt');
		//echo $uniqueSalt . "<br>";
		$hashed_s = sha1($uniqueSalt . $password);
		$hashed = repeatHash($hashed_s);
		//echo $hashed . "<br>";
		$hashed_p = getUserInfo($email,'Password');
		//echo $hashed_p . "<br>";
		
		if ($hashed === $hashed_p) {
			// user is authenticated
			//echo "Correct Password";
			return true;
		} else {
			// user is not authenticated
			//echo "Wrong password";
			return false;
		}
	}

	/* Generic function that returns the desired field from the user record.
	 * For example, if you want to fetch the Salt of a user, then pass the user's e-mail as first parameter and 'Salt' as second parameter. @TESTED: OK.*/
	function getUserInfo($email,$param){
		global $connection;
		$query = $connection->stmt_init();
		$sql_stmnt = "SELECT " .$param. " FROM User WHERE Email = ?";
		$results = array();
		if ($query->prepare($sql_stmnt)) {
			$query->bind_param("s", $em);
			$em = $email;		
			$results = dynamicBindResults($query);
			//print_r($results);
		}
		return 	$results[0]["$param"];
	}
	
	function getUserInfoById($id, $param){
		global $connection;
		$query = $connection->stmt_init();
		$sql_stmnt = "SELECT " .$param. " FROM User WHERE UserId = ?";
		$results = array();
		if ($query->prepare($sql_stmnt)) {
			$query->bind_param("i", $userid);
			$userid = $id;		
			$results = dynamicBindResults($query);
			//print_r($results);
		}
		return 	$results[0]["$param"];
	}
	
	/* Check if email exists. Returns array of user details if email exists, otherwise returns empty array. @TESTED: OK */
	function getUserByEmail($email) { 
		global $connection;
		$emailExists = 0;
		$userinfo = array();
		$results = NULL;
		$query = $connection->stmt_init();
		
		$sql_checkEmail = "SELECT * from user WHERE Email=?";	
		$query->prepare($sql_checkEmail);
		$query->bind_param("s", $email);
			
		$results = dynamicBindResults($query);			
		if (empty($results)) {
			return "";
		}
		if ($results[0]['Email'] == $email) { 	
			$emailExists = 1;
			$user = $results[0]['UserId'];
			$userinfo = $results[0];
		}		
			
		return $userinfo;
	}

	/* Check if openID exists. If it exists, it returns the UserID of the user it is mapped to. If not, it returns NULL. */
	function getUserIdByOpenId($openID) { 
		global $connection;
		$userinfo = array();
		$openIdExists = 0;
		$user = NULL;
		echo "im before init <BR />";	
		$query = $connection->stmt_init();
		echo "im before prepare ";	
		$sql_checkOpenID = "SELECT * FROM UserOpenID WHERE OpenID = ?";
		try {
			if ($query->prepare($sql_checkOpenID)){
				echo "im here";		
				$query->bind_param("s", $oid);
				$oid = $openID;
				$results = dynamicBindResults($query);
				//print_r($results);
				echo "im before if";
				if (empty($results)) { 
					return "";
				}
				if ($results[0]['OpenID'] == $OpenID)  {
								
					$openIdExists = 1;
					$userid = $results[0]['UserId'];
					$userinfo = getUserById($userid);							
				}
			}
		}catch(ErrorException $e) {
    		echo $e->getMessage();
		}
			
		
		return $userinfo;
	}
	
	function getOpenIdByUserId($id) {
		global $connection;	
		$query = $connection->stmt_init();
		$sql_getOpenId = "SELECT * FROM UserOpenID uoi WHERE uoi.UserId = ?";
		$openid = "";	
		
		if ($query->prepare($sql_getOpenId)) {		
			$query->bind_param("s", $uid);
			$uid = $id;			
			$results = dynamicBindResults($query);
			if (empty($results)) { return ""; }
			$openidinfo = $results[0];	
				
			if (!empty($openidinfo)) {			
				$openid = $openidinfo['OpenId'];
			}			
		}	
		return $openid;
	}
	
	/* Get the OpenId of a user when an email is specified */
	function getOpenIdByEmail($email) {
		global $connection;	
		$query = $connection->stmt_init();
		$sql_getOpenId = "SELECT * FROM UserOpenID uoi INNER JOIN User u ON u.UserId = uoi.UserId WHERE u.Email = ?";
		$openid = "";	
		
		if ($query->prepare($sql_getOpenId)) {		
			$query->bind_param("s", $em);
			$em = $email;			
			$results = dynamicBindResults($query);
			if (empty($results)) { return ""; }
			$openidinfo = $results[0];	
				
			if (!empty($openidinfo)) {			
				$openid = $openidinfo['OpenId'];
			}			
		}	
		return $openid;
	}
	
	
	/* Create user record. After creating a record, the function returns the UserID that is assigned to the new user record. @TESTED: OK */
	function createUser($fName, $lName, $email, $phone, $nick, $password, $type) { 
		
		global $connection;
		
		$uniqueSalt = uniqueSalt();
		$hashed_s = sha1($uniqueSalt . $password);
		$hashed_p = repeatHash($hashed_s);
		
		$result_getRegisteredUserId = "";
		$query = $connection->stmt_init();
		$sql_createUserRecord = 
		"INSERT INTO User (`UserId`, `FirstName`, `LastName`, `Email`, `Phone`, `UserType`, `Nickname`, `Password`, `Salt`) 
		VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?);";
			
		if ($query->prepare($sql_createUserRecord)) {		
			$query->bind_param("ssssisss", $F, $L, $E, $P, $T, $N, $pass, $salt);		
			$F = $fName;
			$L = $lName;
			$E = $email;
			$P = $phone;
			$T = $type;
			$N = $nick;
			$pass = $hashed_p;
			$salt = $uniqueSalt;		
			$query->execute();	
		}
		
		# Get the UserID registered for this user
		$sql_getRegisteredUserId = "SELECT * FROM User WHERE Email = ?";
		
		if ($query -> prepare($sql_getRegisteredUserId)){
			$query->bind_param("s", $em);
			$em = $email;	
			$results = dynamicBindResults($query);
			if (empty($results)) { return ""; }
			$result_getRegisteredUserId = $results[0];	
			#need to check if a result was returned i.e. if the user creation was successful @TODO
		}	
		return $result_getRegisteredUserId;
		
	}

	/* Create openID mapping @TODO: need to change to prepared statements */
	function mapOpenID($userID, $openID) {
		
		global $connection; 
		
		$query = $connection->stmt_init();
		$sql_createOpenID = "INSERT INTO UserOpenID (UserID, OpenID) VALUES (?,?);";
		if ($query->prepare($sql_createOpenID)) {
			$query->bind_param("is", $uID, $oID);
			$uID = $userID;
			$oID = $openID;
			$query->execute();
		}
		# Get the UserID registered for this openID user and make sure mapping was successful
		$sql_getOpenUserId = "SELECT * FROM UserOpenID WHERE OpenID = ?";
		
		if ($query->prepare($sql_getOpenUserId)){
			$query->bind_param("s", $oID);
			$oID = $openID;	
			$results = dynamicBindResults($query);
			if (empty($results)) { return ""; }
			$result_getOpenUserId = $results[0];
			if ($result_getOpenUserId == $userID) {
				// openID mapping was created successfully
				return true;
			} else {
				return false;
			}
		}	

	}
	
	
	
	/* Delete user record that has the specified email. Returns -1 if email is not registered. */
	function deleteUserByEmail($email) {
		
		global $connection;	
		$query = $connection->stmt_init();
		$sql_deleteOpenID = "DELETE FROM UserOpenID uoi INNER JOIN User u ON u.UserID = uoi.UserId WHERE u.Email = ?";
		$sql_deleteUser = "DELETE FROM User WHERE Email = ?";
		$valid = 0;
		$openid = "";
		
		/* Check if this is a registered email */
		$temp = getUserByEmail($email);
		if (empty($temp)) {	
			return -1;
		}
		
		$openid = getOpenIdByEmail($email);
		
		/* Step one: Delete the openID Mapping from OpenID table (if there is one) */
		if ($query->prepare($sql_deleteOpenID) && !empty($openid)) {		
			$query->bind_param("s", $em);
			$em = $email;	
			$query->execute();
			
			/* Perform a test to confirm that the openID mapping has indeed been deleted. */
			$temp = getUserByOpenId($openid);	
			if (empty($temp)) {
				echo "OpenId Mapping Deleted <BR />";
			}			
		} 
					

		/* Step two: Delete the User record from User Table */	
		if ($query->prepare($sql_deleteUser)) {		
			$query->bind_param("s", $em);
			$em = $email;		
			$query->execute();	
			
			$temp = getUserByEmail($email);
			if (empty($temp)){ 
				echo "User record successfully deleted <BR />";
			}						
		}		

		return 0;	
	}	
	
	function deleteOpenIdByUserId($id) {
		
		/* @TODO */
	}
	
	/* Returns an array of information for a particular user based on a specified UserId @TESTED: OK */
	function getUserById($id) {
		
		global $connection;
		$userinfo = array();
		$query = $connection->stmt_init();
		$sql_getUser = "SELECT * FROM User WHERE UserId = ?";	
		
		if ($query->prepare($sql_getUser)) {		
			$query->bind_param("i", $userid);
			$userid = $id;
			$results = dynamicBindResults($query);
			if (empty($results)) { return ""; }
			$userinfo = $results[0];		
		}
		
		return $userinfo;
	}
	
	/* Update user details- TODO*/
	function updateUser() { 
		
	}
	
	
	function getCurrentUser(){
		return $_SESSION['email'];
	}

?>
