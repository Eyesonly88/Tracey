<?php

/* Error codes: one of the required fields were not set.  */ 

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');

$projName = '';
$projLeaderEmail = '';
$projtype = '';
$hours = '';
$response1 = -1;
$duedate = '';
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['type']) && isset($_POST['hours'])) { 
	$projName = $_POST['name'];
	$projLeaderEmail = $_POST['email'];
	$projtype = $_POST['type'];
	$hours = $_POST['hours'];
	
} else {
	
	echo "-2";
}

if (isset($_POST['due'])) {
	
	$duedate = $_POST['due'];
}

$response1 = createProject($projName, $projLeaderEmail, $projtype, $hours, $duedate);



echo $response1;

?>

