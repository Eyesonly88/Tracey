<?php

#widget that displays issues assigned to a user

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');


?>
<link rel="stylesheet" href="/libraries/datatables/media/css/demo_table_jui.css" type="text/css">
<!--<script src="/libraries/flexigrid/js/flexigrid.js" type="text/javascript"></script> -->
<script src="/libraries/dataTables/media/js/jquery.dataTables.js" type="text/javascript"></script>
<script type="text/javascript">
  
 
  var currentUser = "";
  getCurrentUser();
  initialSetup();
  
  function setUser(msg){ 
  	currentUser = msg;	
  }
  
  function setupFlexTable(){
  	
  	/* Apply datatable library to the list of tables. */
  	$('#issuelist').dataTable({
  		
  		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": true,
		"bSort": false,
		"bInfo": false,
		"bAutoWidth": false,
		"bStateSave": true, 
		"bDestroy": true,
		"oSearch": {"sSearch": ""}
  	
  	});
  	//$("#projectlist").fnDraw();
  }
  
  /* Creates a project (via Ajax) */
 

  
  
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
  function initUserIssues(email){
  
  $.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/userdashboard/getAssignedIssues.php",
	   data: "email="+email,
	   success: function(msg2){
	  
	     $("#issuelist").empty();
	     $("#issuelist").append(msg2);
	     setupFlexTable();
	     
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
	     initUserIssues(msg);
	    
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

<div id="contents"><h4>Issues:</h4>

	<table id="issuelist" class="display" ></table>
</div>
