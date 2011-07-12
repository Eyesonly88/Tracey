<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_connect.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sanitize.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/formfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_other.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_checks.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_prepared.php');

/*
 * A function that returns the nickname of the Sender(Creator) of the notification.
 * @return: nothing if there are no notifications
 * 			the Sender name of the notificaion.
 * 			-1 if error happened during the prepared statement.
 * @param:	$en_id:	The Entity Id of the notification (ProjectId).
 * @TESTED:OK
 */

function getSenderName($s_id){
	global $connection;
	
	$query = $connection->stmt_init();
	// call the project table
	$sql_stmnt = "SELECT Nickname FROM user WHERE UserId = ?";
	if($query->prepare($sql_stmnt)){
		$query->bind_param("i", $s_id);	
		$results = dynamicBindResults($query);
		if (empty($results)) { 	
			return "";
		}
		else {
			// returns the Sender's nickname who created the notification.
			return $results[0]['Nickname'];
		}
	} else {
		// error happened while fetching the count of notifications
		return -1;
	}
}

/*
 * A function that returns the name of the entity of the notification such as (Issue Name) related to the notification.
 * @return: nothing if there are no notifications
 * 			the Project name of the notificaion type.
 * 			-1 if error happened during the prepared statement.
 * @param:	$en_id:	The Entity Id of the notification (IssueId).
 */

function getEntityNameByIssueId($en_id){
	global $connection;

	$query = $connection->stmt_init();
	$sql_stmnt = "SELECT Name FROM issue WHERE IssueId = ?";
	
	if($query->prepare($sql_stmnt)){
		$query->bind_param("i", $en_id);	
		$results = dynamicBindResults($query);
		if (empty($results)) { 	
			return "";
		}
		else {
			// returns the name of the Issue.
			return $results[0]['Name'];
		}
	} else {
		// error happened while fetching the count of notifications
		return -1;
	}
	
}

/*
 * A function that returns the name of the entity of the notification such as (Project Title) related to the notification.
 * @return: nothing if there are no notifications
 * 			the Project name of the notificaion type.
 * 			-1 if error happened during the prepared statement.
 * @param:	$p_id:	The Entity Id of the notification (ProjectId).
 * @TESTED:OK
 */

function getEntityNameByProjectId($p_id){
	global $connection;
	
	$query = $connection->stmt_init();

	$sql_stmnt = "SELECT ProjectName FROM project WHERE ProjectId = ?";
	if($query->prepare($sql_stmnt)){
		$query->bind_param("i", $p_id);	
		$results = dynamicBindResults($query);
		if (empty($results)) { 	
			return "";
		}
		else {
			// returns the name of the notication type (Name of Project).
			return $results[0]['ProjectName'];
		}
	} else {
		// error happened while fetching the count of notifications
		return -1;
	}

}
/*
 * A function that returns the name of the notification type such as ProjectInvite or IssueAssigned.
 * @return: nothing if there are no notifications
 * 			the name of the notificaion type.
 * 			-1 if error happened during the prepared statement.
 * @param:	$n_id:	The Id of the notification.
 * @TESTED:OK
 */
function getNotifNameByID($n_id){
	global $connection;
	
	$query = $connection->stmt_init();
	$sql_stmnt = "SELECT Name FROM notificationtype WHERE Id = ?";
	
	if($query->prepare($sql_stmnt)){
		$query->bind_param("i", $n_id);	
		$results = dynamicBindResults($query);
		if (empty($results)) { 	
			return "";
		}
		else {
			// returns the name of the notication type.
			return $results[0]['Name'];
		}
	} else {
		// error happened while fetching the count of notifications
		return -1;
	}
}


/*
 * A function that returns the total number of notifications given to a user (Receiver).
 * @return: the count of notifications sent to a user (ReceiverId), using the e-mail of the logged in user.
 * 			0 if no notifications are found related to the e-mail of the user.
 * 			-1 if error happened during the prepared statement, otherwise returns the number of notifications.
 * @param:	$email:	The e-mail address of the receiver.
 * @TESTED:OK
 */
function getNotifCountByEmail($email){
	global $connection;
	$result = getUserByEmail($email);
	$query = $connection->stmt_init();
	$userID = $result['UserId'];
	
	// count the sum of new notification ids related to the userID in Receiver Column in notification table
	$sql_stmnt = "SELECT COUNT(ReceiverId) FROM notification WHERE ReceiverId=? AND StatusId = 1";
	if($query->prepare($sql_stmnt)){
		$query->bind_param("i", $userID);	
		$results = dynamicBindResults($query);
		
		// if no ids were found then no notifications are sent to user and hence display 0
		// otherwise display the number of notifications related to the receiver.
		if (empty($results)) { 	
			return 0;
		}
		else {
			return $results[0]['COUNT(ReceiverId)'];
		}
	} else {
		// error happened while fetching the count of notifications
		return -1;
	}
	
}

/**
 * A function that returns the result set of all notifications related to the recevier.
 * @return	""(empty) if nothing is returned, -1 if error happened during the prepared statement, the result set otherwise.
 * @param:	$email : The e-mail address of the receiver
 * @TESTED:OK
 */
function getAllNotifDetails($email){
	global $connection;
	
	$result = getUserByEmail($email);
	$userID = $result['UserId'];
	
	$query = $connection->stmt_init();
	$sql_stmnt = "SELECT * FROM notification WHERE ReceiverId = ?";
	
	if($query->prepare($sql_stmnt)){
		$query->bind_param("i", $userID);	
		$results = dynamicBindResults($query);
		if (empty($results)) { 	
			return "";
		}
		else {
			// returns all the results (notifications) with all of their details (columns)
			return $results;
		}
	} else {
		// error happened while fetching the count of notifications
		return -1;
	}
	
}

/**
 * A function that updates the status of a notification.
 * @return 	true if successful, false otherwise.
 * @param:	$stauts: An integer number representing the new StatusId of the notification.
 * 			$notif_id: A unique integer number representing the notification id of the notification we are trying to change.
 * @TESTED:OK
 */
function setNotifStatus($status, $notif_id){
	global $connection;
	
	$query = $connection->stmt_init();
	$sql_stmnt = "UPDATE notification SET StatusId = ? WHERE Id = ?";
	
	if($query->prepare($sql_stmnt)){
		$query->bind_param("ii", $status,$notif_id);	
		$query->execute();
	}else {
		// update operation failed.
		return false;
	}
	
	$sql_checkStatus = "SELECT StatusId FROM notification WHERE Id = ?";
	if ($query->prepare($sql_checkStatus)) {		
		$query->bind_param("i", $notif_id);	
		$result = dynamicBindResults($query);
		if(!empty($result)){
			if($result[0]['StatusId'] == $status){
				// The update operation was successful
				return true;
			}else{
				// The update operation was not successful
				return false;
			}
		}else{
			// getting column information for that record failed.
			return false;
		}
	}
	
}
/**
 * A function to send notification from Sender to Receiver. The nofitication type is a Project Invitation.
 * @return:	true if successful, false otherwise.
 * @param: 	$senderEmail = The e-mail of user issuing the project invitation to the other user (Receiver).
 * 			$receiverEmail = The e-mail of user receiving the invitation from project manager.
 * 			$projectId = The id of the project that the sender is inviting the receiver to.
 */
function sendNotifByProject($senderEmail, $receiverEmail, $projectId){
	global $connection;
	
	$result = getUserByEmail($senderEmail);
	$senderID = $result['UserId'];
	$result = getUserByEmail($receiverEmail);
	$receiverID = $result['UserId'];
	$status = 1; // 1 means new. 2 means accepted. 3 means rejected.
	$type = 1; // 1 means project invite, 2 means issue assigned.
	$query = $connection->stmt_init();
	$sql_stmnt = "INSERT INTO `notification` (`Id`, `SenderId`, `ReceiverId`, `TypeId`, `TypeEntityId`, `StatusId`) VALUES (NULL, ?, ?, ?, ?, ?);";
	if($query->prepare($sql_stmnt)){
		$query->bind_param("iiiii", $senderID, $receiverID, $type, $projectId, $status);	
		$query->execute();
	}else{
		// Insertion Statement was not executed
		return false;
	}
	// $mysqli->insert_id 
	// Returns the auto incremented ID of the last query
	
	$notif_id = $connection->insert_id;
	$sql_checkReceiverId = "SELECT ReceiverId FROM notification WHERE Id = ?";
	if ($query->prepare($sql_checkReceiverId)) {		
		$query->bind_param("i", $notif_id);	
		$result = dynamicBindResults($query);
		if(!empty($result)){
			if($result[0]['ReceiverId'] == $receiverID){
				// The insertion operation was successful
				return true;
			}else{
				//Receiver Ids don't match
				return false;
			}
		}else{
			// getting column information for that record failed.
			return false;
		}
	}

	
}
/**
 * A function to send notification from Sender to Receiver. The nofitication type is an Issue Assigned.
 * @return:	true if successful, false otherwise.
 * @param: 	$senderEmail = The e-mail of user creating the issue assigned to the other user (Receiver).
 * 			$receiverEmail = The e-mail of user receiving the assigned issue from project manager.
 * 			$issueId = The id of the issue that the sender has assigned to the receiver.
 */
function sendNotifByIssue($senderEmail, $receiverEmail, $issueId){
	global $connection;
	
	$result = getUserByEmail($senderEmail);
	$senderID = $result['UserId'];
	$result = getUserByEmail($receiverEmail);
	$receiverID = $result['UserId'];
	$status = 1; // 1 means new. 2 means accepted. 3 means rejected.
	$type = 2; // 1 means project invite, 2 means issue assigned.
	$query = $connection->stmt_init();
	$sql_stmnt = "INSERT INTO `notification` (`Id`, `SenderId`, `ReceiverId`, `TypeId`, `TypeEntityId`, `StatusId`) VALUES (NULL, ?, ?, ?, ?, ?);";
	if($query->prepare($sql_stmnt)){
		$query->bind_param("iiiii", $senderID, $receiverID, $type, $issueId, $status);	
		$query->execute();
	}else{
		// Insertion Statement was not executed
		return false;
	}
	// $mysqli->insert_id 
	// Returns the auto incremented ID of the last query
	
	$notif_id = $connection->insert_id;
	$sql_checkReceiverId = "SELECT ReceiverId FROM notification WHERE Id = ?";
	if ($query->prepare($sql_checkReceiverId)) {		
		$query->bind_param("i", $notif_id);	
		$result = dynamicBindResults($query);
		if(!empty($result)){
			if($result[0]['ReceiverId'] == $receiverID){
				// The insertion operation was successful
				return true;
			}else{
				//Receiver Ids don't match
				return false;
			}
		}else{
			// getting column information for that record failed.
			return false;
		}
	}
	
	
}



?>