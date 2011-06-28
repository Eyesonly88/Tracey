<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');

$projName = '';
$projLeader = '';
$response1 = 0;
if (isset($_POST['name'])) { 
	$projName = $_POST['name'];
}

if (isset($_POST['user'])) { 
	$projLeader = $_POST['user'];
}


$response1 = createProject($projName, $projLeader);



echo $response1;

?>

