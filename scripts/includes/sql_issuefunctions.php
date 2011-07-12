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
	
	function getIssuesByProjectId($projectid) {
		
	}
	
	function getAssignedIssuesByUserId($userid) {
		
	}
	
	function getAssignedIssuesByEmail($email){
		
	}
	
	function getWatchedIssuesByUserId($userid){
		
	}
	
	function getWatchedIssuesByEmail($email){
		
	}
	
	

?>