<?php 

	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
	
	$email = '';
	$result = '';
	$response = '';
	if (isset($_POST['email'])){
		$email = $_POST['email'];		
		$result = getProjectsByEmail($email);	
	}
	
	if (!(empty($result))) {
		$response = '<table border="1" cellpadding="3" cellspacing="0">';

		$response = $response . '<tr><th>Project ID</th><th>Project Name</th><th>Project Type</th></tr>';
		foreach($result as $row){
			$response = $response . '<tr>';
			$response = $response . '<td align="center">' . $row['ProjectId'] . '</td>';
			$response = $response . '<td align="center">' . $row['ProjectName'] . '</td>';
			$response = $response . '<td align="center">' . $row['ProjectType'] . '</td>';
			$response = $response . '</tr>';
		}
		$response = $response . '</table>';		
	}
	
	echo $response;

?>