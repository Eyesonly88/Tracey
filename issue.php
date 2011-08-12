<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
$issueid = '';
$issuearray = '';
$issueinfo = '';
$issuestatusarray = '';
if (isset($_GET['id'])){
	$issueid = $_GET['id'];	
	
	
	$issuearray = getIssue($issueid);
	$issueinfo = $issuearray[0];
	
	$reporterEmail = getUserInfoById($issueinfo['ReporterId'], "Email");
	$assigneeEmail = getUserInfoById($issueinfo['AssigneeId'], "Email");
	
	/* Stores array of possible issue statuses */
	$issuestatusarray = getIssueStatuses();
	
}



confirmLogin();
?>


<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Issue: <?php echo $issueid; ?> </title>

		<link rel="stylesheet" type="text/css" href="css/customStyle.css" />
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-ui-1.8.2.custom.min.js"></script>
		<script src="js/jquery.hoverIntent.js"></script>
		<script src="js/loginpanel.js"></script>
	
	</head>
	<script type="text/javascript">

			//alert("BLA!");
			$('#confirm_btn').click(function(){
				alert('blakbldsagflsdfg');
			
			});
			
			//alert("BLA!");
		</script>
	<body class="custom">
		
		<!-- Body here -->
		<div id="issuewrap">
			<h3>Issue: <?php echo $issueid; ?> </h3>
			<div id="issue-info-container">
				<h3>Issue Information</h3>
				<span >Edit</span>
				<div id="issue-info">
					<label>Reporter: <?php echo $reporterEmail; ?> </label>
					<label>Assignee: <?php echo $assigneeEmail; ?></label>
					<label>Issue Type: <?php echo $issueinfo['IssueType']; ?></label>
					<label>Priority: <?php echo $issueinfo['Priority']; ?></label>
					<label>Issue Status: <?php echo $issueinfo['IssueStatus']; ?></label>
					<label>Creation Date:<?php echo $issueinfo['CreationDate']; ?></label>
					<label>Resolved Date:</label>
					<label>Last Modification Date:</label>
				</div>
			</div>
			
			<div id="issue-desc-container">
				<h3>Issue Description</h3>
				<span >Edit</span>
				<div id="issue-desc">
					<?php 
					// get issue description
					?>
				</div>
			</div>
			
			<div id="issue-attach-container">
				<h3>Attached Files</h3>
				<span >Edit</span>
				<div id="issue-attach">
					<form action="attach.php" method="post" enctype="multipart/form-data">
					<p>Allowed file types are: jpg/gif/png, doc/docx, ppt/pptx, xls/xlsx, pdf, txt.<br /><br />
					<input type="file" name="attachments[]" /><br />
					<input type="file" name="attachments[]" /><br />
					<input type="file" name="attachments[]" /><br />
					<input type="file" name="attachments[]" /><br />
					<input type="file" name="attachments[]" />
					<input type="submit" value="Send" /> 
					</p>
					</form>
				</div>
			</div>
			
			<div id="issue-comment-container">
				<div id="issue-create-comment">
					<textarea placeholder="Insert your comment here ...">

					</textarea>
				</div>
				<span>Submit Comment</span>
			</div>
			
			<button id="confirm_btn">Save</button>
		</div>

	</body>
</html>
