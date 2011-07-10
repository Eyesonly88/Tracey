$(document).ready(function() {
	/*
	 * This file sends a function call to a php script. It passes two arguments to the script "AcceptId" and "NotificationId".
	 * Those arguments are used to change the status of the notification.
	 * The animation is lacking for now. I tried to implement the animation but was didn't work.
	 * @TODO: For the time being, this is working as expected. However, a good improvement is to make only the div containing the form to refresh and not the whole page.
	 * @TODO: Adding a bit of animation would be good too.
	 * @author:Mohammed.
	 */
	$('.accept-notif-form .notification-send').click(function (e) {
		//alert("You clicked Accept Son");
		//e.preventDefault(); -> if it is uncommented. then the page won't refresh and the notification won't be removed.
		$.ajax({
			url: 'scripts/notification/notification.php' ,
			data:  "AcceptId=2&NotificationId=" + $('.notif-id-input').val(),
			type: 'post',
			cache: false,
			dataType: 'text',
			success: function (data) {
				//alert("msg = " + data);
				// remove the form if an action is taken (Accept or Reject)
				// for some reason, this is not fading out ....
				if(data == 1){
					$('form .accept-notif-form').fadeOut(400);
				} else if (data == -1){
					$('form .reject-notif-form').fadeOut(400);
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
