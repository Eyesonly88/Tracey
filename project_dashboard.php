<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
confirmLogin();

$projectid = -1;

if (isset($_GET['id'])){	
	$projectid = $_GET['id'];
} else {
	 return -1; 
}


?>


<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Project Dashboard</title>

		<link rel="stylesheet" type="text/css" href="css/customStyle.css" />
		<link rel="stylesheet" type="text/css" href="css/dashboardui.css" />
		<link rel="stylesheet" type="text/css" href="libraries/dashboard/themes/default/jquery-ui-1.8.2.custom.css" />
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-ui-1.8.2.custom.min.js"></script>
		<script type="text/javascript" src="libraries/dashboard/jquery.dashboard.js"></script>
		<script type="text/javascript" src="libraries/dashboard/lib/themeroller.js"></script>
		<script src="js/jquery.hoverIntent.js"></script>
		<script src="js/define_projectdashboard.js"></script>

		
	</head>
	
<body>
	
	<input type='hidden' id="pid" value="<?php echo $projectid; ?>" /> 
	<input type='hidden' id="user" value="<?php echo $_SESSION['email']; ?>" />
	
	<div id="testcontent">SUP!!!. You are now on the project dashboard for project: <?php echo $projectid; ?></div>.
	
	
</body>