<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sanitize.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sql_notificationfn.php');

$callbackMsg = '';

if (isset($_POST['receiveremail'])){

	$receiverEmail = sanitize($_POST['receiveremail']);
	$projectId = sanitize($_POST['projectid-selector']);
	$senderEmail = sanitize($_POST['senderemail']);
	/*
	if(sendNotifByProject($senderEmail, $receiverEmail, $projectId)){
		// sending notification was succesful
		$callbackMsg = 1;
		
	}else{
		// sending notification failed
		$callbackMsg = -1;
	}
	*/
	$callbackMsg = $receiverEmail . $projectId . $senderEmail ;
	
	
} /*else if (isset($_POST['RejectId'])){
	// reject notification
	
	$StatusId = $_POST['RejectId'];
	$NotifId = $_POST['NotificationId'];
	
	if(setNotifStatus($StatusId, $NotifId)){
		// changing status was succesful
		$callbackMsg = 1;
	}else{
		// chaning status failed
		$callbackMsg = -1;
	}
}
*/
echo $callbackMsg;

?>