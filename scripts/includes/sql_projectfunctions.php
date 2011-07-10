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
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_componentfunctions.php');

	/* Create a project (and a default component) with projectname: $name, and projectleader: userid of the user with email: $email */
	function createProject($name, $email) { 
		global $connection;
		$temp = $email;
		$lastinsertarray = '';
		$user = getUserInfo("$temp", "UserId");
		$query = $connection->stmt_init();	
		$sql_createProject = "INSERT INTO Project(ProjectName, ProjectLeader) VALUES(?, ?)";	
		$sql_getLastInsertId = "SELECT LAST_INSERT_ID() AS ID";
		if ($query->prepare($sql_createProject)) {
			
			$query->bind_param("sd", $pname, $pleader);
			$pname = $name;
			$pleader = $user;
			$query->execute();
			$query->prepare($sql_getLastInsertId);
			$lastinsertarray = dynamicBindResults($query);
			$projectid = $lastinsertarray[0]['ID'];
			
			/* Using the id of the last created project, add a component to this project (this is the default component) */
			addComponentByProjectId($projectid);
			return "1";
		}
		return "0";	
	}
	
	/* Delete the project with the specified name with the specified user */
	function deleteProjectByName($pname, $userid) {
	
		global $connection;
		$query = $connection->stmt_init(); 
		$sql_deleteProject = "DELETE FROM Project p INNER JOIN User u ON u.UserId = p.ProjectLeader WHERE p.ProjectName=? AND u.UserId=?";	
		if ($query->prepare($sql_deleteProject)) {
			
			$query->bind_param("si", $name, $uid);
			$name = $pname;		
			$uid = $userid;
			$query->execute();			
		}
	
	}
	
	/* Delete a project with the specified project id */
	function deleteProjectById($id) {
		global $connection;
		$query = $connection->stmt_init(); 
		$sql_deleteProject = "DELETE FROM Project p WHERE ProjectId=?";
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
		$sql_changeProjectStatus = "UPDATE Project SET ProjectStatus = ? WHERE ProjectId = ?";
		
		if ($query->prepare($sql_changeProjectStatus)) {
			$query->bind_param("ii", $pstatus, $pid);
			$pstatus = $statusid;
			$pid = $projectid;
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
		$query->prepare($sql_addUserToProject);		
	}

	function getWatchedProjectsByUserEmail($email) {
		
	}
	
	function getWatchedProjectsByUserId($userid) {		
		
	}
	
	
	
?>