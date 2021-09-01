<?php

/* Callback script responible for accepting POST requests (ajax calls) and then calling the appropriate functions to create a 
 component for the specified project.
 * You can delete component by passing the componentid in the POST request instead of the id(projectid).
 * for creating a component: Returns 1 if successful, otherwise -1.
 * for deleting a component: Returns 2.
 * 
*/


	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_componentfunctions.php');
	
	$projectid = '';
	$email = '';
	$result = '';
	$response = '';
	$name = '';
	$hours = '';
	$due = '';
	if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email'])){
		$projectid = $_POST['id'];		
		$name = $_POST['name'];
		$email = $_POST['email'];
		$userid = getUserInfo($email, "UserId");
		
		if (isset($_POST['due'])) {
			$due = $_POST['due'];
		}
		
		if (isset($_POST['hours'])) {
			$hours = $_POST['hours'];
		}
		
		$response = addNamedComponentByProjectId($projectid, $hours, $due, $name, 0, $userid);

		if (!empty($response)) {
			$response = 1;
		} else {
			$response = -1;
		}
		
	} else if (isset($_POST['componentid'])){
		$componentId = $_POST['componentid'];
		removeComponent($componentId);
		$response = 2;
	} else {
		$response = -2;
	}
	
	echo $response;

 ?>