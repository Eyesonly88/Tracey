<?php
/* The new improved issue interface for creating or modifying an issue.
 *
 * */

include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sql_issuefunctions.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sql_userfunctions.php');
$issueid = '';
$issuearray = '';
$issueinfo = '';
$issuestatusarray = '';
$projectarray = '';
$projectinfo = '';

$theissueid = '';

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
if(isset($_GET['id'])) {
	$issueid = $_GET['id'];
	$theissueid = $issueid;

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

if(isset($_GET['action'])) {
	if($_GET['action'] = 'create') {
		$action = 1;
	}
}

confirmLogin();
?>

<!DOCTYPE html>
<head>
	<link rel="stylesheet" type="text/css" href="css/customStyle.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.15.custom.css" />
	<script type="text/javascript" src="libraries/dashboard/lib/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="libraries/dashboard/lib/jquery-ui-1.8.2.custom.min.js"></script>
	<script src="js/jquery.hoverIntent.js"></script>
	<script src="js/loginpanel.js"></script>
	<script src="js/jquery-ui-1.8.15.custom.min.js"></script>
	<script src="js/jquery.ui.core.js"></script>
	<script src="js/jquery.ui.widget.js"></script>
	<script src="js/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="/libraries/shadowbox/shadowbox.css" type="text/css">
	<script src="/libraries/shadowbox/shadowbox.js" type="text/javascript"></script>
	<script>
		$(document).ready(function() {

			/* This function lets you change the content shown inside a shadowbox to show the content in 'path' */
			Shadowbox.clearCache();
			Shadowbox.init({
				displayNav : false
			});

			var action = $('#action').val();
			//alert(action);
			$('#confirm_btn').click(function() {
				//alert('blakbldsagflsdfg');
				var issueid = $('#issueid').val();
				var reporter = $('form #issue-reporter').val();
				var assignee = $('form #issue-assignee').val();
				var issuetype = $('form #issue-type').val();
				var priority = $('form #issue-priority').val();
				var issuestatus = $('form #issue-status').val();
				var title = $('form #issue-title').val();
				var description = $('form #issue-description textarea').val();
				var component = $('form #issue-component').val();
				if(assignee == -1) {
					alert("Please Choose an assignee from the list before saving!");
				} else {
					if(action == 0) {

						//AJAX call that sends the issue information to modify the issue

						$.ajax({
							cache : "false",
							type : "POST",
							url : "/scripts/issue/modifyIssue.php",
							data : "id=" + issueid + "&reporter=" + reporter + "&assignee=" + assignee + "&type=" + issuetype + "&status=" + issuestatus + "&component=" + component + "&priority=" + priority + "&name=" + title + "&description=" + description,
							success : function(msg) {

								if(msg == "1") {
									$(".box").hide("slow");
									$("#statusinfo").append("<h2> Changes Saved. </h2><BR />");
									$("#statusinfo").show("slow");
								} else {
									$(".box").hide("slow");
									$("#statusinfo").append("<h2> Something went horribly wrong: " + msg + "</h2><BR />");
									$("#statusinfo").show("slow");
								}
								// setupFlexTable2();

							}
						});

					} else {

						//AJAX call that sends the issue information to CREATE a new issue

						$.ajax({
							cache : "false",
							type : "POST",
							url : "/scripts/issue/createIssue.php",
							data : "reporter=" + reporter + "&assignee=" + assignee + "&type=" + issuetype + "&status=" + issuestatus + "&component=" + component + "&priority=" + priority + "&name=" + title + "&description=" + description,
							success : function(msg) {

								if(msg == "1") {
									$(".box").hide("slow");
									$("#statusinfo").append("<h2> Issue created. Click outside the window to return to the dashboard. </h2><BR />");
									$("#statusinfo").show("slow");
								} else {
									$(".box").hide("slow");
									$("#statusinfo").append("<h2> Something went horribly wrong: " + msg + ". Click outside the window to return to the dashboard.</h2><BR /> ");
									$("#statusinfo").show("slow");
								}
								// setupFlexTable2();

							}
						});
					}
				}

			});
		});

	</script>
</head>
<body style="overflow: hidden">
	<input type='hidden' id="issueid" value="<?php
	if($action == 0) { echo $issueid;
	}
 ?>" />
	<input type='hidden' id="permission" value="<?php
		{
			echo $permission;
		}
 ?>" />
	<input type='hidden' id="action" value="<?php
		{
			echo $action;
		}
 ?>" />
	<form>
		<div class="box">
			<div id="issue-name">
				
					<h3>Issue Title</h3>
					<input type="text" id="issue-title" value="<?php if ($action == 0) { echo $issueinfo['name']; } ?>"/>

			</div>
			<div style="clear:both;"></div>
			<fieldset class="tabular">
				<legend>
					Issue Information
				</legend>
				<div id="attributes">
					<div class="leftcontent">
						<p>
							<label for="issue-status">Status<span class="required"> *</span></label>
							<select id="issue-status" required="required">
								<?php
								$resultSet = getIssueStatuses();
								foreach($resultSet as $result) {
									if($action != 1) {
										$currentStatus = $issueinfo['IssueStatus'];
										if($result['ID'] == $currentStatus) {
											echo "<option value=\"" . $result['ID'] . "\" selected>" . $result['Name'] . "</option>";

										} else {
											echo "<option value=\"" . $result['ID'] . "\" >" . $result['Name'] . "</option>";
										}
									} else {
										if($result['ID'] == 1) {
											echo "<option value=\"" . $result['ID'] . "\" selected>" . $result['Name'] . "</option>";

										} else {
											echo "<option value=\"" . $result['ID'] . "\" >" . $result['Name'] . "</option>";
										}
									}
								}
								?>
							</select>
						</p>
						<p>
							<label for="issue-assignee">Assignee<span class="required"> *</span></label>
							<select id="issue-assignee" required="required">
								<option value="-1">Select Project Member</option>
								<?php
								if($action == 0) {
									$resultSet = getProjectMembers($projectinfo['ProjectId']);
								} else {
									$resultSet = getProjectMembers($_SESSION['projectid']);
								}
								foreach($resultSet as $result) {
									if($result['UserId'] == $assigneeId) {
										$fname = $result['FirstName'];
										$lname = $result['LastName'];
										if(!empty($fname) && !empty($lname)) {
											echo "<option value=\"" . $result['UserId'] . "\" selected>" . $result['FirstName'] . ' ' . $result['LastName'] . "</option>";
										} else {
											echo "<option value=\"" . $result['UserId'] . "\" selected>" . $result['Email'] . "</option>";
										}
									} else {
										$fname = $result['FirstName'];
										$lname = $result['LastName'];
										if(!empty($fname) && !empty($lname)) {
											echo "<option value=\"" . $result['UserId'] . "\" >" . $result['FirstName'] . ' ' . $result['LastName'] . "</option>";
										} else {
											echo "<option value=\"" . $result['UserId'] . "\" >" . $result['Email'] . "</option>";
										}
									}
								}
								?>
							</select>
						</p>
						<p>
							<label for="issue-reporter">Reporter</label>
							<select id="issue-reporter" disabled="disabled">
								<?php
								if($action == 0) {
									$resultSet = getProjectMembers($projectinfo['ProjectId']);
								} else {
									$resultSet = getProjectMembers($_SESSION['projectid']);
								}
								foreach($resultSet as $result) {
									if($result['UserId'] == $reporterId) {
										$fname = $result['FirstName'];
										$lname = $result['LastName'];
										if(!empty($fname) && !empty($lname)) {
											echo "<option value=\"" . $result['UserId'] . "\" selected>" . $result['FirstName'] . ' ' . $result['LastName'] . "</option>";
										} else {
											echo "<option value=\"" . $result['UserId'] . "\" selected>" . $result['Email'] . "</option>";
										}
									} else {
										$fname = $result['FirstName'];
										$lname = $result['LastName'];
										if(!empty($fname) && !empty($lname)) {
											echo "<option value=\"" . $result['UserId'] . "\" >" . $result['FirstName'] . ' ' . $result['LastName'] . "</option>";
										} else {
											echo "<option value=\"" . $result['UserId'] . "\" >" . $result['Email'] . "</option>";
										}
									}
								}
								?>
							</select>
						</p>
						<p>
							<label for="issue-priority">Priority<span class="required"> *</span></label>
							<select id="issue-priority" required="required">
								<?php
								$resultSet = $issuepriorityarray;
								foreach($resultSet as $result) {
									if(($action == 0)) {
										if($result['ID'] == $issueinfo['Priority']) {
											echo "<option value=\"" . $result['ID'] . "\" selected>" . $result['Name'] . "</option>";
										} else {
											echo "<option value=\"" . $result['ID'] . "\">" . $result['Name'] . "</option>";
										}
									} else {
										if($result['ID'] == 2) {
											echo "<option value=\"" . $result['ID'] . "\" selected>" . $result['Name'] . "</option>";
										} else {
											echo "<option value=\"" . $result['ID'] . "\">" . $result['Name'] . "</option>";
										}
									}
								}
								?>
							</select>
						</p>
					</div>
					<div class="rightcontent">
						<p>
							<label for="issue-type">Type</label>
							<select id="issue-type">
								<?php
								$resultSet = $issuetypearray;
								foreach($resultSet as $result) {
									if(($action == 0) && $result['Id'] == $issueinfo['IssueType']) {
										echo "<option value=\"" . $result['ID'] . "\" selected>" . $result['Name'] . "</option>";
									} else {
										echo "<option value=\"" . $result['ID'] . "\">" . $result['Name'] . "</option>";
									}
								}
								?>
							</select>
						</p>
						<p>
							<label for="issue-component">Component</label>
							<select id="issue-component">
								<?php

								if($action == 0) {
									$resultSet = getComponentsByProjectId($projectinfo['ProjectId']);
								} else {
									$resultSet = getComponentsByProjectId($_SESSION['projectid']);
								}
								foreach($resultSet as $result) {
									if(($action == 0) && $result['ComponentId'] == $issueinfo['ComponentId']) {
										echo "<option value=\"" . $result['ComponentId'] . "\" selected>" . $result['Name'] . "</option>";
									} else {
										echo "<option value=\"" . $result['ComponentId'] . "\">" . $result['Name'] . "</option>";
									}
								}
								?>
							</select>
						</p>
						<?php if ($action != 1) {
						?>
						<p>
							<?php
							date_default_timezone_set("Pacific/Auckland");
							//$cdate = date('Y-m-d H:i:s', );
							if($issueinfo['CreationDate'] != NULL) {
								$datetime = strtotime($issueinfo['CreationDate']);
								$creationdate = date("d/m/y g:i A", $datetime);
							} else {
								$creationdate = "";
							}
							?>
							<label for="issue-startdate">Created</label>
							<input type="text" id="issue-startdate" required="required" disabled="disabled" style="color:black" value="<?php
								if($action == 0) { echo $creationdate;
								}
 ?>"/>
						</p>
						<?php }?>
						<?php if ($action != 1) {
						?>
						<p>
							<?php
							date_default_timezone_set("Pacific/Auckland");
							//$cdate = date('Y-m-d H:i:s', );
							if($issueinfo['ResolvedDate'] != NULL) {
								$datetime = strtotime($issueinfo['ResolvedDate']);
								$resolveddate = date("d/m/y g:i A", $datetime);
							} else {
								$resolveddate = "";
							}
							?>
							<label for="issue-resolveddate">Resolved</label>
							<input type="text" id="issue-resolveddate" disabled="disabled" style="color: black" value="<?php
								if($action == 0) { echo $resolveddate;
								}
 ?>" />
						</p>
						<?php }?>

						<?php if ($action != 1) {
						?>
						<p>
							<?php
							date_default_timezone_set("Pacific/Auckland");
							//$cdate = date('Y-m-d H:i:s', );
							if($issueinfo['LastModificationDate'] != NULL) {
								$datetime = strtotime($issueinfo['LastModificationDate']);
								$modificationdate = date("d/m/y g:i A", $datetime);
							} else {
								$modificationdate = "";
							}
							?>
							<label for="issue-modificationdate">Modified</label>
							<input type="text" id="issue-modificationdate" disabled="disabled" style="color: black" value="<?php
								if($action == 0) { echo $modificationdate;
								}
 ?>" />
						</p>
						<?php }?>
					</div>
					<div style="clear:both;"></div>
				</div>
			</fieldset>
			<fieldset class="tabular">
				<legend>
					Issue Description
				</legend>
				<div id="issue-description">
					<textarea accesskey="e" cols="60" rows="10"><?php
					if($action == 0) {echo trim($issueinfo['Description']);
					}
 ?></textarea>
				</div>
			</fieldset>
			<fieldset class="tabular">
				<legend>
					Log Hours
				</legend>
				<div id="log-issue-hours">
					<p>
						Click on the log hours button to add the amount of hours you spent on this issue
					</p>
					<p>
						<a id="loghours" rel="shadowbox;height=240" href="logissuehour.php?id=<?php echo $theissueid;?>">
						<input type="button" value="Log Hours" />
						</a>
					</p>
				</div>
			</fieldset>
			<input type="button" value="Save Issue" id="confirm_btn" style="margin-top:1em;"/>
			</div>
			<div id="statusinfo" type="hidden" style="text-align: center;font-size:3em;color: white"></div>
			</form>
			</body>
