<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_connect.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sanitize.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_prepared.php');

/*
 * A function that creates a comment linked to an issue for a user.
 * The comment MUST be added to an EXISTING issue, otherwise operation won't work.
 * @param:	$issueId:	The Id of the issue we are trying to add a comment to.
 * 			$userId:	The id of the author of the comment.
 * 			$content:	The content of the comment.
 * @return: true if successful, false otherwise.
 * @TESTED:OK
 */	

function createComment($issueId, $userId, $content){
	global $connection;
	
	$query = $connection->stmt_init();
	$sql_stmnt = "INSERT INTO comment (`CommentId`, `IssueId`, `UserId`, `CommentContent`, `CreationDate`, `ModificationDate`) 
	VALUES (NULL, ?, ?, ?, NOW(), NULL);";
		
	if ($query->prepare($sql_stmnt)) {
		$query->bind_param("iis", $issueId, $userId, $content);
		$query->execute();
		return true;
	} else {
		return false;
	}
}

/*
 * A function that modifies a comment.
 * @param:	$commentId:	The Id of the comment we are trying to modify.
 * 			$content:	The content of the comment.
 * @return: true if successful, false otherwise.
 * @TESTED:OK
 */	

function editComment($commentId, $content){
	global $connection;
	
	$query = $connection->stmt_init();
	$sql_stmnt = "UPDATE comment SET CommentContent = ?, ModificationDate = NOW() WHERE CommentId = ?";
			
	if ($query->prepare($sql_stmnt)) {
		$query->bind_param("si", $content,$commentId);
		$query->execute();
		return true;
	}else {
		// update operation failed.
		return false;
	}
}


?>