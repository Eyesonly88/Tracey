<?php

	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');

$issueid = '';
$hours = '';
$description = '';
$logresult = -1;
$user = '';

if (isset($_POST['id']) && isset($_POST['hours']) && isset($_POST['desc']) && isset($_POST['user'])){

	$issueid = $_POST['id'];	
	$hours = $_POST['hours'];
	$description = $_POST['desc'];
	$user = $_POST['user'];
	
	if (empty($issueid) || empty($hours) ||  empty($user))  {
		
		$logresult = -1;
	} else {
	
	//echo "" . $issueid . " " . $hours . " " . $description . " " . $user;
	
		$logresult = logIssueHours($issueid, $hours, $description, $user);	
	}
}

echo $logresult;

?>