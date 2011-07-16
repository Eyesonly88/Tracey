<?php 

# Test out functions by including them and executing here.

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_connect.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sanitize.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/headers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/footers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/formfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_commentfn.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_other.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_checks.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_prepared.php');

	echo "<B> TRACEY SANDBOX </B> <BR /><BR />";
	
	//$email = "ttc_rulz@hotmail.com";
	//$result = createProject("test33", $email);	
	
	
	
	global $connection;
	//createProject("SandboxTest1", "ttc_rulz@hotmail.com");
	echo editComment(2,"This is a modified comment yo!");
	//print_r(getAssignedIssuesByEmail("mo@mo.com"));
	echo "<BR /><BR />";
	

	
	
	
/*
<!DOCTYPE html>  
  
<html lang="en">  
<head>  
   <meta charset="utf-8">  
   <title>Tracey Sandbox</title>  
</head>  
<body>  

</body>  
</html>  
*/

?>
