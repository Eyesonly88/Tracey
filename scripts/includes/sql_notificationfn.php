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
 * Returns the count of notifications sent to a user (ReceiverId), using the e-mail of the logged in user.
 * Returns 0 if no notifications are found related to the e-mail of the user, otherwise returns the number of notifications.
 * @TESTED:OK
 */
function getNotifCountByEmail($email){
	global $connection;
	$result = getUserByEmail($email);
	$query = $connection->stmt_init();
	$userID = $result['UserId'];
	
	// count the sum of notification ids related to the userID in Receiver Column in notification table
	$sql_stmnt = "SELECT COUNT(ReceiverId) FROM notification WHERE ReceiverId=?";
	$query->prepare($sql_stmnt);
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
	
}

function setNotifStatus($email, $status){
	
	
	
}
/**
 * A function to send notification from Sender to Receiver. The nofitication type is a Project Invitation.
 * Returns BOOLEAN, true if successful, false otherwise.
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
 * Returns BOOLEAN, true if successful, false otherwise.
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