<?php 

	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
	
	$email = '';
	$result = '';
	$response = '<thead><tr><th>Issue</th><th>Component</th><th>Reporter</th><th>Assignee</th><th>Type</th><th>Priority</th><th>Status</th><th>Link</th></tr></thead>';
	if (isset($_POST['id'])){
		$projectid = $_POST['id'];		
		$result = getIssuesByProjectId($projectid);
	}
	
	
	if (!(empty($result))) {
		$response = '';
		//$response = '<table class="projlistflex"  border="1" cellpadding="3" cellspacing="0">';

		$response = $response . '<thead><tr><th>Issue</th><th>Component</th><th>Reporter</th><th>Assignee</th><th>Type</th><th>Priority</th><th>Status</th><th>Link</th></tr></thead>';
		$response = $response . '<tbody>';	
		foreach($result as $row){
			$reporterEmail = getUserInfoById($row['ReporterId'], "Email");
			$assigneeEmail = getUserInfoById($row['AssigneeId'], "Email");
			$response = $response . '<tr>';
			$response = $response . '<td class="i_id" name="p_id" align="center">' . $row['IssueId'] . '</td>';
			$response = $response . '<td class="i_component" name="i_component" align="center">' . $row['ComponentId'] . '</td>';
			$response = $response . '<td class="i_reporter" name="i_reporter" align="center">' . $reporterEmail . '</td>';
			$response = $response . '<td class="i_assignee" name="i_assignee" align="center">' . $assigneeEmail . '</td>';
			$response = $response . '<td class="i_type" name="i_type" align="center">' . $row['IssueType'] . '</td>';
			$response = $response . '<td class="i_priority" name="i_priority" align="center">' . $row['Priority'] . '</td>';
			$response = $response . '<td class="i_status" name="i_status" align="center">' . $row['IssueStatus'] . '</td>';
			$response = $response . '<td class="i_p_viewissue" name="i_viewissue_button" id="' . $row['IssueId'] . '" align="center"><a rel="shadowbox[Mixed]" href="issue.php?id='. $row['IssueId'] . '">View Issue</a></td>';
			$response = $response . '</tr>';
		}
		$response = $response . '</tbody>';		
	} 
	
	
	echo $response;

?>