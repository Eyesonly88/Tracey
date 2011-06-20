<?php
# Script: Registration
# Description: Server-side script for registration functionality of Tracey
# STATUS: INCOMPLETE  (Updated 6pm, 5 May 2011)



# Includes
include 'scripts/includes/sanitize.php';
include 'scripts/includes/functions.php';
include 'scripts/includes/headers.php';
include 'scripts/includes/footers.php';
include 'scripts/includes/formfunctions.php';
include 'scripts/includes/sql_connect.php';
include 'scripts/includes/sql_userfunctions.php';


//check parameters
$validationFail = 0;
$validationMessage = "";
$openIDProvided = 0;

# Retrieve the POSTed parameters
$fName = $_POST['fname'];
$lName = $_POST['lname']; 
$email = $_POST['email'];
$phone = $_POST['phone'];
$nick = $_POST['nickname'];
$password = $_POST['password'];
$type = "1";

#Check if openID was provided
if (isset($_POST['openID'])) { 
	$openID = $_POST['openID'];
	$openIDProvided = 1;
} else  { 
	$openID = NULL;
}

#$test = sanitizeCheck($fName);

$userID = NULL;

$fNameSafe = sanitize($fName);
$lNameSafe = sanitize($lName);
$emailSafe = sanitize($email);
$phoneSafe = sanitize($phone);
$nickSafe = sanitize($nick);
$passwordSafe = sanitize($password);


// Validation checks for the form fields after sanitization
if (empty($fNameSafe)) { 
	
	echo "First Name validation failed.";
	$validationFail = 1;
	$validationMessage = $validationMessage + "First Name validation failed; ";
	
	
} else if (empty($lNameSafe)) { 

	echo "Last Name validation failed.";
	$validationFail = 1;
	$validationMessage = $validationMessage + "Last Name validation failed;";
	
} else if (empty($phoneSafe)) { 

	echo "Phone number validation failed.";
	$validationFail = 1;
	$validationMessage = $validationMessage + "Phone number validation failed;";
	
} else if (empty($nickSafe)) { 

	echo "Nickname validation failed.";
	$validationFail = 1;
	$validationMessage = $validationMessage + "Nickname validation failed;";
	
}

if ($validationFail == 0) { 
	
	# Check if email is already in record
	if (checkEmail($email) == 1) { 
		$validationFail = 1;
		$validationMessage = "Email already registered";
	}
}


if (validationFail == 0) { 
	# Create user record (table: User)
	$userID = createUser($fName, $lName, $email, $phone, $nick, $password, $type);
}

# Create openID mapping for user if specified (table: UserOpenID)
if (openIDProvided == 1) {
	if ($userID != NULL) { 
		$result_createOpenIDMapping = createOpenID($userID, $openID);
	} else { 
		echo "Null UserID - Perhaps user was not registered properly";
	}
}

?>