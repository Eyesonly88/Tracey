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

function setNotifStatus(){
	
}

function sendNotifByProject($senderEmail, $receiverEmail, $ProjectId){
	global $connection;
	
	$result = getUserByEmail($senderEmail);
	$senderID = $result['UserId'];
	$result = getUserByEmail($receiverEmail);
	$receiverID = $result['UserId'];
	$status = 1; // 1 means new. the latest db backup has the full information about notifications
	$query = $connection->stmt_init();
	$sql_stmnt = "INSERT INTO `notification` (`Id`, `SenderId`, `ReceiverId`, `TypeId`, `TypeEntityId`, `StatusId`) VALUES (NULL, ?, ?, ?, ?, ?);";
	$query->prepare($sql_stmnt);
	$query->bind_param("iiiii", $userID);	
	$results = dynamicBindResults($query);
	/*
	 * Not finished yet
	 */
	
}

?>