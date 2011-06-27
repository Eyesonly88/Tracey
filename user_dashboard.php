<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');

// Confirm if user is logged in.
confirmLogin();

?>

<!DOCTYPE html>

<html lang="en">

<head>
  	<title>Tracey - User Dashboard</title>
  	<meta name="description" content=" - Web-based Issue Tracker &amp; Project Management Solution" />
  	<meta name="keywords" content="tracey, issue tracker, software engineering, part 4 project" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />	

	<!-- stylesheets -->
  	<link rel="stylesheet" href="css/userdashboardstyle.css" type="text/css" media="screen" />
  	<link type="text/css" rel="stylesheet" href="css/openid.css" />
  	    <!-- jQuery (1.6.1)- the core -->
	<script src="js/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/openid-jquery.js"></script>
	<script type="text/javascript" src="js/openid-en.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			openid.init('openid_identifier');
			openid.setDemoMode(true); //Stops form submission for client javascript-only test purposes
		});
	</script>
	
  	<!-- PNG FIX for IE6 -->
  	<!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
	<!--[if lte IE 6]>
		<script type="text/javascript" src="js/pngfix/supersleight-min.js"></script>
	<![endif]-->
	 
	<script src="js/userdashboard.js" type="text/javascript"></script>

</head>

<body>
<!-- Panel -->

    <div id="container">
		<div id="content" style="padding-top:100px;">
			<h1>User Dashboard</h1>
			<h5>This is the user dashboard.</h5>
			
			<div id="user_info"><h2>User Info:</h2>
				<h5></h5>
			</div>
			
			<div id="user_project_info">
				<div id="projects_belongsTo">
					<h2>Member of Projects:</h2>
				</div>
				<div id="projects_watches">
					<h2>Watching Projects:</h2>
				</div>
				<div id="projects_creatorOf">
					<h2>Created Projects:</h2>
				</div>		
			</div>
			<div id="recent_actions"><h2>Recent Actions:</h2></div>
			<div id="users_following"></div>
			<div id="logout"><p><a href="scripts/logout.php">Logout!</a></p></div>
			
			
		</div><!-- / content -->		
	</div><!-- / container -->
</body>
</html>
