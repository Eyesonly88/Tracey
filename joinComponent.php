<?php // Add php scripts here

include_once($_SERVER['DOCUMENT_ROOT'] . '/scripts/includes/sessions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_componentfunctions.php');
confirmLogin();

$componentid = '';
$componentarray = '';
$componentinfo = '';
$success = 0;
if (isset($_GET['id'])) {
	
	$componentid = $_GET['id'];
	$useremail = $_SESSION['email'];
	$componentarray = getComponentInfoById($componentid);
	$componentinfo = $componentarray[0];

	addUserToComponentByEmail($componentid, $useremail);
	$success = 1;
}







?>

<!DOCTYPE html>

<head>
			<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Join Component</title>
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
						<?php if ($success == 1) {
							echo "You are now a member of this component."
							. "<BR />" .
							"Click outside this window to close it.";
							
						} else {
							 echo "something went wrong"; 
						}
						?>
					</p>
				</div>
			</fieldset>
			
		</div>
		
	</form>
</body>