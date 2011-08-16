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
	function createProject($name, $email, $type, $hours, $due) {
		 
		global $connection;
		$temp = $email;
		$lastinsertarray = '';
		//return $temp;
		$user = getUserInfo("$temp", "UserId");
		
		$query = $connection->stmt_init();	
		$sql_createProject = "INSERT INTO Project(ProjectName, ProjectType, ProjectLeader) VALUES(?, ?, ?)";	
		$sql_getLastInsertId = "SELECT LAST_INSERT_ID() AS ID";
		if ($query->prepare($sql_createProject)) {
			
			$query->bind_param("sid", $pname, $ptype, $pleader);
			$pname = $name;
			$ptype = $type;
			$pleader = $user;
			$query->execute();
			$query->prepare($sql_getLastInsertId);
			$lastinsertarray = dynamicBindResults($query);
			$projectid = $lastinsertarray[0]['ID'];
			
			/* Using the id of the last created project, add a component to this project (this is the default component) */
			addComponentByProjectId($projectid, $hours, $due);
			return 1;
		}
		return 0;	
	}
	
	function getAllProjectTypes() {
		global $connection; 
		$query = $connection->stmt_init();	
		$sql_projectTypes = "SELECT * FROM projecttype";
		if ($query->prepare($sql_projectTypes)) {
			$result = dynamicBindResults($query);
			if (empty($result)){ return ''; }
			return $result;
		}
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

	/* @todo */
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
	
	function checkUserBelongsToProject($projectid, $email) {
		
		global $connection; 
		$query = $connection -> stmt_init();
		
		
		/* Check if user is project leader. */
		$sql = "SELECT * FROM project p INNER JOIN user u ON p.ProjectLeader = u.UserId WHERE p.ProjectId = ? AND u.Email = ?";
		$query->prepare($sql);
		$query->bind_param("is", $pid, $em);
		$pid = $projectid;
		$em = $email;
		$results = dynamicBindResults($query);
		if (!empty($results)) {
			return 1;
		}	
		
		/* Check if user belongs to a module in the project */
		$sql = "
		SELECT * 
		FROM usercomponent uc 
		INNER JOIN component c ON c.ComponentId = uc.ComponentId 
		INNER JOIN project p ON c.ProjectId = p.ProjectId
		INNER JOIN user u ON u.UserId = uc.UserID
		WHERE u.Email = ? AND p.ProjectId = ?";
		$query->prepare($sql);
		$query->bind_param("si", $em, $pid);
		$em = $email;
		$pid = $projectid;
		$results = dynamicBindResults($query);
		if (empty($results)) {
			return 'Not a member of project';
		} else {
			return 1;
		}
		
	}

	function getWatchedProjectsByUserEmail($email) {
		
	}
	
	function getWatchedProjectsByUserId($userid) {		
		
	}
	
	function getProjectNameById($id) {
		
		global $connection;
		$emailExists = 0;
		$userinfo = array();
		$results = '';
		$query = $connection ->stmt_init();	
		$sql_getProjects = "SELECT p.ProjectName FROM Project p WHERE p.ProjectId = ?";	
		$query->prepare($sql_getProjects);
		$query -> bind_param("i", $pid);
		$pid = $id;		
		$results = dynamicBindResults($query);	
				
		if (empty($results)) { 	
			return '';
		}
		
		$userinfo = $results;		
		return $userinfo;
			
		
	}
	
	function getProjectMembers($id) {
				
		global $connection;
		$emailExists = 0;
		$userinfo = array();
		$results = '';
		$query = $connection ->stmt_init();	
		$sql_getProjects = "SELECT u.UserId, u.FirstName, u.LastName, u.Email 
							FROM project p
							INNER JOIN component c ON c.ProjectId = p.ProjectId
							INNER JOIN usercomponent uc ON uc.ComponentID = c.ComponentId
							INNER JOIN user u ON u.UserId = uc.UserID
							WHERE p.ProjectId = ?";	
		$query->prepare($sql_getProjects);
		$query -> bind_param("i", $pid);
		$pid = $id;		
		$results = dynamicBindResults($query);	
				
		if (empty($results)) { 	
			return '';
		}
		
		$userinfo = $results;		
		return $userinfo;	
		
	}
	
	
	
	
?>