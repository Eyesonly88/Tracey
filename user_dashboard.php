<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_notificationfn.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');

confirmLogin();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>User Dashboard</title>

		<link rel="stylesheet" type="text/css" href="css/customStyle.css" />
		<link rel="stylesheet" type="text/css" href="css/dashboardui.css" />
		<link rel="stylesheet" type="text/css" href="libraries/dashboard/themes/default/jquery-ui-1.8.2.custom.css" />
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-ui-1.8.2.custom.min.js"></script>
		<script type="text/javascript" src="libraries/dashboard/jquery.dashboard.js"></script>
		<script type="text/javascript" src="libraries/dashboard/lib/themeroller.js"></script>
		<link rel="stylesheet" href="/libraries/datatables/media/css/demo_table_jui.css" type="text/css">
<!--<script src="/libraries/flexigrid/js/flexigrid.js" type="text/javascript"></script> -->
<script src="/libraries/dataTables/media/js/jquery.dataTables.js" type="text/javascript"></script>
		<script src="js/jquery.hoverIntent.js"></script>
		<script src="js/loginpanel.js"></script>
		<script src="js/define_userdashboard.js"></script>
		<script src="js/notification.js"></script>
		<script src="js/invite.js"></script>
		<link rel="stylesheet" href="/libraries/shadowbox/shadowbox.css" type="text/css">
		<script src="/libraries/shadowbox/shadowbox.js" type="text/javascript"></script>
		<script>$(document).ready( function() {
				
			
				Shadowbox.init({
			
					displayNav: "false",
					displayCounter: "false"
  				});
  				Shadowbox.clearCache();
				$(".notifications-form").hide();
				
				$("#notifications").hoverIntent( function() {
					$(".notifications-form").fadeIn(200);
				}
				, function() {
					$(".notifications-form").fadeOut(200);
				}
				)
				
				});</script>
	</head>

	<body class="custom">
		<div id="header-area">
			<div id="header">
				<div class="menu-container">
					<!-- Menu items = Home, About, Help -->
					<ul class="menu">
						<li>
							<a href="#">Home</a>
						</li>
						<li>
							<a href="#">About</a>
						</li>
						<li>
							<a href="#">Help</a>
						</li>
						<li>
							 <a href="/scripts/authentication/logout.php" style="color: orange">Logout!</a>
						</li>
					</ul>
				</div>

				<ul id="nav">
					<!-- Load Navigation items ..
					1. Logged in user = Account, Themes, Logout Button.
					2. Visitor = Login, Register.
					-->
					<li id="notifications">

						<div id="notification-icon">
							<h3>
							<?php echo getNotifCountByEmail($_SESSION['email']);?>
							</h3>
						</div>

						<div id="notifications-container" class="notifications-form">
							<div id="notifications-content">
								<span style="color: #F1F4F7;">
									
									<?php
									// get all notifications for user
									$resultSet = getAllNotifDetails($_SESSION['email']);
									if (!(empty($resultSet))){
										foreach ($resultSet as $result) {
											// print_r($result);
											// display notification iff its new
											if ($result['StatusId'] == 1) {
												echo "<div class=\"notif-msg-block\">";
												echo "<p id=\"notif-msg-{$result['Id']}\">";
												echo getNotifNameByID($result['TypeId']);
												echo " [";
												if (getNotifNameByID($result['TypeId']) == "IssueAssigned"){
													echo getEntityNameByIssueId($result['TypeEntityId']);
												} else {
													echo getEntityNameByProjectId($result['TypeEntityId']);
												}
												
												echo "] by ";
												echo getSenderName($result['SenderId']);
												echo ".</p> ";
												
										
												if (!(getNotifNameByID($result['TypeId']) == "IssueAssigned")){
													
													echo "<form action='' id=\"notif-form\">";
													echo "<input type=\"hidden\" name=\"ProjectId\" class=\"project-id-input\" value=\"{$result['TypeEntityId']}\">";
													echo "<input type=\"hidden\" name=\"EmailAddress\" class=\"emailaddress-input\" value=\"{$_SESSION['email']}\">";
													echo "<input type=\"hidden\" name=\"NotificationId\" class=\"notif-id-input\" value=\"{$result['Id']}\">";
													echo "<input type='button' name=\"submit\" id='notif-accept-button' value=\"Accept\">";
													echo "<input type='button' name=\"submit\" id='notif-reject-button' value=\"Reject\">";
													echo "</form>";
													
												} 
												echo "</div>";
												echo "<div style=\"clear:both;\"></div>";
											} 
										
										}
									} else {
										echo "<p> You don't have any notifications</p>";
									}
									
									?>
								</span>

							</div>
						</div>
					</li>
					
					<li id="login">
						<a href="#">
						<h3>Account Settings</h3>
						<span>User details</span>
						</a>
						<div id='login-container' class='login-form'>
							<h1 class='login-title'></h1>
							<div class='login-top'>
							</div>
							<div class='login-content'>
								<h3>User Info</h3>
								<label>Logged in as <?php	echo $_SESSION['email'];?></label>
								<label></label>
								
							</div>
						</div>
					</li>
					<li id="register">
						<a href="#">
						<h3>Widgets and Layout</h3>
						<span>Add widgets or Edit Layout</span>
						</a>
						<div id='register-container' class="register-form">
							<div id="switcher">
							</div>
							<a class="openaddwidgetdialog headerlink" href="#">
							<label>
								Add Widget
							</label>
							</a>
							<a class="editlayout headerlink" href="#">
							<label>
								Edit Layout
							</label>
							</a>
						</div>
					</li>
				</ul>
			</div>

		</div>
		
		<div id="user-box">
			
			<div id="createProject-container">
				<a rel="shadowbox;width=700;height=250;" href="newProject.php?action=create"><input type="button" id="createProject-button" value="Create Project" /></a>
		
			</div>
			
		</div>

		<div id="dashboard" class="dashboard">
			<div class="layout">
				<div class="column first column-first">
				</div>
				<div class="column second column-second">
				</div>
				<div class="column third column-third">
				</div>

			</div>
		</div>

	</body>
</html>
