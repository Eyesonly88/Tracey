/*
 * Copyright (c) 2010 Eric Martin - [Simple Modal Library]
 * Copyright (c) 2011 Tracey Team -
 * Adeeb Rahman
 * Mohammed Abu-alsaad
 * [Custom Login Form with Simple Modal Library]
 * 
 *  Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 * 
 */

jQuery(function ($) {
	
	/* Big variable declaration for the login form */
	var login = {
		message: null,
		init: function () {
			$('#login-form input.login, #login-form a.login').click(function (e) {
				e.preventDefault();
				
				/* This variable stores the HTML of the login form. This is used to generate the login form in the popup dialog */
				var loginform = 
				"<div style='display:none'>" +
					"<div class='login-top'></div>"+
						"<div class='login-content'>"+
							"<h1 class='login-title'>Login:</h1>"+
							"<div class='login-loading' style='display:none'></div>"+
							"<div class='login-message' style='display:none'></div>"+
							"<form action='#' style='display:none'>"+
								"<label for='login-email'>*Email:</label>"+
								"<input type='text' id='login-email' class='login-input' name='email' tabindex='1002' />"+								
								"<label for='login-password'>Password:</label>"+
								"<input type='password' id='login-password' class='login-input' name='password' value='' tabindex='1003' />"+		
								"<label>&nbsp;</label>"+
								"<button type='submit' class='login-send login-button' tabindex='1006'>Send</button>"+
								"<button type='submit' class='login-cancel login-button simplemodal-close' tabindex='1007'>Cancel</button>"+
								"<br/>"+
							"</form>"+
						"</div>"+
				"</div>";
		
				/* create a modal dialog (using the simple modal library) with the login form above */
				$(loginform).modal({
					closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
					position: ["15%",],
					overlayId: 'login-overlay',
					containerId: 'login-container',
					onOpen: login.open,
					onShow: login.show,
					onClose: login.close
				});	
			});
		},
		
		/* These are custom functions. i.e. 
		open: function(dialog) means run this function when login.open is called inside the script */
		open: function (dialog) {
			// add padding to the buttons in firefox/mozilla
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
			$('#login-container .login-title').html('Loading...');
			dialog.overlay.fadeIn(200, function () {
				dialog.container.fadeIn(200, function () {
					dialog.data.fadeIn(200, function () {
						$('#login-container .login-content').animate({
							height: h
						}, function () {
							$('#login-container .login-title').html(title);
							
							/* @TODO here: need to do an ajax call to check if a user is logged in to the session.
							If so, then do not display the login form but either:
							Display button to go to dashboard, or just redirect to dashboard (need to decide) */
							
							$('#login-container form').fadeIn(200, function () {
								$('#login-container #login-name').focus();

								$('#login-container .login-cc').click(function () {
									var cc = $('#login-container #login-cc');
									cc.is(':checked') ? cc.attr('checked', '') : cc.attr('checked', 'checked');
								});

								// fix png's for IE 6
								if ($.browser.msie && $.browser.version < 7) {
									$('#login-container .login-button').each(function () {
										if ($(this).css('backgroundImage').match(/^url[("']+(.*\.png)[)"']+$/i)) {
											var src = RegExp.$1;
											$(this).css({
												backgroundImage: 'none',
												filter: 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="' +  src + '", sizingMethod="crop")'
											});
										}
									});
								}
							});
						});
					});
				});
			});
		},
		
		/* function to be executed for login.show. This contains the ajax call to login2.php to authenticate (as long as field validation passes)*/
		show: function (dialog) {
			$('#login-container .login-send').click(function (e) {
				e.preventDefault();
				// validate form
				if (login.validate()) {
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
											login.message += 'Authentication Failed';
											$('#login-container .login-message').animate({
												height: '30px'
											}, login.showError);
											//login.close();
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
								error: login.error
							});
						});
					});
				}
				else {
					if ($('#login-container .login-message:visible').length > 0) {
						var msg = $('#login-container .login-message div');
						msg.fadeOut(200, function () {
							msg.empty();
							login.showError();
							msg.fadeIn(200);
						});
					}
					else {
						$('#login-container .login-message').animate({
							height: '30px'
						}, login.showError);
					}
					
				}
			});
		},
		
		/* Function to execute when login.close is called. i.e. it closes the dialog window s*/
		close: function (dialog) {
			$('#login-container .login-message').fadeOut();
			$('#login-container .login-title').html('Closing...');
			$('#login-container form').fadeOut(200);
			$('#login-container .login-content').animate({
				height: 40
			}, function () {
				dialog.data.fadeOut(200, function () {
					dialog.container.fadeOut(200, function () {
						dialog.overlay.fadeOut(200, function () {
							$.modal.close();
						});
					});
				});
			});
		},
		error: function (xhr) {
			alert(xhr.statusText);
		},
		
		/* login.validate function. Does some nice validation checks on the email 
		and password fields to ensure they are valid */
		validate: function () {
			login.message = '';

			var email = $('#login-container #login-email').val();
			if (!email) {
				login.message += 'Email is required. ';
			}
			else {
				if (!login.validateEmail(email)) {
					login.message += 'Email is invalid. ';
				}
			}

		

			if (login.message.length > 0) {
				return false;
			}
			else {
				return true;
			}
		},
		
		/* Email validation with multiple regex checks (explained below) ^^ */
		validateEmail: function (email) {
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
		},
		showError: function () {
			$('#login-container .login-message')
				.html($('<div class="login-error"></div>').append(login.message))
				.fadeIn(200);
		}
	}; //end of variable declaration (i.e. var login =...)
	
	login.init();

});