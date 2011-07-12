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

/*
 * A function that creates an issue for a project component.
 * @param:	$compId: The project component Id. The other parameters are self-explanatory.
 * @return: true if successful, false otherwise.
 * @TESTED:OK
 */
	function createIssue($compId, $reporterId, $assigneeId, $issueTypeId, $PriorityId, $issueStatusId) {
		global $connection;
		$query = $connection->stmt_init();
		$sql_createIssue = "INSERT INTO issue (`IssueId`, `ComponentId`, `ReporterId`, `AssigneeId`, `IssueType`, `Priority`, `CreationDate`, `IssueStatus`, `ResolvedDate`, `LastModificationDate`) 
		VALUES (NULL, ?, ?, ?, ?, ?, NOW(), ?, NULL, NOW());";
		
		if ($query->prepare($sql_createIssue)) {
			$query->bind_param("iiiiii", $compId, $reporterId, $assigneeId, $issueTypeId, $PriorityId, $issueStatusId);
			$query->execute();
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
	
	function modifyIssue($issueId){}
	
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
	
		$sql_stmnt = "SELECT IssueId FROM issue as i, component as c WHERE i.ComponentId = c.ComponentId AND c.ProjectId = ?";
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
	
		$sql_stmnt = "SELECT IssueId FROM issue WHERE AssigneeId = ?";
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
		$sql_stmnt = "SELECT IssueId FROM issue WHERE AssigneeId = ?";
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
	
	

?>