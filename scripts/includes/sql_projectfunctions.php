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

	
	function createProject($name, $email) { 
		global $connection;
		$temp = $email;
		$user = getUserInfo("$temp", "UserId");
		$query = $connection->stmt_init();
		
		
		$sql_createProject = "INSERT INTO Project(ProjectName, ProjectLeader) VALUES(?, ?)";
		
		if ($query->prepare($sql_createProject)) {
			
			$query->bind_param("sd", $pname, $pleader);
			$pname = $name;
			$pleader = $user;
			$query->execute();
			return "1";
			
		}
		return "0";
		
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
		
		global $connection;
		$emailExists = 0;
		$userinfo = array();
		$results = NULL;
		$query = $connection ->stmt_init();
		
		$sql_getProjects = "SELECT p.ProjectId, p.ProjectName, p.ProjectType, p.ProjectLeader from Project p INNER JOIN User u ON u.UserId = p.ProjectLeader WHERE Email=?";	
		$query->prepare($sql_getProjects);
		$query -> bind_param("s", $em);
		$em = $email;		
		$results = dynamicBindResults($query);	
				
		if (empty($results)) { 	
			return "";
		}

		$userinfo = $results;		
		return $userinfo;
		
	}

	function getWatchedProjectsByUserEmail($email) {
		
	}
	
	function getWatchedProjectsByUserId($userid) {
			
		
	}
	
	
	
?>