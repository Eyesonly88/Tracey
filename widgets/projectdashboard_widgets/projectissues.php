<?php

#widget that displays issues related to a project

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');


?>
<head>
<link rel="stylesheet" href="/libraries/datatables/media/css/demo_table_jui.css" type="text/css">
<!--<script src="/libraries/flexigrid/js/flexigrid.js" type="text/javascript"></script> -->
<script src="/libraries/dataTables/media/js/jquery.dataTables.js" type="text/javascript"></script>
<link rel="stylesheet" href="/libraries/shadowbox/shadowbox.css" type="text/css">
<script src="/libraries/shadowbox/shadowbox.js" type="text/javascript"></script>
<script type="text/javascript">
  
  
   Shadowbox.init({

   		displayNav: "false",
   		displayCounter: "false"
  	});
  	Shadowbox.clearCache();
  
  $('#hiddencontents_issue').hide();
  
  var issuehtml = $('#hiddencontents_issue').html();
  //alert(issuehtml);
  var projectid = $('#projectid').val();
  var currentUser = "";
  getCurrentUser();
  initialSetup();
  
  $('.project_submit').click(function(){ 
  	createProject();
  })
  function setUser(msg){ 
  	currentUser = msg;	
  }
  
  function setupFlexTable2(){
  	
  	/* Apply datatable library to the list of tables. */
  	$('#projectlist2').dataTable({
  		
  		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": true,
		"bSort": true,
		"bInfo": false,
		"bAutoWidth": false,
		"bStateSave": true, 
		"bDestroy": true,
		"oSearch": {"sSearch": ""}
  	
  	});
  	//$("#projectlist").fnDraw();
  }
  
  /* Creates a project (via Ajax) */
 
  function setupHandlers(){
  

   /*$(".i_p_viewissue").click(function(){  
   		
   		var issueid = $(this).attr("id");
   		
   		var issueJS = "<script type=text/javascript>"+ 
   				"$('#btn_saveissue').click(function() {"+
		
					"alert('hi');"+
				"});"+
   		"</scr" + "ipt>";
   	
   		//todo: Set up all the handlers in the hidden issue interface, before showing it on the lightbox.
   		$('#issuenum').empty();
   		$('#issuenum').append('<h3>Issue: ' + issueid + '</h3>');
   		
   		issueobj = $('#hiddencontents_issue');
   		issuehtml = issueobj.html();
   		
   		issueinterface = issueJS + "<body>" + issuehtml + "<button id='btn_saveissue'>Hello there.</button>" + "</body>";
   		Shadowbox.open({
        	//content:    generateIssueInterface(issueid),
        	content:	issueinterface,
        	player:     "html",
        	title:      "View Issue",
        	height:     960,
        	width:     808
    	});*/
    	
    	//alert (issueinterface);
    	
		//$('#btn_saveissue').click(function() { 
		
			//alert("SUP!!!!!!");
		//});
   		//alert(issueid);
   //});

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
  function initUserProjects(id){
  $.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/project/getProjectIssues.php",
	   data: "id="+id,
	   success: function(msg2){
	  
	     $("#projectlist2").empty();
	     $("#projectlist2").append(msg2);
	     setupHandlers();
	     setupFlexTable2();
	     
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
	     initUserProjects(projectid);
	     
	   }
   
 	});
 }
  



</script>
</head>
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
	<input type="hidden" id="projectid" value=<?php echo $_SESSION['projectid']; ?> />
	<div id="title"></div>
	<table id="projectlist2" class="display" ></table>
</div>




