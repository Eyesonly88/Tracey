<?php

#widget that displays issues assigned to a user

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');


?>
<link rel="stylesheet" href="/libraries/datatables/media/css/demo_table_jui.css" type="text/css">

<!--<script src="/libraries/flexigrid/js/flexigrid.js" type="text/javascript"></script> -->
<script src="/libraries/dataTables/media/js/jquery.dataTables.js" type="text/javascript"></script>
<link rel="stylesheet" href="/libraries/shadowbox/shadowbox.css" type="text/css">
<script src="/libraries/shadowbox/shadowbox.js" type="text/javascript"></script>
<script type="text/javascript">
  
  Shadowbox.init({

   		 	skipSetup: true
  	});
  //$("#viewissue_interface").hide();
  var currentUser = "";
  getCurrentUser();
  initialSetup();
  
  function setUser(msg){ 
  	currentUser = msg;	
  }
  
  function setupFlexTable2(){
  	
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
  	
  	//alert("FUCK!");
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
	      setupHandlers();
	     setupFlexTable2();
	          
	   }
   
 	});
  }
  
  
  function setupHandlers(){
  

   $(".i_viewissue").click(function(){  
   		
   		var issueid = $(this).attr("id");
   		//$("#viewissue_interface").empty();
   		//$("#viewissue_interface").append("<div id='testinterface' >" + issueid + "</div>");
   		$("#viewissue_interface").show();
   		Shadowbox.open({
        	content:    generateIssueInterface(issueid),
        	player:     "html",
        	title:      "View Issue",
        	height:     960,
        	width:     808
    	});
    	

   		//alert(issueid);

   
   });

  }
  
  
  function generateIssueInterface(issueid){ 
  	
  	// UNDER CONSTRUCTION -: get list of users in project, list of components. Make drop down lists based on this.
  	// Also - get default issue values and set them into the form.
  	
  	var id = issueid;
  	
  	var html = '<body>' +	
  		'<div id="viewissue_interface" type="hidden" style="align:left;">'+
	'<div id="issuewrap">'+
			'<h3>Issue: ' + issueid + '</h3>'+
			'<div id="issue-info-container">'+
				'<h3>Issue Information</h3>'+
				'<span >Edit</span>'+
				'<div id="issue-info">'+
					
				'</div>'+
			'</div>'+
			
			'<div id="issue-desc-container">'+
				'<h3>Issue Description</h3>'+
				'<span >Edit</span>'+
				'<div id="issue-desc">'+
					
				'</div>'+
			'</div>'+
			
			'<div id="issue-attach-container">'+
				'<h3>Attached Files</h3>'+
				'<span >Edit</span>'+
				'<div id="issue-attach">'+
					'<form action="attach.php" method="post" enctype="multipart/form-data">'+
					'<p>Allowed file types are: jpg/gif/png, doc/docx, ppt/pptx, xls/xlsx, pdf, txt.<br /><br />'+
					'<input type="file" name="attachments[]" /><br />'+
					'<input type="file" name="attachments[]" /><br />'+
					'<input type="file" name="attachments[]" /><br />'+
					'<input type="file" name="attachments[]" /><br />'+
					'<input type="file" name="attachments[]" />'+
					'<input type="submit" value="Send" /> '+
					'</p>'+
					'</form>'+
				'</div>'+
			'</div>'+
			
			'<div id="issue-comment-container">'+
				'<div id="issue-create-comment">'+
					'<textarea placeholder="Insert your comment here ...">'+

					'</textarea>'+
				'</div>'+
				'<span>Submit Comment</span>'+
			'</div>'+
		'</div> </body>';
  	
  		
  	return html;
  
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



</div>

