<?php 

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');

$response = -1;

if (isset($_POST['userid']) && isset($_POST['projectid'])) {
	
	$response = (checkUserBelongsToProject($_POST['projectid'], $_POST['userid']));
}

echo $response;

?>