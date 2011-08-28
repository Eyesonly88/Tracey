<?php 

	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_componentfunctions.php');
	
 /**
 * Returns a JSON string containing the issueId's assigned to a user.
 * The script expects a GET request from the caller with an email parameter set to be the user's email.
 * @TESTED: OK
 */

 	$result = '';
	$response = '<thead><tr><th>Issue</th><th>Project</th><th>Reporter</th><th>Priority</th><th>Status</th><th>Hours</th><th>Log Hours</th><th>Link</th></tr></thead>';
	if(isset($_POST['email'])){
		$emailadd = $_POST['email'];
		$result = getAssignedIssuesByEmail($emailadd);
		//$jsonResult = json_encode($results);
		//echo $jsonResult;
	}
	
	if (!(empty($result))) {
		$response = '';
		//$response = '<table class="projlistflex"  border="1" cellpadding="3" cellspacing="0">';

		$response = $response . '<thead><tr><th>Issue</th><th>Project</th><th>Reporter</th><th>Priority</th><th>Status</th><th>Hours</th><th>Log Hours</th><th>Link</th></tr></thead>';
		$response = $response . '<tbody>';	
		foreach($result as $row){
			$reporterEmail = getUserInfoById($row['ReporterId'], "Email");
			$assigneeEmail = getUserInfoById($row['AssigneeId'], "Email");
			$reporter = $reporterEmail;
			$temp1 = getUserInfo($reporterEmail, "Nickname");
			if (!empty($temp1)) {
				$reporter = getUserInfo($reporterEmail, "Nickname");
			} 
			
			$assignee = $assigneeEmail;
			$temp2 = getUserInfo($assigneeEmail, "Nickname");
			if (!empty($temp2)) {
				$assignee = getUserInfo($assigneeEmail, "Nickname");
			}
			
			$response = $response . '<tr>';
			$response = $response . '<td class="i_id" name="p_id" align="center">' . $row['IssueId'] . '</td>';
			$response = $response . '<td class="i_component" name="i_component" align="center">' . getProjectNameByComponentId($row['ComponentId']) . '</td>';
			$response = $response . '<td class="i_reporter" name="i_reporter" align="center">' . $reporter . '</td>';
			$response = $response . '<td class="i_priority" name="i_priority" align="center">' . getPriorityNameById($row['Priority']) . '</td>';
			$response = $response . '<td class="i_status" name="i_status" align="center">' . getStatusNameById($row['IssueStatus']) . '</td>';
			$response = $response . '<td class="i_hours" name="i_hours" align="center">' . getHoursSpentOnIssue($row['IssueId']) . '</td>';
			$response = $response . '<td class="i_lhours" name="i_lhours" align="center"><a id="iloghours" rel="shadowbox[Mixed];height=292;width=810" href="logissuehour.php?id=' . $row['IssueId'] . '">Log Hours</a></td>'; 
			$response = $response . '<td class="i_viewissue" name="i_viewissue_button" id="' . $row['IssueId'] . '" align="center"><a id="view_issue' . $row['IssueId'] . '" rel="shadowbox[Mixed];width=1100;height=800" href="newIssue.php?id='. $row['IssueId'] . '">View</a></td>';
			$response = $response . '</tr>';
		}
		$response = $response . '</tbody>';		
	} 

	echo $response;
	
	
	

?>