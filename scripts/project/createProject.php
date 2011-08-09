<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');

$projName = '';
$projLeaderEmail = '';
$response1 = -1;
if (isset($_POST['name'])) { 
	$projName = $_POST['name'];
}

if (isset($_POST['email'])) { 
	$projLeaderEmail = $_POST['email'];
}


$response1 = createProject($projName, $projLeaderEmail);



echo $response1;

?>

