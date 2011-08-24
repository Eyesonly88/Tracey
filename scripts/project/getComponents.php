<?php 


// Call-back script that accepts ajax post requests, and retrieves a table of components that is part of specified project


$projectid = '';

	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_componentfunctions.php');
	
	$email = '';
	$result = '';
	$response = '<thead><tr><th>Component</th><th>Required Hours</th><th>Creation Date</th><th>Link</th></tr></thead>';
	if (isset($_POST['id'])){
		$projectid = $_POST['id'];		
		$result = getComponentsByProjectId($projectid);
		
	}
	
	if (!(empty($result))) {
		$response = '';
		//$response = '<table class="projlistflex"  border="1" cellpadding="3" cellspacing="0">';

		$response = $response . '<thead><tr><th>Component</th><th>Required Hours</th><th>Creation Date</th><th>Link</th></tr></thead>';
		$response = $response . '<tbody>';	
		foreach($result as $row){
			$response = $response . '<tr>';
			$response = $response . '<td class="c_id" name="c_id" align="center">' . $row['Name'] . '</td>';
			$response = $response . '<td class="c_hours" name="c_hours" align="center">' . $row['RequiredHours'] . '</td>';
			$response = $response . '<td class="c_date" name="c_date" align="center">' . $row['CreationDate'] . '</td>';
			$response = $response . '<td class="c_editcomponent" name="c_editcomponent_button" id="edit_component_' . $row['ComponentId'] . '" align="center"><a href="#"> View </a></td>';
			$response = $response . '</tr>';
		}
		$response = $response . '</tbody>';		
	} 
	
	
	echo $response;

?>