<?php

/* Callback script responible for accepting POST requests (ajax calls) and then calling the appropriate functions to create a 
 component for the specified project.
 * You can delete component by passing the componentid in the POST request instead of the id(projectid).
 * for creating a component: Returns 1 if successful, otherwise -1.
 * for deleting a component: Returns 2.
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
		
		if (!empty($result)){
			$response = 1;
		} else {
			$response = -1;
		}
	} else if (isset($_POST['componentid'])){
		$componentId = $_POST['componentid'];
		removeComponent($componentId);
		$response = 2;
	}
	
	echo $response;

 ?>