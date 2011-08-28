<?php 
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sql_notificationfn.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
confirmLogin();

$projectid = -1;

/* Get the projectid and store it in session (if it is set) */
if (isset($_GET['id'])){	
	$projectid = $_GET['id'];
	$_SESSION['projectid'] = $projectid;
} else {
	 return -1; 
}


?>


<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Dashboard: Project <?php echo $projectid; ?></title>

		<link rel="stylesheet" type="text/css" href="css/customStyle.css" />
		<link rel="stylesheet" type="text/css" href="css/dashboardui.css" />
		<link rel="stylesheet" type="text/css" href="libraries/dashboard/themes/default/jquery-ui-1.8.2.custom.css" />
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-ui-1.8.2.custom.min.js"></script>
		<script type="text/javascript" src="libraries/dashboard/jquery.dashboard.js"></script>
		<script type="text/javascript" src="libraries/dashboard/lib/themeroller.js"></script>
		<script src="js/jquery.hoverIntent.js"></script>
		<script src="js/define_projectdashboard.js"></script>
		<script src="js/projectdashboard_panel.js"></script>
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
				$(".invite-form").hide();
				$("#notifications").hoverIntent( function() {
					$(".notifications-form").fadeIn(200);
				}
				, function() {
					$(".notifications-form").fadeOut(200);
				}
			);
			$("#Invite").hoverIntent( function() {
					$(".invite-form").fadeIn(200);
				}
				, function() {
					$(".invite-form").fadeOut(200);
				}
			);

			});</script>
		
		
		
	</head>
	
<body class="custom">
	
	<input type='hidden' id="pid" value="<?php echo $projectid; ?>" /> 
	<input type='hidden' id="user" value="<?php echo $_SESSION['email']; ?>" />
	
	<!--<div id="testcontent">SUP!!!. You are now on the project dashboard for project: <?php echo $projectid; ?></div>.-->
	
	



		<div id="header-area">
			<div id="header">
				<div class="menu-container">
					<!-- Menu items = Home, About, Help -->
					<ul class="menu">
						<li>
							<a href="/user_dashboard.php">User Dashboard</a>
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
												if (getNotifNameByID($result['TypeId']) === "IssueAssigned"){
													echo getEntityNameByIssueId($result['TypeEntityId']);
												} else {
													echo getEntityNameByProjectId($result['TypeEntityId']);
												}
												echo "] by ";
												echo getSenderName($result['SenderId']);
												echo ".</p> ";
												
												if (!(getNotifNameByID($result['TypeId']) == "IssueAssigned")){
													
													echo "<form action='' id=\"notif-form\">";
													echo "<input type=\"hidden\" name=\"NotificationId\" class=\"notif-id-input\" value=\"{$result['Id']}\">";
													echo "<input type='button' name=\"submit\" id='notif-accept-button' value=\"Accept\">";
													echo "<input type='button' name=\"submit\" id='notif-reject-button' value=\"Reject\">";
													echo "</form>";
													
												} 
												echo "</div>";
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
					
					<li id="Invite">
						<a href="#">
						<h3>Invite Members</h3>
						<span>Invite people to your project</span>
						</a>
						<div id='invite-container' class='invite-form'>
							<div class='invite-content'>
								<form action="" id="projectInvite-form">
									 	
										<label>Receiver's e-mail:
										<input type="text" name="receiveremail" id="receiver-email" value=""/>
										</label>
										<label>Project:
											
											<select name="projectid" id="projectid-selector">
												<?php 
												
													$resultSet = getProjectsByEmail($_SESSION['email']);
													foreach ($resultSet as $result){
														echo "<option value=\"" . $result['ProjectId'] ."\">" . $result['ProjectName'] . "</option>";
													}
												 
												
												?>
											</select>
											
											<input type="hidden" name="senderemail" id="sender-email" value="<?php echo $_SESSION['email']; ?>" />
											<input type="button"  name="submit" value="Invite" id="inv-button"/>
											<p id="confirm-inv-msg"></p>
										</label>	

								</form>
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
			
			<div id="createIssue-createComponent-container">
				<a rel="shadowbox;width=1100;height=700" href="newIssue.php?action=create"><input type="button" id="createIssue-button" value="Create Issue" /></a>
				<input type="button" id="createComponent-button" value="Create Component" />
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
