<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
$issueid = '';
$issuearray = '';
$issueinfo = '';
$issuestatusarray = '';

/* 1 = create new issue */
$action = 0;

/* 0 = view only, 1 = can edit/save changes */
$permission = 0;
$issuestatusarray = getIssueStatuses();
if (isset($_GET['id'])){
	$issueid = $_GET['id'];	
	
	
	$issuearray = getIssue($issueid);
	$issueinfo = $issuearray[0];
	
	$reporterEmail = getUserInfoById($issueinfo['ReporterId'], "Email");
	$assigneeEmail = getUserInfoById($issueinfo['AssigneeId'], "Email");
	
	/* Stores array of possible issue statuses */
	
	
}

if (isset($_GET['action'])){
	if ($_GET['action'] = 'create'){
		
		$action = 1;
	
	}
	
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

	<script type="text/javascript">
			
			$(document).ready(function() {
				
				var action = $('#action').val();
				//alert(action);
				$('#confirm_btn').click(function(){
					//alert('blakbldsagflsdfg');
					var issueid = $('#issueid').val();
					var reporter = $('#input_reporter').val();
					var assignee = $('#input_assignee').val();
					var issuetype = $('#input_issuetype').val();
					var priority = $('#input_priority').val();
					if (action == 0) {
						
						//@todo: AJAX call that sends the issue information to modify the issue
					
					} else if (action == 1) { 
					
						//@todo: AJAX call that sends the issue information to CREATE a new issue
					}				
				});
			});

		</script>
</head>
	<body class="custom">
		
		<input type='hidden' id="issueid" value="<?php echo $issueid; ?>" /> 
		<input type='hidden' id="permission" value="<?php echo $permission; ?>" /> 
		<input type='hidden' id="action" value="<?php echo $action; ?>" /> 
		
		<!-- Body here -->
		<div id="issuewrap">
			<h3>Issue: <?php echo $issueid; ?> </h3>
			<div id="issue-info-container">
				<h3>Issue Information</h3>
				<span >Edit</span>
				<div id="issue-info">
					<label>Reporter:</label> <input id="input_reporter" value="<?php echo $reporterEmail; ?>"/> <BR/>
					<label>Assignee: </label> <input id="input_assignee"  value="<?php echo $assigneeEmail; ?>" /><BR />
					<label>Issue Type:</label><input id="input_issuetype"  value=" <?php echo $issueinfo['IssueType']; ?>"/> <BR />
					<label>Priority:</label><input id="input_priority"  value="<?php echo $issueinfo['Priority']; ?>"/> <BR />
					<label>Issue Status: </label><input id="input_issuestatus"  value="<?php echo $issueinfo['IssueStatus']; ?>"/> <BR />
					<label>Creation Date: <?php echo $issueinfo['CreationDate']; ?></label><BR />
					<label>Resolved Date:</label> <BR />
					<label>Last Modification Date:</label> <BR />
				</div>
			</div>
			
			<div id="issue-desc-container">
				<h3>Issue Description</h3>
				<span >Edit</span>
				<div id="issue-desc">
					
					<textarea rows="5" cols="20" wrap="virtual" id="issuedescription" style="width:599px; height:149px;" maxlength="2000"><?php echo $issueinfo['Description']; ?></textarea>
					
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
