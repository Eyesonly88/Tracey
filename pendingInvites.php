<?php // Add php scripts here

include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sql_userfunctions.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sql_projectfunctions.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sql_notificationfn.php');
confirmLogin();
$email = $_SESSION['email'];
$pendingResults = getPendingInvInfoBySenderId(getUserInfo($email, "UserId"));
?>

<!DOCTYPE html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Create Component</title>
	<link rel="stylesheet" type="text/css" href="css/customStyle.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.15.custom.css" />
	<script type="text/javascript" src="libraries/dashboard/lib/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="libraries/dashboard/lib/jquery-ui-1.8.2.custom.min.js"></script>
	<script src="js/jquery-ui-1.8.15.custom.min.js"></script>
	<script src="js/jquery.ui.core.js"></script>
	<script src="js/jquery.ui.widget.js"></script>
</head>
<body>
	<form>
		<input type="hidden" name="projectLeaderEmail" id="projectLeader-email" value="<?php echo $_SESSION['email'];?>" />
		<div class="box">
			<fieldset class="tabular">
				<legend>
					A List Showing Pending Project Invites
				</legend>
				<div id="attributes">
					<div id="user-col">
						<h3>User E-mail</h3><br>
						<?php
						if(!empty($pendingResults)) {
							foreach($pendingResults as $result) {
								$userId = $result['ReceiverId'];
								
								echo "<h3>" . getUserInfoById($userId, "Email") . "</h3><br>";
							}
						}
						?>
					</div>
					
					<div id="project-col">
						<h3>Project Name</h3><br>
						<?php
						if(!empty($pendingResults)) {
							foreach($pendingResults as $result) {
								$projectId = $result['TypeEntityId'];
								$projectName = getProjectNameById($projectId);
								echo "<h3>" . $projectName[0]['ProjectName'] . "</h3><br>";
							}
						}
						?>
					</div>
					
					<div id="status-col">
						<h3>Status</h3><br>
						<?php
						if(!empty($pendingResults)) {
							foreach($pendingResults as $result) {
								echo "<h3>Pending ...</h3><br>";
							}
						}
						?>
					</div>
					<div style="clear: both"></div>
				</div>
			</fieldset>
			</div>
			<div id="statusinfo" type="hidden" style="text-align: center;font-size:3em;color: white"></div>
			</form>
			</body>
