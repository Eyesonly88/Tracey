<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');

$issueid = '';
if (isset($_GET['id'])){
	$issueid = $_GET['id'];	
}

confirmLogin();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Issue Dashboard</title>

		<link rel="stylesheet" type="text/css" href="css/customStyle.css" />
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-ui-1.8.2.custom.min.js"></script>
		<script src="js/jquery.hoverIntent.js"></script>
		<script src="js/loginpanel.js"></script>

	</head>

	<body class="custom">
		
		<!-- Body here -->
		<div id="issuewrap">
			<h3>Issue: <?php echo $issueid; ?> </h3>
			<div id="issue-info-container">
				<h3>Issue Information</h3>
				<span >Edit</span>
				<div id="issue-info">
					<label>Reporter:</label>
					<label>Assignee:</label>
					<label>Issue Type:</label>
					<label>Priority:</label>
					<label>Issue Status:</label>
					<label>Creation Date:</label>
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
		</div>

	</body>
</html>
