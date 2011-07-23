<?php

/* Callback script responible for accepting POST requests (ajax calls) and then calling the appropriate functions to create a 
 component for the specified project.
 * Returns 1 if successful, otherwise -1
 * 
*/
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
		addComponentByProjectId($projectid);
		$result = getComponentsByProjectId($projectid);
	}
	
	if (!empty($result)){
		
		$response = 1;
	} else {
		$response = -1;
	}
	
	
	echo $response;

 ?>