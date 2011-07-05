<?php 



?>

<!DOCTYPE html>

<html lang="en">

<head>
  	<title>Tracey</title>
  	<meta name="description" content=" - Web-based Issue Tracker &amp; Project Management Solution" />
  	<meta name="keywords" content="tracey, issue tracker, software engineering, part 4 project" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />	

	<!-- stylesheets -->
  	<link rel="stylesheet" href="css/loginstyle.css" type="text/css" media="screen" />
  	<link rel="stylesheet" href="css/loginslide.css" type="text/css" media="screen" />
  	<!-- Page styles -->


<!-- Login Form CSS files -->
<link type='text/css' href='css/login.css' rel='stylesheet' media='screen' />

  	<link type="text/css" rel="stylesheet" href="css/openid.css" />
  	    <!-- jQuery (1.6.1)- the core -->
	<script src="js/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/openid-jquery.js"></script>
	<script type="text/javascript" src="js/openid-en.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			openid.init('openid_identifier');
			openid.setDemoMode(false); //Stops form submission for client javascript-only test purposes
		});
	</script>
	
  	<!-- PNG FIX for IE6 -->
  	<!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
	<!--[if lte IE 6]>
		<script type="text/javascript" src="js/pngfix/supersleight-min.js"></script>
	<![endif]-->
	 

	<script src="libraries/simplemodal/jquery.simplemodal-1.4.1.js" type="text/javascript"></script>
	<!-- <script type='text/javascript' src='js/login2.js'></script> -->
	<script src="js/index.js" type="text/javascript"></script>
	<script src="js/loginslide.js" type="text/javascript"></script>
	
	
</head>

<body>
<!-- Panel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			
			<div class="left">
				<form class="clearfix" action="./scripts/authentication/login.php" method="post">
					<h1>Login</h1>
					<label class="grey" for="email">Email:</label>
					<input class="field" type="text" name="email" id="email" value="" size="23" />
					<label class="grey" for="password">Password:</label>
					<input class="field" type="password" name="password" id="password" size="23" />
	            	<label><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> &nbsp;Remember me</label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Login" class="bt_login" />
					<a class="lost-pwd" href="#">Lost your password?</a>
				</form> 
				<div id ="showopenid"><h1>Got an OpenID? Click here!</h1></div>
				
			</div>
			<div class="left2">
				
				<form action="./scripts/openidtest.php" method="get" id="openid_form">
					<input type="hidden" name="action" value="verify" />
					<fieldset>
						<legend>Sign-in or Create New Account</legend>
						<div id="openid_choice">
			
							<p>Please click your account provider:</p>
							<div id="openid_btns"></div>
						</div>
						<div id="openid_input_area">
							<input id="openid_identifier" name="openid_identifier" type="text" value="http://" />
							<input id="openid_submit" type="submit" value="Sign-In"/>
						</div>
						<noscript>
							<p>OpenID is service that allows you to log-on to many different websites using a single indentity.
							Find out <a href="http://openid.net/what/">more about OpenID</a> and <a href="http://openid.net/get/">how to get an OpenID enabled account</a>.</p>
						</noscript>
					</fieldset>
				</form>
			</div>
			<div class="left right">			
				<!-- Register Form -->
				<form action="./scripts/registration/registration.php" method="post">
					<h1>Not a Tracey member? Sign Up!</h1>				
					<label class="grey" for="nickname">Nickname:</label>
					<input class="field" type="text" name="nickname" id="nickname" value="" size="23" />
					<label class="grey" for="email">Email:</label>
					<input class="field" type="text" name="email" id="email" size="23" />
					<label class="grey" for="password">Password:</label>
					<input class="field" type="password" name="password" id="password" size="23" />
					<input type="submit" name="submit" value="Register" class="bt_register" />
					
					
				</form>
			
			</div>
			
		</div>
</div> <!-- /login -->	

	<!-- The tab on top -->	
	<div class="tab">
		<ul class="login">
			<li class="left">&nbsp;</li>
			<li>Tracey</li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#">Log In | Register</a>
				<a id="close" style="display: none;" class="close" href="#">Close Panel</a>			
			</li>
			<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
	
</div> <!--panel -->


    <div id='container'>
	<div id='logo'>
	</div>
	<div id='content'>
		<div id='login-container'>
			
					<div class='login-top'></div>
					<div class='login-content'>
						<h1 class='login-title'>Login:</h1>
						<div class='login-loading' style='display:none'></div>
						<div class='login-message' style='display:none'></div>
						<form action='#' style='display:none'>
							<label for='login-email'>*Email:</label>
							<input type='text' id='login-email' class='login-input' name='email' tabindex='1002' />							
							<label for='login-password'>Password:</label>
							<input type='password' id='login-password' class='login-input' name='password' value='' tabindex='1003' />	
							<label>&nbsp;</label>
							<button type='submit' class='login-send login-button' tabindex='1006'>Send</button>
							<button type='submit' class='login-cancel login-button' tabindex='1007'>Cancel</button>
							<br/>
						</form>
					</div>
		
					
		 <!-- Login form is created inside the jquery script - uses the simple modal library (check login.js)-->
			
		</div>
		<div id='logininput'>
			<input type='button' name='login' value='Login' class='login demo' style='background:#333333; color:#DDDDDD; width:60px; height:40px; align:center; border:none;'/>
		</div>
		<!-- preload the images -->
		<div style='display:none'>
			<img src='images/loading.gif' alt='' />
		</div>
	</div>


	
	
	</div>
</body>
</html>
