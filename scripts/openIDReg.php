<?php
# Script: Registration
# Description: Server-side script for registration functionality of Tracey
# STATUS: INCOMPLETE  (Updated 6pm, 5 May 2011)



# DB Connection details
include 'loginservice.php';

# Connect to database server and select tracey database
$connection = mysql_connect($connection,$username,$password);
$traceydb = mysql_select_db($database, $connection);

//check parameters
$validationFail = 0;
$validationMessage = "";
$openIDProvided = 0;

# malicious code search
$search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );


# Retrieve the POSTed parameters
$fName = $_POST['fname'];
$lName = $_POST['lname']; 
$email = $_POST['email'];
$phone = $_POST['phone'];
$nick = $_POST['nickname'];
$password = $_POST['password'];
$type = "1";

# Check if openID was provided
if (isset($_POST['openID'])) { 
	$openID = $_POST['openID'];
	$openIDProvided = 1;
} else  { 
	$openID = NULL;
}


$fNameSafe = preg_replace($search, '', $fName);
$lNameSafe = preg_replace($search, '', $lName);
$emailSafe = preg_replace($search, '', $email);
$phoneSafe = preg_replace($search, '', $phone);
$nickSafe = preg_replace($search, '', $nick);
$passwordSafe = preg_replace($search, '', $password);
 
 
 
# Put the result of regex tests into variables
/*
$fName_alphaNumericValidation = preg_match("/^[A-Za-z0-9_- ]+$/", $fName);
$lName_alphaNumericValidation = preg_match("/^[A-Za-z0-9_- ]+$/", $lName);
$email_validation = preg_match("/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/", $email);
$phone_numericValidation = preg_match("/^[A-Za-z0-9_- ]+$/", $phone);
$nick_alphaNumericValidation = preg_match("/^[A-Za-z0-9_- ]+$/", $nick);
*/


// Validation checks for the form fields using the result of regex tests (variables above)
if ($fNameSafe == '') { 
	
	echo "First Name validation failed.";
	validationFail = 1;
	validationFail = validationFail + "First Name validation failed; ")
	
} else if ($lNameSafe == '') { 

	echo "Last Name validation failed.";
	validationFail = 1;
	validationFail = validationFail + "Last Name validation failed;")
	
} else if (!$phoneSafe == '') { 

	echo "Phone number validation failed.";
	validationFail = 1;
	validationFail = validationFail + "Phone number validation failed;")
	
} else if (!$nickSafe == '') { 

	echo "Nickname validation failed.";
	validationFail = 1;
	validationFail = validationFail + "Nickname validation failed;")
	
}

if (validationFail == 0) { 
	
	# Check if email is already in record
	$sql_checkEmailExistence = "SELECT Email from Armalit_tracey.User WHERE Email= '" . $email . "'";
	$result_checkEmailExistence = mysql_query($sql_checkEmailExistence, $connection);
	if (mysql_num_rows($result_checkEmailExistence) { 
		validationFail = 1;
		validationMessage = "Email already registered";
	}
}

if (validationFail == 0) { 

	# Check if nickname already exists (unique?)
	$sql_checkNicknameExistence = "SELECT nickname from Armalit_tracey.User WHERE nickname = '" . $nickname . "'";
	$result_checkNicknameExistence = mysql_query($sql_checkNicknameExistence, $connection);
	if (mysql_num_rows($result_checkNicknameExistence) { 
		validationFail = 1;
		validationMessage = "Nickname already in use";
	}
}

if (validationFail == 0) { 

	# Create user record (table: User)
	$sql_createUserRecord = 
	"INSERT INTO `Armalit_tracey`.`User` (`UserId`, `FirstName`, `LastName`, `Email`, `Phone`, `UserType`, `Nickname`) 
	VALUES (NULL, '" . $fName . "', '" . $lName . "', '" . $email . "', '" . $phone . "', '" . $type . "', '" . $nick . "');";

	# Get the UserID registered for this user
	$sql_getRegisteredUserId = "SELECT UserId FROM Armalit_tracey.User WHERE Email = '" . $email . "'";

	$result_getRegisteredUserID = mysql_query($sql_getRegisteredUserId, $connection);
}

# Create openID mapping for user if specified (table: UserOpenID)
if (openIDProvided == 1) { 
	$sql_createOpenIDMapping = 
	"INSERT INTO Armalit_tracey.UserOpenID (UserID, OpenID)
	VALUES (" . $userID . ", '" . $openID . "');";
	$result_createOpenIDMapping = mysql_query($sql_createOpenIDMapping);
}

?>