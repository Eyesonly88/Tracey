<?php 

// Call-back script that accepts ajax POST requests, creates an issue with the specified information.

/* RETURN ERROR CODES
 * 
 * 1: Success
 * -1: No user specified in _POST['user'] / user not logged in
 * -2: The currently logged in user is not the reporter nor the assignee of the issue. Therefore, not allowed to modify.
 * -3: One of: the reporter email, assignee email, the issue itself, or the currently logged in user was not found.
 * -4: The modify issue call failed (returned false, which means the server-side script failed to run the prepared statement to update the database)
 * 
 * */
//($compId, $name, $desc, $reporterId, $assigneeId, $issueTypeId, $PriorityId, $issueStatusId)
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');

$currentuser = '';
$reporterEmail = '';
$assigneeEmail = '';
$reporterId = '';
$component = '';
$assigneeId = '';
$issuetype =  '1';
$issuestatus = '1';
$priority = '1';
$description = 'Enter description...';
$name = 'Untitled';

$issuearray = '';
$issue = '';

$modifyissueresult = '';

//if (isset($_POST['user'])) {
	$currentuserEmail = $_SESSION['email'];	
	$currentuser = getUserInfo($currentuserEmail, "UserId");
//} else {	
	//return -1;
//}

//if (isset($_POST['id'])) {
	//$issueid = $_POST['id'];
	//$issuearray = getIssue($issueid);
	//$issue = $issuearray[0];
//}

if (isset($_POST['reporter'])) {
	$reporterId = $_POST['reporter'];
	//$reporterId = getUserInfo($reporterEmail, "UserId");
}

if (isset($_POST['assignee'])) {
	$assigneeId = $_POST['assignee'];	
	//$assigneeId = getUserInfo($assigneeEmail, "UserId");	
}

if (isset($_POST['type'])) {
	$issuetype = $_POST['type'];
}

if (isset($_POST['status'])) {
	$issuestatus = $_POST['status'];
}

if (isset($_POST['priority'])) {
	$priority = $_POST['priority'];	
}

if (isset($_POST['description'])){
	$description = $_POST['description'];
}

if (isset($_POST['component'])){
	$component = $_POST['component'];
}

if (isset($_POST['name'])){
	$name = $_POST['name'];
}
/* check if the user is the reporter / assignee */
if (!empty($reporterId) && !empty($assigneeId)  && !empty($name)) {
	
	
	$createissueresult = createIssue($component, $name, $description, $reporterId, $assigneeId, $issuetype, $priority, $issuestatus);
	
	if (!($createissueresult)){
		echo "-4";
	} else {
		echo "1";
	}
	
} else {	
	//echo "-3";
	
	echo "-3 ";
}




?>