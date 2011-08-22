/*
	 * This file sends a function call to a php script. It passes two arguments to the script "AcceptId"/"RejectId" and "NotificationId".
	 * Those arguments are used to change the status of the notification.
	 * When the user clicks on accept/reject button, then the script does the operation and then hides the specific notification.
	 * @author:Mohammed.
	 */

$(document).ready(function() {
	

	$('#notifications-container form #notif-accept-button').click(function (e) {
		
		var notifForm = $(this).parent();
		var notifId = notifForm.children('.notif-id-input').val();
		var projectId = notifForm.children('.project-id-input').val();
		var emailAddress = notifForm.children('.emailaddress-input').val();
		var notifMsg = notifForm.parent().children('#notif-msg-'+notifId);
		var notifCount = $('#notification-icon h3').text();
		
		$.ajax({
			url: 'scripts/notification/notification.php' ,
			data:  "AcceptId=2&NotificationId=" + notifId + "&ProjectId=" + projectId + "&emailAddress=" + emailAddress,
			type: 'post',
			cache: false,
			dataType: 'text',
			success: function (data) {

				if(data == 1){
					alert("success");
					notifCount = parseInt(notifCount) - 1;
					$('#notification-icon h3').text(notifCount);
					notifForm.fadeOut(400);
					notifMsg.fadeOut(400);
				} else if (data == -1){
					// accepting failed	
					alert("failed");
				}
			},
			error: "Error"
		});
		
		
	});
	
	$('#notifications-container form #notif-reject-button').click(function (e) {
		
		var notifForm = $(this).parent();
		var notifId = notifForm.children('.notif-id-input').val();
		var notifMsg = notifForm.parent().children('#notif-msg-'+notifId);
		var notifCount = $('#notification-icon h3').text();
		
		$.ajax({
			url: 'scripts/notification/notification.php' ,
			data: "RejectId=3&NotificationId=" + notifId,
			type: 'post',
			cache: false,
			dataType: 'text',
			success: function (data) {

				if(data == 1){
					notifCount = parseInt(notifCount) - 1;
					$('#notification-icon h3').text(notifCount);
					notifForm.fadeOut(400);
					notifMsg.fadeOut(400);
				} else if (data == -1){
					// rejecting failed
				}
			},
			error: "Error"
		});
	});
	
});
