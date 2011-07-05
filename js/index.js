$(document).ready(function() {
	//$('#login-container').hide();
	afterShow();
	$('#logininput input.login, #logininput a.login').hover(function (e) {
				//e.preventDefault();
				///alert("HI!!!!!!");
	
			showLogin();
			
			
		});
});

var message = '';

function showLogin() { 
	$('#logininput').fadeOut(200);
	//alert("SUP!");
	if ($.browser.mozilla) {
		$('#login-container .login-button').css({
			'padding-bottom': '2px'
		});
	}
	// input field font size
	if ($.browser.safari) {
		$('#login-container .login-input').css({
			'font-size': '.9em'
		});
	}

	// dynamically determine height
	var h = 150;
	if ($('#login-subject').length) {
		h += 26;
	}
	if ($('#login-cc').length) {
		h += 22;
	}

	var title = $('#login-container .login-title').html();
	//$('#login-container .login-title').html('Loading...');
	$('#login-container').fadeIn(200, function () {
		
			$('#login-container .login-content').animate({
				height: h
			}, function () {
				$('#login-container .login-title').html(title);
				
				/* @TODO here: need to do an ajax call to check if a user is logged in to the session.
				If so, then do not display the login form but either:
				Display button to go to dashboard, or just redirect to dashboard (need to decide) */
				
				$('#login-container form').fadeIn(200, function () {
					$('#login-container #login-name').focus();


					// fix png's for IE 6
					/*if ($.browser.msie && $.browser.version < 7) {
						$('#login-container .login-button').each(function () {
							if ($(this).css('backgroundImage').match(/^url[("']+(.*\.png)[)"']+$/i)) {
								var src = RegExp.$1;
								$(this).css({
									backgroundImage: 'none',
									filter: 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="' +  src + '", sizingMethod="crop")'
								});
							}
						});
					}*/
				});			
		});
	});
	

}
	
function afterShow() { 
	$('#login-container .login-send').click(function (e) {
		e.preventDefault();
		// validate form
		if (validate()) {
			var msg = $('#login-container .login-message');
			msg.fadeOut(function () {
				msg.removeClass('login-error').empty();
			});
			$('#login-container .login-title').fadeIn(400);
			$('#login-container .login-title').html('Checking details...');
			$('#login-container form').fadeOut(200);
			$('#login-container .login-content').animate({
				height: '80px'
			}, function () {
				$('#login-container .login-loading').fadeIn(200, function () {
					
					/* This is the jquery AJAX call to login2.php to serialize the form data 
					and authenticate the user using this data. The success function gets the 'return' data
					from login2.php, which in this case is the url to redirect to. The success function
					then performs a javascript redirection to the specified url. */
					$.ajax({
						url: 'scripts/authentication/login2.php' ,
						data: $('#login-container form').serialize() + '&action=send',
						type: 'post',
						cache: false,
						dataType: 'text',
						success: function (data) {
							
							
							if (data == 1){
									$('#login-container .login-title').html('Invalid Input');
									('#login-container .login-title').fadeOut(400);
								} else if (data == 2){
									
									$('#login-container form').fadeIn(200);
									$('#login-container .login-content').animate({
										height: '150px'});
										
									/* Fade out the previous status message and the animated 'loading' image */
									$('#login-container .login-title').fadeOut(400);
									$('#login-container .login-loading').fadeOut(200);
									
									var msg = $('#login-container .login-message div');
									message += 'Authentication Failed';
									$('#login-container .login-message').animate({
										height: '30px'
									}, showError());
								
								} else {
									$('#login-container .login-loading').fadeOut(200, function () {
															
										$('#login-container .login-title').html('Logging in...');
										
										/* Loads the 'loading' animation image and waits for 1 second before redirecting :7 */
										$('#login-container .login-loading').fadeIn(200, function (){
											setTimeout(function(){window.location.replace(data);}, 1000) 
										});
	
									});
								}
							
						},
						error: "Error"
					}); //end of ajax
				});
			});
		}
		else {
			if ($('#login-container .login-message:visible').length > 0) {
				var msg = $('#login-container .login-message div');
				msg.fadeOut(200, function () {
					msg.empty();
					showError();
					msg.fadeIn(200);
				});
			}
			else {
				$('#login-container .login-message').animate({
					height: '30px'
				}, showError());
			}
			
		}
	});
	
	$('#login-container .login-cancel').click(function (e) { 
		
		hideLogin();
		
		
		
		
	});
}


function hideLogin() { 
	
	$('#login-container .login-message').fadeOut();
			//$('#login-container .login-title').html('Closing...');
			$('#login-container form').fadeOut(200);
			$('#login-container .login-content').animate({
				height: 40
			});
			 //function () {
				//$('#login-container').fadeOut(200, function () {
					
				//});
			//});
			$('#logininput').fadeIn(200);
}
		
function error(){

		alert(xhr.statusText);
	
}

function validate(){
	
	message = '';

	var email = $('#login-container #login-email').val();
	if (!email) {
		message += 'Email is required. ';
	}
	else {
		if (!validateEmail(email)) {
			message += 'Email is invalid. ';
		}
	}



	if (message.length > 0) {
		return false;
	}
	else {
		return true;
	}
		
}

function validateEmail(email) { 
	var at = email.lastIndexOf("@");

	// Make sure the at (@) sybmol exists and  
	// it is not the first or last character
	if (at < 1 || (at + 1) === email.length)
		return false;

	// Make sure there arent multiple periods together
	if (/(\.{2,})/.test(email))
		return false;

	// Break up the local and domain portions
	var local = email.substring(0, at);
	var domain = email.substring(at + 1);

	// Check lengths
	if (local.length < 1 || local.length > 64 || domain.length < 4 || domain.length > 255)
		return false;

	// Make sure local and domain don't start with or end with a period
	if (/(^\.|\.$)/.test(local) || /(^\.|\.$)/.test(domain))
		return false;

	// Check for quoted-string addresses
	// Since almost anything is allowed in a quoted-string address,
	// we're just going to let them go through
	if (!/^"(.+)"$/.test(local)) {
		// It's a dot-string address...check for valid characters
		if (!/^[-a-zA-Z0-9!#$%*\/?|^{}`~&'+=_\.]*$/.test(local))
			return false;
	}

	// Make sure domain contains only valid characters and at least one period
	if (!/^[-a-zA-Z0-9\.]*$/.test(domain) || domain.indexOf(".") === -1)
		return false;	

	return true;
		
}

function showError(){
	$('#login-container .login-message')
		.html($('<div class="login-error"></div>').append(message))
		.fadeIn(200);
	
}
