<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');

$projName = '';
$projLeaderEmail = '';
$response1 = -1;
if (isset($_POST['name']) && isset($_POST['email'])) { 
	$projName = $_POST['name'];
	$projLeaderEmail = $_POST['email'];
}

$response1 = createProject($projName, $projLeaderEmail);



echo $response1;

?>

