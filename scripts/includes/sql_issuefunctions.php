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


	function createIssue() {
		global $connection;
		$query = $connection->stmt_init();
		$sql_createIssue = "";
		
		if ($query->prepare($sql_createIssue)) {
			
		}
	}
	
	
	function changeIssueStatus($issueId, $status) {
		global $connection;
		$query = $connection->stmt_init();
		$sql_changeIssueStatus = "";
		
		if ($query->prepare($sql_changeIssueStatus)) {
			
		}
	}
	
	function assignIssueTo($issueid, $reporterId, $assigneeEmail) {
		
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