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
	
	/* Checks if a project with $projectname exists for the user with $userid */
	function checkProjectExistsByName($projectname, $userid) {
		global $connection;
		$query = $connection->stmt_init();
		$results = '';
		$sql_getProjectInfo = "SELECT p.ProjectId, p.ProjectName FROM Project p INNER JOIN User u ON u.UserId = p.ProjectLeader WHERE p.ProjectName=? AND u.UserId=?";
		$query->prepare($sql_getProjectInfo);
		$query->bind_param("ss", $name, $uid);
		$name = $projectname;
		$uid = $userid;
		
		$results = dynamicBindResults($query);
		
		if (empty($results)) {
			return '';			
		}
		
		return $results;
	}
	
	
	/* Updates the status of the selected project ($projectid) with the status that corresponds to $statusid */
	function changeProjectStatus($projectid, $statusid) {
		global $connection;
		$query = $connection->stmt_init(); 
		$sql_changeProjectStatus = "";
		
		if ($query->prepare($sql_changeProjectStatus)) {		
		}
	}
	
	
	/* Gets the list of projects created by the user with $userid */
	function getProjectsByUserId($userid) {
		
		global $connection;
		$userinfo = array();
		$results = '';
		$query = $connection -> stmt_init();
		
		$sql_getProjects = "SELECT p.ProjectId, p.ProjectName, p.ProjectType, p.ProjectLeader from Project p INNER JOIN User u ON u.UserId = p.ProjectLeader WHERE u.UserId=?";
		$query->prepare($sql_getProjects);
		$query -> bind_param("s", $id);
		$id = $userid;
		$results = dynamicBindResults($query);
		
		if (empty($results)) {
			return '';
		}
		$userinfo = $results;
		return $userinfo;	
	}
	
	/* Gets the projects created by the user with email $email */
	function getProjectsByEmail($email) {
		
		global $connection;
		$emailExists = 0;
		$userinfo = array();
		$results = '';
		$query = $connection ->stmt_init();	
		$sql_getProjects = "SELECT p.ProjectId, p.ProjectName, p.ProjectType, p.ProjectLeader from Project p INNER JOIN User u ON u.UserId = p.ProjectLeader WHERE Email=?";	
		$query->prepare($sql_getProjects);
		$query -> bind_param("s", $em);
		$em = $email;		
		$results = dynamicBindResults($query);	
				
		if (empty($results)) { 	
			return '';
		}
		
		$userinfo = $results;		
		return $userinfo;
		
	}
	
	function addUserToProject($projectid, $useremail) {
			
		global $connection;
		$query = $connection->stmt_init();	
		$sql_addUserToProject = "";
			
		
	}
	

	function getWatchedProjectsByUserEmail($email) {
		
	}
	
	function getWatchedProjectsByUserId($userid) {
			
		
	}
	
	
	
?>