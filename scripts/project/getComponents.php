<?php 


// Call-back script that accepts ajax post requests, and retrieves a table of components that is part of specified project



	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_componentfunctions.php');
	
	$projectid = '';
	$email = '';
	$result = '';
	$response = '<thead><tr><th>Component</th><th>Required Hours</th><th>Due Date</th><th>Link</th><th>Join</th></tr></thead>';
	if (isset($_POST['id'])){
		$projectid = $_POST['id'];		
		$result = getComponentsByProjectId($projectid);
		
	}
	
	if (!(empty($result))) {
		$response = '';
		//$response = '<table class="projlistflex"  border="1" cellpadding="3" cellspacing="0">';

		$response = $response . '<thead><tr><th>Component</th><th>Required Hours</th><th>Due Date</th><th>View</th><th>Join</th></tr></thead>';
		$response = $response . '<tbody>';	
		foreach($result as $row){
			$ismember = 0;
			$compid = $row['ComponentId'];
			$useremail = $_SESSION['email'];
			$userid = getUserInfo($useremail, "UserId");
			$componentCheck = checkUserPartOfComponent($compid, $userid);
			if (!empty($componentCheck)) {
				$ismember = 1;
			}
			$response = $response . '<tr>';
			$response = $response . '<td class="c_id" name="c_id" align="center">' . $row['Name'] . '</td>';
			$response = $response . '<td class="c_hours" name="c_hours" align="center">' . $row['RequiredHours'] . '</td>';
			$response = $response . '<td class="c_date" name="c_date" align="center">' . $row['CreationDate'] . '</td>';
			$response = $response . '<td class="c_editcomponent" name="c_editcomponent_button" id="edit_component_' . $row['ComponentId'] . '" align="center"><a rel="shadowbox;width=700;height=223" href="newComponent.php?id=' . $row['ComponentId'] . '"><input type="button"  style="width:80px; height:35px; border-width:1px;" id="viewComp-button'. $row['ComponentId'] . '" value="View" /> </a></td>';
			if ($ismember != 1) {
				$response = $response . '<td class="c_joincomponent" name="c_joincomponent_button" id="join_component_' . $row['ComponentId'] . '" align="center"><a rel="shadowbox;width=700;height=223" href="joinComponent.php?id=' . $row['ComponentId'] . '"><input type="button"  style="width:80px; height:35px; border-width:1px;" id="joinComp-button'. $row['ComponentId'] . '" value="Join" /> </a></td>';
			} else {
				$response = $response . '<td class="c_joincomponent" name="c_joincomponent_button" id="join_component_' . $row['ComponentId'] . '" align="center">Member</td>';
			}
			$response = $response . '</tr>';
		}
		$response = $response . '</tbody>';		
	} 
	
	
	echo $response;

?>