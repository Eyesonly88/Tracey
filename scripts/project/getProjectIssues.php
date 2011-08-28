<?php 

	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
	
	$email = '';
	$result = '';
	$response = '<thead><tr><th>Issue</th><th>Title</th><th>Assignee</th><th>Priority</th><th>Status</th><th>Link</th></tr></thead>';
	if (isset($_POST['id'])){
		$projectid = $_POST['id'];		
		$result = getIssuesByProjectId($projectid);
	}
	
	
	if (!(empty($result))) {
		$response = '';
		//$response = '<table class="projlistflex"  border="1" cellpadding="3" cellspacing="0">';

		$response = $response . '<thead><tr><th>Issue</th><th>Title</th><th>Assignee</th><<th>Priority</th><th>Status</th><th>Link</th></tr></thead>';
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
			$response = $response . '<td class="i_name" name="i_name" align="center">' . $row['name'] . '</td>';
			$response = $response . '<td class="i_assignee" name="i_assignee" align="center">' . $assignee . '</td>';
			$response = $response . '<td class="i_priority" name="i_priority" align="center">' . getPriorityNameById($row['Priority']) . '</td>';
			$response = $response . '<td class="i_status" name="i_status" align="center">' . getStatusNameById($row['IssueStatus']). '</td>';
			$response = $response . '<td class="i_p_viewissue" name="i_viewissue_button" id="' . $row['IssueId'] . '" align="center"><a id="view_issue' . $row['IssueId'] . '" rel="shadowbox;width=1100;height=700" href="newIssue.php?id='. $row['IssueId'] . '"><input type="button"  style="width:80px; height:35px; border-width:1px;" id="viewIssue-button'. $row['IssueId'] . '" value="View" /></a></td>';
			$response = $response . '</tr>';
		}
		$response = $response . '</tbody>';		
	} 
	
	
	echo $response;

?>