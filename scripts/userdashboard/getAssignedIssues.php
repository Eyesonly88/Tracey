<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
 /**
 * Returns a JSON string containing the issueId's assigned to a user.
 * The script expects a GET request from the caller with an email parameter set to be the user's email.
 * @TESTED: OK
 */
	if(isset($_GET['email'])){
		$emailadd = $_GET['email'];
		$results = getAssignedIssuesByEmail($emailadd);
		$jsonResult = json_encode($results);
		echo $jsonResult;
	}

?>