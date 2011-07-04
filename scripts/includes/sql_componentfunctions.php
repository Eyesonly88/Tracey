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

	/* Adds a component to the specified project @TODO: component table needs a few more fields to be added e.g. 'ComponentName' */
	function addComponentByProjectId($projectid){
		
		global $connection;
		$query = $connection->stmt_init(); 
		$sql_addComponent = "INSERT INTO Component(ProjectId) VALUES(?)";	
		if ($query->prepare($sql_addComponent)) {		
			$query->bind_param("i", $pid);	
			$pid = $projectid;
			$query->execute();			
		}	
	}
	
	function changeComponentStatus($componentid, $statusid){	
		
	}
	
	function removeComponent($componentidbyid){
		
	}
	
	
	function addUserToComponentById($componentid, $userid){
		
	}
	
	function addUserToComponentByEmail($componentid, $useremail){
		
	}
	

?>