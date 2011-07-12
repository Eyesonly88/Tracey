 $(document).ready(function() { 
 	
 	$.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/project/checkProjectPermissions.php",
	   data: 'projectid='+$('#pid').val()+'&userid='+$('#user').val(),
	   success: function(msg){
	   	alert('projectid='+$('#pid').val()+'&userid='+$('#user').val() + '   ' + msg);
	     if (msg != 1){ 
	     	window.location.replace('/index.php');
	     }
	   }
   
 	});
 	
 }); 