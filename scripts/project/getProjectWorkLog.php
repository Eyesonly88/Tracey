<?php 

	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
	
	$email = '';
	$result = '';
	$response = '<thead><tr><th>Issue</th><th>Created By</th><th>Hours Logged</th><th>Date</th><th>Link</th></tr></thead>';
	
	if (isset($_POST['id'])){
		$projectid = $_POST['id'];		
		$result = getRecentWorkLogsByProjectId($projectid);
	}
	
	
	if (!(empty($result))) {
		$response = '';
		//$response = '<table class="projlistflex"  border="1" cellpadding="3" cellspacing="0">';

		$response = $response . '<thead><tr><th>Issue</th><th>Created By</th><th>Hours Logged</th><th>Date</th><th>Link</th></tr></thead>';
		$response = $response . '<tbody>';	
		foreach($result as $row){
			$email = getUserInfoById($row['UserId'], "Email");
		
			$user = $email;
			$temp1 = getUserInfo($email, "Nickname");
			if (!empty($temp1)) {
				$user = getUserInfo($email, "Nickname");
			} 
			
			
			$response = $response . '<tr>';
			$response = $response . '<td class="w_id" name="w_id" align="center">' . $row['IssueId'] . '</td>';
			$response = $response . '<td class="w_user" name="w_user" align="center">' . $user. '</td>';
			$response = $response . '<td class="w_hours" name="w_hours" align="center">' . $row['Hours'] . '</td>';
			$response = $response . '<td class="w_date" name="w_date" align="center">' . $row['CreationDate'] . '</td>';
			
			$response = $response . '<td class="w_p_viewlog" name="w_viewlog_button" id="w' . $row['ID'] . '" align="center"><a id="view_log' . $row['IssueId'] . '" rel="shadowbox;width=700;height=160" href="worklog.php?id='. $row['ID'] . '"><input type="button"  style="width:80px; height:35px; border-width:1px;" id="viewLog-button'. $row['ID'] . '" value="View Log" /></a></td>';
			$response = $response . '</tr>';
		}
		$response = $response . '</tbody>';		
	} 
	
	
	echo $response;

?>