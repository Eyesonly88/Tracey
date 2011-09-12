<?php 
	
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
	
	$email = '';
	$result = '';
	$response = '<thead><tr><th>Issue</th><th>Title</th><th>Assignee</th><th>Component</th><th>Status</th><th>Link</th></tr></thead>';
	if (isset($_POST['id']) && isset($_POST['email'])){
		$projectid = $_POST['id'];	
		$email = $_SESSION['email'];
		$userid = getUserInfo($email, "UserId");
		$result = getUserComponentIssuesById($userid, $projectid);
	}
	
	
	if (!(empty($result))) {
		$response = '';
		//$response = '<table class="projlistflex"  border="1" cellpadding="3" cellspacing="0">';

		$response = $response . '<thead><tr><th>Issue</th><th>Title</th><th>Assignee</th><th>Component</th><th>Status</th><th>Link</th></tr></thead>';
		$response = $response . '<tbody>';	
		foreach($result as $row){
			$componentid = $row['ComponentId'];
			$componentarray = getComponentInfoById($componentid);
			$componentinfo = $componentarray[0];
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
			$response = $response . '<td class="ii_id" name="pp_id" align="center">' . $row['IssueId'] . '</td>';
			$response = $response . '<td class="ii_name" name="ii_name" align="center">' . $row['Name'] . '</td>';
			$response = $response . '<td class="ii_assignee" name="ii_assignee" align="center">' . $assignee . '</td>';
			$response = $response . '<td class="ii_priority" name="ii_priority" align="center">' . $componentinfo['Name'] . '</td>';
			$response = $response . '<td class="ii_status" name="ii_status" align="center">' . getStatusNameById($row['IssueStatus']). '</td>';
			$response = $response . '<td class="ii_p_viewissue" name="ii_viewissue_button" id="i' . $row['IssueId'] . '" align="center"><a id="view_issue' . $row['IssueId'] . '" rel="shadowbox;width=1100;height=640" href="newIssue.php?id='. $row['IssueId'] . '"><input type="button"  style="width:80px; height:35px; border-width:1px;" id="viewIssue-button'. $row['IssueId'] . '" value="View" /></a></td>';
			$response = $response . '</tr>';
		}
		$response = $response . '</tbody>';		
	} 
	
	
	echo $response;

?>