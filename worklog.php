<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');

confirmLogin();

$worklogid = '';
$user = '';
$hours = '';
$date = '';
$userid = '';
$desc = '';
if (isset($_GET['id'])){
	
	$worklogid = $_GET['id'];
	$worklogarray = getWorkLogById($worklogid);
	$worklog = $worklogarray[0];
	
	$hours = $worklog['Hours'];
	$date = $worklog['CreationDate'];
	$userid = $worklog['UserId'];
	$user = getUserInfoById($userid, "Nickname");
	if (empty($user)) {
		$user = getUserInfoById($userid, "Email");
	}
	$desc = $worklog['Description'];
	
}



?>

<!DOCTYPE html>

<head>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>View Worklog</title>

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
		<script>
		
	$(document).ready( function() {
		
			
		});	
			
		</script>
	
</head>
<body style="overflow: hidden">
	<form>
		<input type="hidden" name="projectLeaderEmail" id="projectLeader-email" value="<?php echo $_SESSION['email']; ?>" />
		<div class="box">
			<fieldset class="tabular">
				<legend>
					Work Log for Issue: <?php echo $worklog['IssueId']; ?>
				</legend>
				<div id="attributes">
					<p>
						<label for="logby">Logged by</label>
						<input type="text" id="logby" readonly="readonly" style="width: 400px" value="<?php echo $user; ?>"/>
					</p>
					<p>
						<label for="logdate">Created</label>
						<input type="text" id="logdate" readonly="readonly" style="width: 400px" value="<?php echo $date; ?>"/>
					</p>
					<p>
						<label for="loghours">Hours</label>
						<input type="text" id="loghours" readonly="readonly" style="width: 400px"  value="<?php echo $hours; ?>" />
					</p>
					<p>
						<label for="logdesc">Description</label>
						<input type="text" id="logdesc" readonly="readonly" value="<?php echo $desc; ?>" />
					</p>
					
				</div>
			</fieldset>
		</div>
		<div id="statusinfo" type="hidden" style="text-align: center;font-size:3em;color: white"></div>
	</form>
</body>