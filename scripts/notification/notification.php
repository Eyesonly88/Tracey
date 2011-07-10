<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sanitize.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sql_notificationfn.php');

$callbackMsg = 'default';

if (isset($_POST['AcceptId'])){
	// accept the notification

	$callbackMsg = 'ACCEPTEDDD';
	$StatusId = $_POST['AcceptId'];
	$NotifId = $_POST['NotificationId'];
	/*
	if(setNotifStatus($StatusId, $NotifId)){
		// changing status was succesful
		
	}else{
		// chaning status failed
	}
	*/
	
	
} else if (isset($_POST['RejectId'])){
	// reject notification
	
	$StatusId = $_POST['RejectId'];
	$NotifId = $_POST['NotificationId'];
	
	if(setNotifStatus($StatusId, $NotifId)){
		// changing status was succesful
	}else{
		// chaning status failed
	}
}

echo $callbackMsg;
?>