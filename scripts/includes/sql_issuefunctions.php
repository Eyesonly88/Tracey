<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sanitize.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/headers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/footers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/formfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_connect.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_other.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_checks.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_prepared.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_notificationfn.php');

/*
 * A function that creates an issue for a project component.
 * @param:	$compId: The project component Id. The other parameters are self-explanatory.
 * @return: true if successful, false otherwise.
 * @TESTED:OK
 */
	function createIssue($compId, $name, $desc, $reporterId, $assigneeId, $issueTypeId, $PriorityId, $issueStatusId) {
		global $connection;
		$query = $connection->stmt_init();
		$sql_createIssue = "INSERT INTO issue (`IssueId`, `ComponentId`, `name`, `Description`, `ReporterId`, `AssigneeId`, `IssueType`, `Priority`, `IssueStatus`, `CreationDate`) 
		VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$sql_getLastInsertId = "SELECT LAST_INSERT_ID() AS ID";
		
		if ($query->prepare($sql_createIssue)) {
			$query->bind_param("issiiiiis", $compId, $name, $desc, $reporterId, $assigneeId, $issueTypeId, $PriorityId, $issueStatusId, $cdate);
			date_default_timezone_set("Pacific/Auckland");
			$cdate = date('Y-m-d H:i:s');
			$query->execute();
			$query->prepare($sql_getLastInsertId);
			$lastinsertarray = dynamicBindResults($query);
			// send notification for to the receiver of the newly created issue
			$issueId = $lastinsertarray[0]['ID'];
			
			$reporterEmail = getUserInfoById($reporterId, "Email");
			$assigneeEmail = getUserInfoById($assigneeId, "Email");
			sendNotifByIssue($reporterEmail, $assigneeEmail, $issueId);
			return true;
		} else {
			return false;
		}
	}
	
/*
 * A function that changes the status of an issue.
 * @param:	$issueId:	The Id of the issue we are trying to change.
 * 			$status:	The status id we are trying to put.
 * @return: true if successful, false otherwise.
 * @TESTED:OK
 */	
	function changeIssueStatus($issueId, $status) {
		global $connection;
		$query = $connection->stmt_init();
		$sql_changeIssueStatus = "UPDATE issue SET IssueStatus = ? WHERE IssueId = ?";
		
		if ($query->prepare($sql_changeIssueStatus)) {
			$query->bind_param("ii", $status,$issueId);	
			$query->execute();
			return true;
		}else {
			// update operation failed.
			return false;
		}
	}
/*
 * A function that assigns an issue to a user.
 * @param:	$issueId:	The Id of the issue we are trying to modify.
 * 			$reporterId:The Id of the creator of the issue.
 * 			$assigneeEmail:The e-mail address of the user who's going to be assigned to this issue.
 * @return: true if successful, false otherwise.
 * @TESTED:OK
 */		
	function assignIssueTo($issueId, $reporterId, $assigneeEmail) {
		global $connection;
		$query = $connection->stmt_init();
		$sql_changeIssueStatus = "UPDATE issue SET AssigneeId = ? WHERE IssueId = ? AND ReporterId = ?";
		$result = getUserByEmail($assigneeEmail);
		$assigneeId = $result['UserId'];
		if ($query->prepare($sql_changeIssueStatus)) {
			$query->bind_param("iii", $assigneeId, $issueId,$reporterId);	
			$query->execute();
			return true;
		}else {
			// update operation failed.
			return false;
		}
	}
/*
 * A function that modifies an issue.
 * @param:	$compId:	The project component Id. The other parameters are self-explanatory.
 * @return: true if successful, false otherwise.
 * @TESTED:OK
 */		
	function modifyIssue($issueId, $compId, $name, $desc, $reporterId, $assigneeId, $issueTypeId, $PriorityId, $issueStatusId){
		
		global $connection;
		$query = $connection->stmt_init();
		$previssue = getIssue($issueId);
		$previd = $previssue[0]['IssueId'];
		$desc = trim($desc);
		if ($issueStatusId == 2 && $previd != 2) {
			$sql_stmnt = "UPDATE issue 
						SET	ComponentId = ?, 
							name = ?, 
							Description = ?, 
							AssigneeId = ?, 
							ReporterId = ?, 
							IssueType = ?, 
							Priority = ?, 
							IssueStatus = ?, 
							LastModificationDate = ?, 
							ResolvedDate = ? 
						WHERE IssueId = ?";
			if ($query->prepare($sql_stmnt)) {
			$query->bind_param("issiiiiissi", $compId, $name, $desc, $assigneeId, $reporterId, $issueTypeId, $PriorityId, $issueStatusId, $lmdate, $rdate, $issueId);
			date_default_timezone_set("Pacific/Auckland");
			$lmdate = date('Y-m-d H:i:s');	
			$rdate = date('Y-m-d H:i:s');
			$query->execute();
			return true;
			} else {
				// update operation failed.
				return false;
			}
		} else {
			$sql_stmnt = "UPDATE issue 
						SET	ComponentId = ?, 
							name = ?, 
							Description = ?, 
							AssigneeId = ?, 
							ReporterId = ?, 
							IssueType = ?, 
							Priority = ?, 
							IssueStatus = ?, 
							LastModificationDate = ? 
						WHERE IssueId = ?";
			if ($query->prepare($sql_stmnt)) {
			$query->bind_param("issiiiiisi", $compId, $name, $desc, $assigneeId, $reporterId, $issueTypeId, $PriorityId, $issueStatusId, $lmdate, $issueId);
			date_default_timezone_set("Pacific/Auckland");
			$lmdate = date('Y-m-d H:i:s');	
			$query->execute();
			return true;
			} else {
				// update operation failed.
				return false;
			}
		}
		
		
	}
	
/*
 * A function that returns all the issues under a project including all of its components.
 * @return: nothing if there are no issues found for that project
 * 			the result with all the issues.
 * 			-1 if error happened during the prepared statement.
 * @param:	$projectid:	The Id of the project that has the issues.
 * @TESTED:OK
 */

	function getIssuesByProjectId($projectid) {
		global $connection;
	
		$query = $connection->stmt_init();
	
		$sql_stmnt = "SELECT * FROM issue as i, component as c WHERE i.ComponentId = c.ComponentId AND c.ProjectId = ?";
		if($query->prepare($sql_stmnt)){
			$query->bind_param("i", $projectid);	
			$results = dynamicBindResults($query);
			if (empty($results)) { 	
				return "";
			}
			else {
				// returns all the issues in arrays within the results array
				return $results;
			}
		} else {
			// error happened while fetching the count of notifications
			return -1;
		}
	}
	
/*
 * A function that returns all the issues assigned to a user.
 * @return: nothing if there are no issues found for that user.
 * 			the result with all the issues.
 * 			-1 if error happened during the prepared statement.
 * @param:	$userid:	The Id of the user.
 * @TESTED:OK
 */
	
	function getAssignedIssuesByUserId($userid) {
		global $connection;
	
		$query = $connection->stmt_init();
	
		$sql_stmnt = "SELECT * FROM issue WHERE AssigneeId = ?";
		if($query->prepare($sql_stmnt)){
			$query->bind_param("i", $userid);	
			$results = dynamicBindResults($query);
			if (empty($results)) { 	
				return "";
			}
			else {
				// returns all the issues in arrays within the results array
				return $results;
			}
		} else {
			// error happened while fetching the count of notifications
			return -1;
		}
	}
	
/*
 * A function that returns all the issues assigned to a user.
 * @return: nothing if there are no issues found for that user.
 * 			the result with all the issues.
 * 			-1 if error happened during the prepared statement.
 * @param:	$email:	The e-mail addresss of the user.
 * @TESTED:OK
 */	
 
	function getAssignedIssuesByEmail($email){
		global $connection;
		$query = $connection->stmt_init();
		$result = getUserByEmail($email);

		$assigneeId = $result['UserId'];
		$sql_stmnt = "SELECT * FROM issue WHERE AssigneeId = ?";
		if($query->prepare($sql_stmnt)){
			$query->bind_param("i", $assigneeId);	
			$results = dynamicBindResults($query);
			if (empty($results)) { 	
				return "";
			}
			else {
				// returns all the issues in arrays within the results array
				return $results;
			}
		} else {
			// error happened while fetching the count of notifications
			return -1;
		}
	}

/*
 * A function that returns all the issues watched by a user.
 * @return: nothing if there are no issues watched for that user.
 * 			the result with all the issues.
 * 			-1 if error happened during the prepared statement.
 * @param:	$userid:	The Id of the user.
 * @TESTED:OK
 */	

	function getWatchedIssuesByUserId($userid){
		global $connection;
	
		$query = $connection->stmt_init();
		$sql_stmnt = "SELECT IssueId FROM issuewatches WHERE UserId = ?";
		if($query->prepare($sql_stmnt)){
			$query->bind_param("i", $userid);	
			$results = dynamicBindResults($query);
			if (empty($results)) { 	
				return "";
			}
			else {
				// returns all the issues in arrays within the results array
				return $results;
			}
		} else {
			// error happened while fetching the count of notifications
			return -1;
		}
	}
	
/*
 * A function that returns all the issues watched by a user.
 * @return: nothing if there are no issues watched for that user.
 * 			the result with all the issues.
 * 			-1 if error happened during the prepared statement.
 * @param:	$email:	The e-mail addresss of the user.
 * @TESTED:OK
 */	
 	
	function getWatchedIssuesByEmail($email){
		global $connection;
	
		$query = $connection->stmt_init();
		$result = getUserByEmail($email);
		$userId = $result['UserId'];
		$sql_stmnt = "SELECT IssueId FROM issuewatches WHERE UserId = ?";
		if($query->prepare($sql_stmnt)){
			$query->bind_param("i", $userId);	
			$results = dynamicBindResults($query);
			if (empty($results)) { 	
				return "";
			}
			else {
				// returns all the issues in arrays within the results array
				return $results;
			}
		} else {
			// error happened while fetching the count of notifications
			return -1;
		}
	}
	
	function getIssue($issueId){
		global $connection;
	
		$query = $connection->stmt_init();
		$sql_stmnt = "SELECT * FROM issue WHERE IssueId = ?";
		if($query->prepare($sql_stmnt)){
			$query->bind_param("i", $issueId);	
			$results = dynamicBindResults($query);
			if (empty($results)) { 	
				return "";
			}
			else {
				// returns all the issues in arrays within the results array
				return $results;
			}
		} else {
			// error happened while fetching the count of notifications
			return -1;
		}
	}
	
	function getIssueStatuses(){
		global $connection;
		$query = $connection->stmt_init();
		$sql_stmnt = "SELECT * FROM issuestatus";
		if($query->prepare($sql_stmnt)){
			
			$results = dynamicBindResults($query);
			if (empty($results)) { 	
				return "";
			}
			else {
				// returns all the issues in arrays within the results array
				return $results;
			}
		} else {
			// error happened while fetching the count of notifications
			return -1;
		}
	}
	
	function getIssuePriorities(){
		global $connection;
		$query = $connection->stmt_init();
		$sql_stmnt = "SELECT * FROM issuepriority";
		if($query->prepare($sql_stmnt)){
			
			$results = dynamicBindResults($query);
			if (empty($results)) { 	
				return "";
			}
			else {
				// returns all the issues in arrays within the results array
				return $results;
			}
		} else {
			// error happened while fetching the count of notifications
			return -1;
		}
	}
	
	function getIssueTypes(){
		global $connection;
		$query = $connection->stmt_init();
		$sql_stmnt = "SELECT * FROM issuetype";
		if($query->prepare($sql_stmnt)){
			
			$results = dynamicBindResults($query);
			if (empty($results)) { 	
				return "";
			}
			else {
				// returns all the issues in arrays within the results array
				return $results;
			}
		} else {
			// error happened while fetching the count of notifications
			return -1;
		}
	}
	
	
	function getProjectByIssueId($issueid) {
		global $connection;
		$query = $connection->stmt_init();
		$sql_stmnt = "SELECT p.ProjectId, p.ProjectName, p.ProjectType, p.ProjectLeader 
					FROM project p 
					INNER JOIN component c ON c.ProjectId = p.ProjectId 
					INNER JOIN issue i ON i.ComponentId = c.ComponentId
					WHERE i.IssueId = ?";
		if($query->prepare($sql_stmnt)){
			$id = $issueid;
			$query->bind_param("i", $id);			
			$results = dynamicBindResults($query);
			if (empty($results)) { 	
				return "";
			}
			else {
				// returns all the issues in arrays within the results array
				return $results;
			}
		} else {
			// error happened while fetching the count of notifications
			return -1;
		}
		
	}
	
	function logIssueHours($issueid, $issuehours, $description, $user) {
		global $connection;
		$query = $connection->stmt_init();
		$sql_stmnt = "INSERT INTO issuehour (`IssueHourId`, `IssueId`, `Hours`, `Description`, `UserId`, `CreationDate`) VALUES (NULL, ?, ?, ?, ?, ?);";
		if($query->prepare($sql_stmnt)){
		
			$query->bind_param("iisis", $id, $hours, $desc, $userid, $creationdate);		
			$id = $issueid;
			$hours = $issuehours;
			$desc = $description;
			//$phpdate = getdate();
			date_default_timezone_set("Pacific/Auckland");
			$creationdate = date('Y-m-d H:i:s');
			//$creationdate =  date("Y-m-d", strtotime($due));
			//echo "" . $id . " " . $hours . " " . $creationdate;
			
			$userid = getUserInfo($user,"UserId");	
			//echo " " . $id . " " . $hours . " " . $desc . " " . $userid;
			$query->execute();
			return 1;
		} else {
			// error happened while fetching the count of notifications
			return -1;
		}

	}
	
	function getHoursSpentOnIssue($issueid) {
		
		global $connection;
		$query = $connection->stmt_init();
		$hours = 0;
		$sql_stmnt = "SELECT SUM(ih.Hours) AS hours
						FROM issuehour ih
						INNER JOIN issue i ON i.IssueId = ih.IssueId
						WHERE i.IssueId = ?
						";
		
		$query->prepare($sql_stmnt);
		$query->bind_param("i", $id);		
		$id = $issueid;
		
		
		$result = dynamicBindResults($query);
		if ($result[0]['hours'] != NULL)	{
			$hours = $result[0]['hours'];
		} else {
			$hours = 0;
		}
		return $hours;
		
	}
	
	function getPriorityNameById($priorityid) {
		
		global $connection;
		$query = $connection->stmt_init();
		$sql_stmnt = "SELECT Name FROM issuepriority WHERE ID = ?";
		$query->prepare($sql_stmnt);
		$query->bind_param("i", $id);		
		$id = $priorityid;
		$results = dynamicBindResults($query);
		return $results[0]['Name'];
		
	}
	
	function getStatusNameById($statusid) {
		
		global $connection;
		$query = $connection->stmt_init();
		$sql_stmnt = "SELECT Name FROM issuestatus WHERE ID = ?";
		$query->prepare($sql_stmnt);
		$query->bind_param("i", $id);		
		$id = $statusid;
		$results = dynamicBindResults($query);
		return $results[0]['Name'];
		
	}
	
	
	function getWorkLogById($worklogid) {
		
		
		global $connection;
		$query = $connection->stmt_init();
		$sql_stmt = "SELECT * FROM issuehour WHERE IssueHourId = ?";
		$query->prepare($sql_stmt);
		$query->bind_param("i", $id);
		$id = $worklogid;
		$results = dynamicBindResults($query);
		return $results;
		
	}
	
	function getUserComponentIssuesById($userid, $projectid) {
		
		global $connection;
		$query = $connection->stmt_init();
		$sql_stmt = "	SELECT DISTINCT 
						i.IssueId
						, i.ComponentId
						, i.ReporterId
						, i.AssigneeId
						, i.IssueType
						, i.Priority
						, i.CreationDate
						, i.IssueStatus
						, i.ResolvedDate
						, i.LastModificationDate
						, i.Description
						, i.Name
						FROM issue i
						INNER JOIN usercomponent uc ON uc.ComponentId = i.ComponentId
						INNER JOIN component c ON c.ComponentId = uc.ComponentId
						WHERE uc.UserId = ?
						AND c.ProjectId = ?";
		$query->prepare($sql_stmt);
		$query->bind_param("ii", $id, $pid);
		$id = $userid;
		$pid = $projectid;
		$results = dynamicBindResults($query);
		return $results;
		
		
	}

?>