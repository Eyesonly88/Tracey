$(document).ready(function() {
	/*
	 * This file sends a function call to a php script to send a project invitation to a user.
	 * @author:Mohammed.
	 */
	$('.invite-content p #confirm-inv-msg').hide();
	$('#Invite #projectInvite-form #inv-button').click(function (e) {
		//alert("HI");
		$.ajax({
			url: 'scripts/invite/invite.php' ,
			data:  "receiveremail="+ $('label input#receiver-email').val() +"&projectid=" + $('select option:selected').val() + "&senderemail="+ $('label input#sender-email').val(),
			type: 'post',
			cache: false,
			dataType: 'text',
			success: function (data) {
				if(data == 1){
					// Invitation sent successfully. Display message and update.
					$('.invite-content #confirm-inv-msg').empty();
					$('.invite-content #confirm-inv-msg').append("Invitation Sent!");
					$('.invite-content #confirm-inv-msg').fadeIn().delay(2000).fadeOut('slow'); 
					$('.invite-content #receiver-email').attr("value","");
				} else if (data == -1){
					$('.invite-content #confirm-inv-msg').empty();
					$('.invite-content #confirm-inv-msg').append("Error happended!");
					$('.invite-content #confirm-inv-msg').fadeIn().delay(2000).fadeOut('slow'); 
				}
			},
			error: "Error"
		});
		
		
	});
	
});
