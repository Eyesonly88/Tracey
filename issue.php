<?php
/* The interface for creating or modifying an issue.
 * 
 * 
 * @todo: 	-Get list of components that should be selectable through a drop down menu when creating / modifying issue.
 * 			-Get list of users that belong to the above component/project so they can be selectable through a drop down menu as well
 * 			-Make a drop down menu out of the available statuses that can be chosen.
 * 			-Same as above, but for priority and issue type as well.
 * 
 * */

include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
$issueid = '';
$issuearray = '';
$issueinfo = '';
$issuestatusarray = '';
$projectarray = '';
$projectinfo = '';

$component = '';
/* 1 = create new issue */
$action = 0;

/* 0 = view only, 1 = can edit/save changes */
$permission = 0;
$issuestatusarray = getIssueStatuses();
$issuepriorityarray = getIssuePriorities();
$issuetypearray = getIssueTypes();
$reporterid = '';
$assigneeid = '';
if (isset($_GET['id'])){
	$issueid = $_GET['id'];	
	
	
	$issuearray = getIssue($issueid);
	$issueinfo = $issuearray[0];
	
	$reporterEmail = getUserInfoById($issueinfo['ReporterId'], "Email");
	$assigneeEmail = getUserInfoById($issueinfo['AssigneeId'], "Email");
	$projectarray = getProjectByIssueId($issueid);
	$projectinfo = $projectarray[0];
	/* Stores array of possible issue statuses */
	$reporterId = $issueinfo['ReporterId'];
	$assigneeId = $issueinfo['AssigneeId'];
	
	
	$componentId = $issueinfo['ComponentId'];
	
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
					var issuestatus = $('#input_issuestatus').val();
					var title = $('#input_title').val();
					var description = $('#input_description').val();
					var component = $('#input_component').val();
					if (action == 0) {
						
						//@todo: AJAX call that sends the issue information to modify the issue
						
						$.ajax({
					  	   cache: "false",
						   type: "POST",
						   url: "/scripts/issue/modifyIssue.php",
						   data: "id="+issueid+"&reporter="+reporter+"&assignee="+assignee+"&type="+issuetype+"&status="+issuestatus+"&component="+component+"&priority="+priority+"&name="+title+"&description="+description,
						   success: function(msg){
						  
						  	if (msg == "1"){
						     	$("#issuewrap").hide("slow");
						     	$("#statusinfo").append("<h2> Changes Saved. </h2><BR />");
						     	$("#statusinfo").show("slow");
							} else {
								$("#issuewrap").hide("slow");
						     	$("#statusinfo").append("<h2> Something went horribly wrong: " + msg + "</h2><BR />");
						     	$("#statusinfo").show("slow");
							}
						    // setupFlexTable2();
						          
						   }
					   
					 	});
					
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
			<label>Issue Title: </label><input id="input_title"><?php echo $issueinfo['name']; ?></input> <BR />
			<div id="issue-info-container">
				<h3>Issue Information</h3>
				<span >Edit</span>
				<div id="issue-info">
					<label>Reporter:</label> 
					<select name="reporterid" id="input_reporter">
									<?php 
										$resultSet = getProjectMembers($projectinfo['ProjectId']);
										foreach ($resultSet as $result){
											if ($result['UserId'] == $reporterId){
												echo "<option value=\"" . $result['UserId'] ."\" selected>" . $result['FirstName'] . ' ' . $result['LastName'] . "</option>";
											} else {
												echo "<option value=\"" . $result['UserId'] ."\">" . $result['FirstName'] . ' ' . $result['LastName'] . "</option>";
											}
										}
									?>
					</select> <BR/>
					
					<label>Assignee: </label> 
					<select name="assigneeid" id="input_assignee">
									<?php 
										$resultSet = getProjectMembers($projectinfo['ProjectId']);
										foreach ($resultSet as $result){
											if ($result['UserId'] == $assigneeId){
												echo "<option value=\"" . $result['UserId'] ."\" selected>" . $result['FirstName'] . ' ' . $result['LastName'] . "</option>";
											} else {
												echo "<option value=\"" . $result['UserId'] ."\">" . $result['FirstName'] . ' ' . $result['LastName'] . "</option>";
											}
										}
									?>
					</select> <BR/>
					<label>Issue Type:</label>
					<select name="reporterid" id="input_issuetype">
									<?php 
										$resultSet = $issuetypearray;
										foreach ($resultSet as $result){
											if ($result['Id'] == $issueinfo['IssueType']){
												echo "<option value=\"" . $result['Id'] ."\" selected>" . $result['Name'] . "</option>"; 
											} else {
												echo "<option value=\"" . $result['Id'] ."\">" . $result['Name'] . "</option>"; 
											}
										}
									?>
					</select> <BR/>
					<label>Component:</label>
					<select name="reporterid" id="input_component">
									<?php 
										$resultSet = getComponentsByProjectId($projectinfo['ProjectId']);
										foreach ($resultSet as $result){
											if ($result['ComponentId'] == $issueinfo['ComponentId']) {
												echo "<option value=\"" . $result['ComponentId'] ."\" selected>" . $result['Name'] . "</option>"; 
											} else {
												echo "<option value=\"" . $result['ComponentsId'] ."\">" . $result['Name'] . "</option>"; 
											}
										}
									?>
					</select> <BR/>
					<label>Priority:</label>
					<select name="reporterid" id="input_priority">
									<?php 
										$resultSet = $issuepriorityarray;
										foreach ($resultSet as $result){
											if ($result['Id'] == $issueinfo['Priority']){
												echo "<option value=\"" . $result['Id'] ."\" selected>" . $result['Name'] . "</option>"; 
											} else {
												echo "<option value=\"" . $result['Id'] ."\">" . $result['Name'] . "</option>"; 
											}
										}
									?>
					</select> <BR/>
					<label>Issue Status: </label> 
					<select name="reporterid" id="input_issuestatus">
									<?php 
										$resultSet = $issuestatusarray;
										foreach ($resultSet as $result){
											if ($result['Id'] == $issueinfo['IssueStatus']) {
												echo "<option value=\"" . $result['Id'] ."\" selected>" . $result['Name'] . "</option>"; 
											} else {
												echo "<option value=\"" . $result['Id'] ."\">" . $result['Name'] . "</option>"; 
											}
										}
									?>
					</select> <BR/>
					<label>Creation Date: <?php echo $issueinfo['CreationDate']; ?></label><BR />
					<label>Resolved Date:</label> <BR />
					<label>Last Modification Date:</label> <BR />
				</div>
			</div>
			
			<div id="issue-desc-container">
				<h3>Issue Description</h3>
				<span >Edit</span>
				<div id="issue-desc">
					
					<textarea rows="5" cols="20" wrap="virtual" id="input_description" style="width:599px; height:149px;" maxlength="2000"><?php echo $issueinfo['Description']; ?></textarea>
					
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
			<BR />
			<button id="confirm_btn">Save</button>
		</div>
		<div id="statusinfo" type="hidden"></div>
	</body>
</html>
