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
		
		$query = $connection->stmt_init();
		$sql_createProject = "";
		
		if ($query->prepare($sql_createProject)) {
			
			
		}
		
	}

	function deleteProject() {
		
		$query = $connection->stmt_init(); 
		$sql_deleteProject = "";
		
		if ($query->prepare($sql_deleteProject)) {
			
			
		}
	
	}


	function modifyProject() {
		
		$query = $connection->stmt_init(); 
		$sql_modifyProject = ""; 
		
		if ($query->prepare($sql_modifyProject))  {
			
			
		}
	
	}
	
	
	function checkProjectExists($project) {
		
		$query = $connection->stmt_init();
		$sql_getProjectInfo = "";
		
		if ($query->prepare($sql_getProjectInfo)) {
					
		}	 
	}
	
	
	
	function changeProjectStatus() {
		
		$query = $connection->stmt_init(); 
		$sql_changeProjectStatus = "";
		
		if ($query->prepare($sql_changeProjectStatus)) {
			
		}
	
	}

	
?>