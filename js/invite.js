$(document).ready(function() {
	/*
	 * This file sends a function call to a php script to send a project invitation to a user.
	 * @author:Mohammed.
	 */
	$('#logincontent p #confirm-inv-msg').hide();
	$('#projectInvite-form #inv-button').click(function (e) {

		$.ajax({
			url: 'scripts/invite/invite.php' ,
			data:  "receiveremail="+ $('label input#receiver-email').val() +"&projectid=" + $('select option:selected').val() + "&senderemail="+ $('label input#sender-email').val(),
			type: 'post',
			cache: false,
			dataType: 'text',
			success: function (data) {
				if(data == 1){
					// Invitation sent successfully. Display message and update.
					$('.login-content #confirm-inv-msg').empty();
					$('.login-content #confirm-inv-msg').append("Invitation Sent!");
					$('.login-content #confirm-inv-msg').fadeIn().delay(2000).fadeOut('slow'); 
					$('.login-content #receiver-email').attr("value","");
				} else if (data == -1){
					$('.login-content #confirm-inv-msg').empty();
					$('.login-content #confirm-inv-msg').append("Error happended!");
					$('.login-content #confirm-inv-msg').fadeIn().delay(2000).fadeOut('slow'); 
				}
			},
			error: "Error"
		});
		
		
	});
	
});
