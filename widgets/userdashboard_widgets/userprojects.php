<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');


?>

<!--<link rel="stylesheet" href="/libraries/flexigrid/css/flexigrid.css" type="text/css"> -->

<script src="/widgets/userdashboard_widgets/widgetjs/userprojects.js" type="text/javascript"></script>
<!--<script src="/libraries/flexigrid/js/flexigrid.js" type="text/javascript"></script> -->



<script type="text/javascript">
  
  var currentUser = "";
  getCurrentUser();
  initialSetup();
 
  function setUser(msg){ 
  	currentUser = msg;	
  }
  
  function setupFlexTable(){
  	
  	/* Apply datatable library to the list of tables. */
  	$('#projectlist').dataTable({
  		
  		"bJQueryUI": true,
  		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": true,
		"bSort": true,
		"bInfo": false,
		"bAutoWidth": false,
		"bStateSave": true, 
		"bDestroy": true,
		"bDeferRender": true,
		"oSearch": {"sSearch": ""}
  	
  	});
  	//$("#projectlist").fnDraw();
  }
  
  
  /* Get list of projects created by the user (via Ajax) */
  function getUserProjects(user){
  	$.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/userdashboard/getCreatedProjects.php",
	   data: "email="+user,
	   success: function(msg2){
	     $("#projectlist").empty();
	     $("#projectlist").append(msg2);
	     setupFlexTable();
	     
	     $("#goto_project").click(function() { 
	     	

	     	$(this).html('<input type="button" style="width:100px; height:35px; border-width:1px;" value="Redirecting..." />');
	     	return false;
	     });
	   }
   
 	});
  }
  
  /* Get the currently logged in user */
  function getCurrentUser(){
  	$.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/authentication/getCurrentUser.php",
	   success: function(msg){
	     setUser(msg);
	   }
   
 	});
  }
  
  /* This is the initial function call that is executed when the widget is ready. 
 	Sets up the initial list of projects. */
  function initUserProjects(user){
  $.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/userdashboard/getCreatedProjects.php",
	   data: "email="+user,
	   success: function(msg2){
	     $("#projectlist").empty();
	     $("#projectlist").append(msg2);
	     setupFlexTable();
	     
	     $(".p_dashboard_button").click(function() { 
	     	
	     	$(this).empty();
	     	$(this).append("Redirecting...");
	     
	     });
	   }
   
 	});
  }
  
  /* The first initial function call, which calls 2 other 
 	functions to set up the initial state of the widget*/
  function initialSetup() {
  $.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/authentication/getCurrentUser.php",
	   success: function(msg){
	     setUser(msg);
	     initUserProjects(msg);
	     
	   }
   
 	});
 }
	
</script>

<style>
  h5 span {
    color:#666666;
    float:right;
    font-size:0.8em;
    font-weight: normal;
  }

  h5 {
    border-top:1px solid #DDDDDD;
    border-bottom:1px solid #DDDDDD;
    color:#222222;
    padding-left:3px;
    padding-right:3px;
    margin-top:3px;
    margin-bottom:3px;
    background-color:#eeeeee;
  }
  .default {
    font-style:italic;
  }
  .default-value {
    font-size:80%;
  }
  pre {
    border: 1px dashed #aaaaaa;
    padding:5px;
    margin-top:5px;
    margin-bottom:5px;
  }

</style>

<div id="contents">
<div id="title"></div>
<table id="projectlist" class="display" ></table>
	
</div>

