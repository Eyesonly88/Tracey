<?php // Add php scripts here

include_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_componentfunctions.php');
confirmLogin();

$componentid = '';
$componentarray = '';
$componentinfo = '';
$isView = 0;
if (isset($_GET['id'])) {
	
	$componentid = $_GET['id'];
	$componentarray = getComponentInfoById($componentid);
	$componentinfo = $componentarray[0];
	$isView = 1;
}





?>

<!DOCTYPE html>

<head>
			<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Create Component</title>
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
		
		<script>
		
	$(document).ready( function() {
		
			$('#component-duedate').datepicker();
			$('#confirm_btn').click(function(){
				
				var due = $('#component-duedate').val();
				var project = $('#component-projectlist').val();
				var name = $('#component-name').val();
				var hours = $('#component-requiredhours').val();
				var user = $('component-requiredhours').val();
				var leader = $('#user-email').val();
				var isView = $('#isView').val();
				var componentid = $('#componentidVAR').val();
				//alert(isView);
				if (isView == 1){ 
					
					$.ajax({
						  	   cache: "false",
							   type: "POST",
							   url: "scripts/project/modifyComponent.php",
							   data: "name="+name+"&id="+componentid+"&email="+leader+"&due="+due+"&hours="+hours,
							   
							  	success: function(msg){
							  		//alert(msg);
								  	if(msg == 1) {
								
									$(".box").fadeOut("fast");
									$(".box").html("<h2>Changes saved. Click outside this window to return to the dashboard.</h2>");
									$(".box").fadeIn("slow");
									
									//$("#statusinfo").append("<h2> Changes Saved. </h2><BR />");
									//$("#statusinfo").show("slow");
								} else {
									//$(".box").hide("slow");
									//$("#statusinfo").append("<h2> Something went horribly wrong: " + msg + "</h2><BR />");
									//$("#statusinfo").show("slow");
								
									$(".box").fadeOut("fast");
									$(".box").html("<h2>Something went horribly wrong: " + msg + ". Click outside this window to return to the dashboard.</h2>");
									$(".box").fadeIn("slow");
								}
							    // setupFlexTable2();
							          
							   }
						   
					});	
					
				} else {
					$.ajax({
						  	   cache: "false",
							   type: "POST",
							   url: "scripts/project/createComponent.php",
							   data: "name="+name+"&id="+project+"&email="+leader+"&due="+due+"&hours="+hours,
							   
							  	success: function(msg){
							  		//alert(msg);
								  	if(msg == "1") {
								
									$(".box").fadeOut("fast");
									$(".box").html("<h2>Changes saved. Click outside this window to return to the dashboard.</h2>");
									$(".box").fadeIn("slow");
									
									//$("#statusinfo").append("<h2> Changes Saved. </h2><BR />");
									//$("#statusinfo").show("slow");
								} else {
									//$(".box").hide("slow");
									//$("#statusinfo").append("<h2> Something went horribly wrong: " + msg + "</h2><BR />");
									//$("#statusinfo").show("slow");
								
									$(".box").fadeOut("fast");
									$(".box").html("<h2>Something went horribly wrong: " + msg + ". Click outside this window to return to the dashboard.</h2>");
									$(".box").fadeIn("slow");
								}
							    // setupFlexTable2();
							          
							   }
						   
					});
				}
				return false;
			});
		});	
			
		</script>
	
		
		
</head>
<body style="overflow: hidden">
	<form>
		<input type="hidden" name="userEmail" id="user-email" value="<?php echo $_SESSION['email'];?>" />
		<input type="hidden" name="isView" id="isView" value="<?php echo $isView;?>" />
		<input type="hidden" name="componentidVAR" id="componentidVAR" value="<?php echo $componentid;?>" />
		<div class="box">
			<fieldset class="tabular">
				<legend>
					Create New Component
				</legend>
				<div id="attributes">
					<p>
						<label for="component-name">Component Name<span class="required"> *</span></label>
						<?php if ($isView == 1) {
							echo '<input type="text" id="component-name" required="required" style="width: 400px; color:#000;" value="' . $componentinfo['Name'] . '"/>';
						} else { ?>
							<input type="text" id="component-name" required="required" style="width: 400px; color:#000;" />
						<?php } ?>
					</p>
					<p>
						<label for="component-projectlist"> <?php if ($isView == 1) { echo "Project"; } else {echo "Select Project"; } ?> <span class="required"> *</span></label>
						<select id="component-projectlist" required="required">
							<?php
							
								
								
								if ($isView == 1) {
									$projectid2 = $componentinfo['ProjectId'];
									$projectname = getProjectNameById($projectid2);
									echo "<option value=\"" . $componentinfo['ProjectId'] . "\" selected>" . $projectname[0]['ProjectName'] . "</option>"; 
									
								} else {
									$resultSet = getProjectsByEmail($_SESSION['email']);
									foreach($resultSet as $result) {
										$projectidTEMP = $result['ProjectId'];
										if ($projectidTEMP == $_SESSION['projectid']) {
											echo "<option value=\"" . $result['ProjectId'] . "\" selected>" . $result['ProjectName'] . "</option>"; 
										} else {
											echo "<option value=\"" . $result['ProjectId'] . "\">" . $result['ProjectName'] . "</option>"; 
										}
									}
							}
							?>
						</select>
					</p>
					<p>
						<label for="component-requiredhours">Required Hours</label>
						<?php if ($isView == 1) {
							echo '<input type="text" id="component-requiredhours" style="width: 400px; color:#000;" value="' . $componentinfo['RequiredHours'] . '"/>';
						} else {?>
							<input type="text" id="component-requiredhours" style="width: 400px; color:#000;" />
						<?php } ?>
					</p>
					<p>
						<label for="component-duedate"><?php if ($isView == 1) { echo "Due Date"; } else {echo "Select Due Date"; } ?></label>
						<?php
						if ($isView == 1) {
							date_default_timezone_set("Pacific/Auckland");
							//$cdate = date('Y-m-d H:i:s', );
							if($componentinfo['DueDate'] != NULL) {
								$datetime = strtotime($componentinfo['DueDate']);
								$duedate = date("d/m/y g:i A", $datetime); 
							} else {
								$duedate = "";
							}
							echo $duedate;
						} else {
						?>
							<input type="text" id="component-duedate"/>
						<?php } ?>
					</p>
				</div>
			</fieldset>
			<input type="button" value="<?php if ($isView == 1) { echo "Save Changes"; } else {echo "Create Component"; } ?>" id="confirm_btn" style="margin-top:1em;" />
		</div>
		<div id="statusinfo" type="hidden" style="text-align: center;font-size:3em;color: white"></div>
	</form>
</body>