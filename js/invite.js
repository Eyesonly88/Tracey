$(document).ready(function() {
	/*
	 * This file sends a function call to a php script.
	 * @author:Mohammed.
	 */
	$('#logincontent p #confirm-inv-msg').hide();
	$('#projectInvite-form #inv-button').click(function (e) {
		//alert("You clicked Accept Son");
		//e.preventDefault(); //-> if it is uncommented. then the page won't refresh and the notification won't be removed.
		$.ajax({
			url: 'scripts/invite/invite.php' ,
			data:  "receiveremail="+ $('label input#receiver-email').val() +"&projectid=" + $('select option:selected').val() + "&senderemail="+ $('label input#sender-email').val(),
			type: 'post',
			cache: false,
			dataType: 'text',
			success: function (data) {
				if(data == 1){
					
					$('.login-content #confirm-inv-msg').empty();
					$('.login-content #confirm-inv-msg').append("Done!");
					$('.login-content #confirm-inv-msg').fadeIn().delay(2000).fadeOut('slow'); 
					$('.login-content #receiver-email').attr("value","");
				} else if (data == -1){
					
				}
			},
			error: "Error"
		});
		
		
	});
	
	$('.reject-notif-form .notification-send').click(function (e) {
		//alert("You clicked Reject Son");
		$.ajax({
			url: 'scripts/notification/notification.php' ,
			data: "RejectId=3&NotificationId=" + $('.notif-id-input').val(),
			type: 'post',
			cache: false,
			dataType: 'text',
			success: function (data) {
				//alert("msg = " + data);
				// remove the form if an action is taken (Accept or Reject)
				if(data == 1){
					$('form .accept-notif-form').fadeOut(400);
				} else if (data == -1){
					$('form .reject-notif-form').fadeOut(400);
				}
			},
			error: "Error"
		});
	});
	
});
