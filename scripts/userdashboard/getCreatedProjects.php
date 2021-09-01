<?php 

	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
	
	$email = '';
	$result = '';
	$response = '';
	$response = $response . '<thead><tr><th>Project</th><th>Project Leader</th><th>Hours Logged</th><th>Dashboard Link</th></tr></thead>';
	if (isset($_POST['email'])){
		$email = $_POST['email'];		
		$result = getProjectsByEmail($email);	
	}
	
	if (!(empty($result))) {
		//$response = '<table class="projlistflex"  border="1" cellpadding="3" cellspacing="0">';
		//$userid = $row['ProjectLeader'];
		//$userinfo = getUserInfoById($userid, "Email");
		$response = '';
		$response = $response . '<thead><tr><th>Project</th><th>Project Leader</th><th>Hours Logged</th><th>Dashboard Link</th></tr></thead>';
		$response = $response . '<tbody>';	
		foreach($result as $row){
			$response = $response . '<tr>';
			$response = $response . '<td class="p_name" name="p_name" align="center">' . '<a href="/project_dashboard.php?id='. $row['ProjectId'] . '">' . $row['ProjectName']. '</a></td>';
			$response = $response . '<td class="p_leader" name="p_leader" align="center">' . getUserInfoById($row['ProjectLeader'], "Email") . '</td>';
			$response = $response . '<td class="p_hours" name="p_hours" align="center">' . getHoursLoggedByProjectId($row['ProjectId']) . '</td>';
			$response = $response . '<td name="p_dashboard_button" class="p_dashboard_button" id="goto_project" align="center"><a href="/project_dashboard.php?id=' . $row['ProjectId'] . '"> <input type="button" style="width:100px; height:35px; border-width:1px;" id="viewDashboard-button'. $row['ProjectId'] . '" value="Dashboard" /></a></td>';
			$response = $response . '</tr>';
		}
		$response = $response . '</tbody>';		
	}
	
	
	/*
	$json = array();
	$rowdata = array();
	
	if (!(empty($result))) {

		foreach($result as $row){
			$rowdata[] = $row;
		}
		
	}
	
	
	$response = $rowdata;*/
	echo $response;

?>