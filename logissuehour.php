<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');

confirmLogin();

$id = '';

if (isset($_GET['id'])){
		$id = $_GET['id'];
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Log Issue Hour</title>

		<link rel="stylesheet" type="text/css" href="css/customStyle.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.15.custom.css" />
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="libraries/dashboard/lib/jquery-ui-1.8.2.custom.min.js"></script>
		<script src="js/jquery.hoverIntent.js"></script>
		<script src="js/loginpanel.js"></script>
		<script src="js/jquery-ui-1.8.15.custom.min.js"></script>
		<script src="js/jquery.ui.core.js"></script>
		<script src="js/jquery.ui.widget.js"></script>
		<script src="js/jquery.ui.datepicker.js"></script>
		<script src="js/jquery.ui.button.js"></script>
		<script>
		
	$(document).ready( function() {
		
			$('#submitlog_btn').click(function(){
				
				
				var hours = $('#hourslogged').val();
				var desc = $('#description').val();
				var user = $('#useremail').val();
				var issue = $('#issueid').val();
							
				$.ajax({
					  	   cache: "false",
						   type: "POST",
						   url: "scripts/issue/logHours.php",
						   data: "id="+issue+"&hours="+hours+"&desc="+desc+"&user="+user,
						   
						  	success: function(msg){
						  		//alert(msg);
							  	if (msg == 1){
							     	$(".hourswrap").hide("slow");
							     	$("#hours_statusinfo").append("<h2> Work hours Submitted. </h2><BR />");
							     	$("#hours_statusinfo").show("slow");
								} else {
									$(".hourswrap").hide("slow");
							     	$("#hours_statusinfo").append("<h2> Something went horribly wrong: " + msg + "</h2><BR />");
							     	$("#hours_statusinfo").show("slow");
								}
						          
						   }
					   
					 	});
			
			});
		});	
			
		</script>

	</head>

	<body>
		
		<!-- Body here -->
		<div id="projectwrap" class="hourswrap">
			
			<h3>Log Issue Hour</h3><BR><BR>
			<div id="createproject-info-container">
				
				<div id="project-info">
					<label><p>Hours Logged:</p>
						<input type="text" name="hourslogged" id="hourslogged" value=""/>
					</label>
					
					<label><p>Description of Work:</p>
						<input type="text" name="description" id="description" value=""/>
	
					</label>

						<input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['email']; ?>" />
						<input type="hidden" name="issueid" id="issueid" value="<?php echo $id; ?>" />
						<input type="button" id="submitlog_btn" name="submit" value="Submit Work Log" />
						
					</label>
				</div>
			</div>

		</div>
		<div id="hours_statusinfo"></div>

	</body>
</html>
