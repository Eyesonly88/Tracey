$(document).ready(function() {
	
	$('#accept-notif-form .notification-send').click(function (e) {
		//alert("You clicked Accept Son");
		//e.preventDefault();
		$.ajax({
			url: 'scripts/notification/notification.php' ,
			data: $('#notifications-container form #accept-notif-form').serialize(),
			type: 'post',
			cache: false,
			dataType: 'text',
			success: function (data) {
				alert("msg = " + data);
			},
			error: "Error"
		});
		
		
	});
	
	$('.reject-notif-form .notification-send').click(function (e) {
		//alert("You clicked Reject Son");
		$.ajax({
			url: 'scripts/notification/notification.php' ,
			data: $('#notifications-container form .reject-notif-form').serialize(),
			type: 'post',
			cache: false,
			dataType: 'text',
			error: "Error"
		});
	});
	
});
