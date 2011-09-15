<?php
# Script: Registration
# Description: Server-side script for registration functionality of Tracey
# STATUS: INCOMPLETE  (Updated 6pm, 5 May 2011)

# Includes
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sanitize.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/headers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/footers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/formfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_connect.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_connect.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_other.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_checks.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_prepared.php');

/* 
 * ERROR CODES:
 * 
 * 1 = Validation Failed
 * 2 = Email is already registered
 * 
 * */

//check parameters
$validationFail = 0;
$callbackMsg = "";
$openIDProvided = 0;

$fName = "";
$lName = "";
$phone = "";
$fNameSafe = "";
$lNameSafe = "";
$phoneSafe = "";
$email = "";
$password = "";
#for debugging
/*
$fName = $_GET['fname'];
$lName = $_GET['lname']; 
$email = $_GET['email'];
$phone = $_GET['phone'];
$nick = $_GET['nickname'];
$password = $_GET['password']; */

# Retrieve the POSTed parameters
if (isset($_POST['fname'])) {
	$fName = $_POST['fname'];
	$fNameSafe = sanitize($fName);
} 

if (isset($_POST['lname'])) {
	$lName = $_POST['lname'];
	$lNameSafe = sanitize($lName); 
}

if (isset($_POST['phone'])) {
	$phone = $_POST['phone'];
	$phoneSafe = sanitize($phone); 
}

if (isset($_POST['email'])) {	
	$email = $_POST['email'];
} else {
	return "";
}

if (isset($_POST['password'])) {	
	$password = $_POST['password'];
} else {
	return "";
}

if (isset($_POST('nickname'))) {
	$nick = $_POST['nickname'];
}
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

$callbackMsg = '';

$emailSafe = sanitize($email);
$nickSafe = sanitize($nick);
$passwordSafe = sanitize($password);


// Validation checks for the form fields after sanitization
if (empty($fNameSafe) && isset($_POST['fname'])) { 
	

	$validationFail = 1;
	$callbackMsg = 1;
	
	
} else if (empty($lNameSafe) && isset($_POST['lname'])) { 

	//echo "Last Name validation failed. <BR />";
	$validationFail = 1;
	$callbackMsg = 1;
	
} else if (empty($phoneSafe) && isset($_POST['phone'])) { 

	//echo "Phone number validation failed. <BR />";
	$validationFail = 1;
	$callbackMsg = 1;
	
} else if (empty($nickSafe)) { 

	//echo "Nickname validation failed. <BR />";
	$validationFail = 1;
	$callbackMsg = 1;
	
} else if (empty($emailSafe)) {
	
	//echo "Email validation failed <BR />";
	$validationFail = 1;
	$callbackMsg = 1;
	
	
}

if ($validationFail == 0) { 
	
	# Check if email is already in record
	$temp = getUserByEmail($email);
	if (!empty($temp)) { 
		$validationFail = 1;
		$callbackMsg = 2;
	}
}


if ($validationFail == 0) { 
	# Create user record (table: User)
	$user = createUser($fNameSafe, $lNameSafe, $emailSafe, $phoneSafe, $nickSafe, $password, $type);
	$callbackMsg = "User with email " . $emailSafe . " registered with ID: " . $user['UserId'] . "<BR />";
}

# Create openID mapping for user if specified (table: UserOpenID)
if ($openIDProvided == 1) {
	if (!empty($userID)) { 
		$result_createOpenIDMapping = createOpenID($userID, $openID);
	} else { 
		$callbackMsg = 3;
	}
}

echo $callbackMsg;

?>