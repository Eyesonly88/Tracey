<?php 
	

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sanitize.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/headers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/footers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/formfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_connect.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_connect.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_other.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_checks.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_prepared.php');

	
	function createProject() { 
		global $connection;
		$query = $connection->stmt_init();
		$sql_createProject = "";
		
		if ($query->prepare($sql_createProject)) {
			
			
		}
		
	}

	function deleteProjectById($id) {
		global $connection;
		$query = $connection->stmt_init(); 
		$sql_deleteProject = "DELETE FROM Project WHERE ProjectId = ?";
		
		if ($query->prepare($sql_deleteProject)) {
			
			$query->bind_param("i", $pid);
			$pid = $id;		
			$query->execute();	
			
		}
	
	}


	function modifyProject() {
		global $connection;
		$query = $connection->stmt_init(); 
		$sql_modifyProject = ""; 
		
		if ($query->prepare($sql_modifyProject))  {
			
			
		}
	
	}
	
	
	function checkProjectExists($project) {
		global $connection;
		$query = $connection->stmt_init();
		$sql_getProjectInfo = "";
		
		if ($query->prepare($sql_getProjectInfo)) {
					
		}	 
	}
	
	
	
	function changeProjectStatus() {
		global $connection;
		$query = $connection->stmt_init(); 
		$sql_changeProjectStatus = "";
		
		if ($query->prepare($sql_changeProjectStatus)) {
			
		}
	
	}
	
	function getProjectsByUserId($userid) {
		
		
	}
	
	function getProjectsByEmail($email) {
		
		
	}

	function getWatchedProjectsByUserEmail($email) {
		
	}
	
	function getWatchedProjectsByUserId($userid) {
			
		
	}
	
	
	
?>