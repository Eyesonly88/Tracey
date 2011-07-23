<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sql_notificationfn.php');
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
		<script src="js/jquery.hoverIntent.js"></script>
		<script src="js/loginpanel.js"></script>
		<script src="js/define_userdashboard.js"></script>
		<script src="js/notification.js"></script>
		<script src="js/invite.js"></script>
		<script>$(document).ready( function() {
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
							<a href="/scripts/authentication/logout.php">Logout!</a>
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
									foreach ($resultSet as $result) {
										// print_r($result);
										// display notification iff its new
										if ($result['StatusId'] == 1) {
											echo "<p id=\"notif-msg-{$result['Id']}\">";
											echo getNotifNameByID($result['TypeId']);
											echo " [";
											echo getEntityNameByProjectId($result['TypeEntityId']);
											echo "] by ";
											echo getSenderName($result['SenderId']);
											echo ".</p> ";
											
									?>
									
									<form action='' id="notif-form">
										<input type="hidden" name="NotificationId" class="notif-id-input" value="<?php echo $result['Id'];?>" />
										<input type='button' name="submit" id='notif-accept-button' value="Accept">
										<input type='button' name="submit" id='notif-reject-button' value="Reject">
									</form>
									
									<?php
										} else {
											// don't display notification
										}
										
										 
									}
									?>
								</span>

							</div>
						</div>
					</li>
					<li id="login">
						<a href="#">
						<h3>Account Settings</h3>
						<span>Change account details or Logout</span>
						</a>
						<div id='login-container' class='login-form'>
							<h1 class='login-title'></h1>
							<div class='login-top'>
							</div>
							<div class='login-content'>
								<h3>User Info</h3>
								<label>Logged in as <?php	echo $_SESSION['email'];?></label>
								<label></label>
								<h3>Invite People</h3>
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
											<input type="button"  name="submit" value="Invite" id="inv-button" />
											<p id="confirm-inv-msg"></p>
										</label>	

								</form>
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
