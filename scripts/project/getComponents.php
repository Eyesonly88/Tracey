<?php 


// Call-back script that accepts ajax post requests, and retrieves a table of components that is part of specified project


$projectid = '';

	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_componentfunctions.php');
	
	$email = '';
	$result = '';
	$response = '';
	if (isset($_POST['id'])){
		$projectid = $_POST['id'];		
		$result = getComponentsByProjectId($projectid);
		$response = json_encode($result);
	}
	
	
	if (!empty($result)){
		
		
	}
	
	
	echo $response;

?>