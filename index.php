<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_notificationfn.php');

confirmLogin2();

?>

<!DOCTYPE html>
<html>
	<head>
			<link rel="stylesheet" href="/css/customStyle.css" type="text/css" media="screen, projection">
		
			<title>Tracey!</title>
			<script src="js/jquery.js"></script>
			<script src="js/jquery.hoverIntent.js"></script>
			<script src="js/loginpanel.js"></script>
	<script>
	//Put all the jquery stuff in loginpanel.js
	</script>
	</head>
		
	<body class="custom">
		<div id="header-area">
			
			
				<div id="header">
					<div class="menu-container">
						<!-- Menu items = Home, About, Help -->
						<ul class="menu">
							<li><a href="#">Home</a></li>
							<li><a href="#">About</a></li>
							<li><a href="#">Help</a></li>
						</ul>
					</div>
					
					<ul id="nav">
						<!-- Load Navigation items ..
							1. Logged in user = Account, Themes, Logout Button.
							2. Visitor = Login, Register.
						-->
						<li id="login">
							<a href="#">
								<h3>Login</h3>
								<span>Or Use OpenID</span>	
							</a>
							<div id='login-container' class='login-form'>
								<h1 class='login-title'></h1>
								<div class='login-top'></div>
								<div class='login-content'>
									<div class='login-loading' style='display:none'></div>
									<div class='login-message' style='display:none'></div>
									<form action='#' style='display:none'>
										<label for='login-email' class='grey'>Email:</label>
										<input type='text' id='login-email' class='login-input field' name='email' tabindex='1002' />							
										<label for='login-password' class='grey'>Password:</label>
										<input type='password' id='login-password' class='login-input field' name='password' value='' tabindex='1003' />	
										<label>&nbsp;</label>
										<button type='submit' class='login-send login-button bt_login' tabindex='1006'>Login</button>
										<br/>
									</form>
								</div>
							</div>
						</li>
						<li id="register">
							<a href="#">
								<h3>Register</h3>
								<span>Takes 3 seconds</span>	
							</a>
							
							<div id='register-container' class='register-form'>
								<h1 class='register-title'></h1>
								<div class='register-top'></div>
								<div class='register-content'>
									<div class='register-loading' style='display:none'></div>
									<div class='register-message' style='display:none'></div>
									<form action='#' style='display:none'>
										<label for='register-nickname' class='grey'>Nickname:</label>
										<input type='text' id='register-nickname' class='register-input field' name='nickname' tabindex='1002' />	
										<label for='register-email' class='grey'>Email:</label>
										<input type='text' id='register-email' class='register-input field' name='email' tabindex='1002' />							
										<label for='register-password' class='grey'>Password:</label>
										<input type='password' id='register-password' class='register-input field' name='password' value='' tabindex='1003' />	
										<label>&nbsp;</label>
										<button type='submit' class='register-send register-button bt_register' tabindex='1006'>Register</button>
										<br/>
									</form>
								</div>
							</div>
							
							<!-- <div class="register-form">-->
								<!-- Register Form -->
								<!-- <form action="./scripts/registration/registration.php" method="post">			
									<label class="grey" for="nickname">Nickname:</label>
									<input class="field" type="text" name="nickname" id="nickname" value="" size="23" />
									<label class="grey" for="email">Email:</label>
									<input class="field" type="text" name="email" id="email" size="23" />
									<label class="grey" for="password">Password:</label>
									<input class="field" type="password" name="password" id="password" size="23" />
									<input type="submit" name="submit" value="Register" class="bt_register" />
									
									
								</form>-->
							</div>
						</li>
					</ul>
				</div>
				<div style='display:none'>
					<img src='images/loading6.gif' alt='' />
				</div>
				
				<div id="bodycontent" style="padding:1%;">
					
					
					
				</div>
			
		</div>
	</body>
</html>