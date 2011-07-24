<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');

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
					</ul>
				</div>

				<ul id="nav">
					<!-- Load Navigation items ..
					1. Logged in user = Account, Themes, Logout Button.
					2. Visitor = Login, Register.
					-->
					
					<li id="login">
						<a href="#">
						<h3>Account Settings</h3>
						<span>Change account settings or Logout</span>
						</a>
						<div id='login-container' class='login-form'>
							<h1 class='login-title'></h1>
							<div class='login-top'>
							</div>
							<div class='login-content'>
							<label>
									Logged in as
									<U>
										<?php	echo $_SESSION['email'];?>
									</U>
								</label>
								<label>
									<span>
										<a href="/scripts/authentication/logout.php">LOGOUT</a>
									</span>
								</label>
							</div>
						</div>
					</li>
					<li id="register">
						<a href="#">
						<h3>New Issue</h3>
						<span>Create a new issue</span>
						</a>
						<div id='register-container' class="register-form">
						<label>Display new issue fields</label>
						</div>
					</li>
				</ul>
			</div>

		</div>
		<!-- Body here -->
		<div id="issuewrap">
			<h3>Add Project Dashboard</h3>
			<div id="issue-info-container">
				<h3>Issue Information</h3>
				<span >Edit</span>
				<div id="issue-info">
					
				</div>
			</div>
			
			<div id="issue-desc-container">
				<h3>Issue Description</h3>
				<span >Edit</span>
				<div id="issue-desc">
					
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
		</div>

	</body>
</html>
