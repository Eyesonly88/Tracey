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

	/* Adds a component to the specified project @TODO: component table needs a few more fields to be added e.g. 'ComponentName' */
	function addComponentByProjectId($projectid, $hours, $due){
		global $connection;
		$compid = '';
		$query = $connection->stmt_init(); 
		$sql_addComponent = "INSERT INTO Component(name, ProjectId, RequiredHours, DueDate) VALUES('Default', ?, ?, ?)";
		$sql_getLastInsertId = "SELECT LAST_INSERT_ID() AS ID";	
		if ($query->prepare($sql_addComponent)) {		
			$query->bind_param("ids", $pid, $requiredhours, $duedate);	
			$pid = $projectid;
			$requiredhours = $hours;
			$duedate =  date("Y-m-d", strtotime($due));
			$query->execute();		
			$query->prepare($sql_getLastInsertId);
			$lastinsertarray = dynamicBindResults($query);
			return $lastinsertarray;
		}	
	}
	
	function changeComponentStatus($componentid, $statusid){	
		global $connection;
		$query = $connection->stmt_init();	
	}
	
	function removeComponent($componentidbyid){
		global $connection;
		$query = $connection->stmt_init();	
		$sql_removeComponent = "DELETE FROM component WHERE ComponentId = ?";
		if ($query->prepare($sql_removeComponent)) {
			$query->bind_param("i", $componentidbyid);	
			$query->execute();
			return true;
		}else {
			// update operation failed.
			return false;
		}
	}
	
	function addUserToComponentById($componentid, $userid){
		global $connection;
		$query = $connection->stmt_init();	
		
		$sql_stmnt = "INSERT INTO usercomponent (`UserID`, `ComponentID`) VALUES (?, ?);";
		
		if ($query->prepare($sql_stmnt)) {
			$query->bind_param("ii", $userid, $componentid);
			$query->execute();
			return true;
		} else {
			return false;
		}
	}
	
	function addUserToComponentByEmail($componentid, $useremail){
		global $connection;
		$query = $connection->stmt_init();	
		$result = getUserByEmail($useremail);
		$userId = $result['UserId'];
		$sql_stmnt = "INSERT INTO usercomponent (`UserID`, `ComponentID`) VALUES (?, ?);";
		
		if ($query->prepare($sql_stmnt)) {
			$query->bind_param("ii", $userId, $componentid);
			$query->execute();
			return true;
		} else {
			return false;
		}
	}
	
	function getWatchedComponentsByUserId($userid){	
		global $connection;
		$query = $connection->stmt_init();
		
		$sql_stmnt = "SELECT ComponentId FROM componentwatches WHERE UserId = ?";
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
	
	function getComponentsByProjectId($projectid){
		global $connection;
		$query = $connection->stmt_init();
		
		//$result = getUserByEmail($useremail);
		//$userid = $result['UserId'];
		$sql_stmt = "SELECT * FROM component c INNER JOIN project p ON c.ProjectID = p.ProjectId WHERE p.ProjectId = ?";
		
		$query->prepare($sql_stmt);
		$query->bind_param("i", $id);
		$id = $projectid;
		$result = dynamicBindResults($query);
		if (empty($result)){
			return '';
		} else {
			return $result;
		}
		
	}
	
	function getWatchedComponentsByUserEmail($useremail){
		global $connection;
		$query = $connection->stmt_init();	
		
		$result = getUserByEmail($useremail);
		$userId = $result['UserId'];
		$sql_stmnt = "SELECT ComponentId FROM componentwatches WHERE UserId = ?";
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