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
		<div id="projectwrap">
			<h3>Create New Project</h3>
			<div id="createproject-info-container">
				
				<!-- <span >Edit</span> -->
				<div id="project-info">
					<label><p>Project Name:</p>
						<input type="text" name="projectname" id="createproject-name" value=""/>
					</label>
					
					<label><p>Project Type:</p>
						<input type="text" name="projecttype" id="createproject-type" value=""/>
					</label>
					<label><p>Project Due Date:</p>
						<input type="text" name="projectduedate" id="createproject-duedate" value=""/>
					</label>
					<label>
						<input type="hidden" name="projectLeaderEmail" id="projectLeader-email" value="<?php echo $_SESSION['email']; ?>" />
						<input type="button"  name="submit" value="Create" id="crtproject-button" />
						<p id="confirm-inv-msg"></p>
					</label>
				</div>
			</div>

		</div>

	</body>
</html>