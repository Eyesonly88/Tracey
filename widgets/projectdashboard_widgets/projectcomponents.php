<?php

# Widget that displays the components that are a part of a project

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sessions.php');


?>

<!--<script src="/libraries/flexigrid/js/flexigrid.js" type="text/javascript"></script> -->

<script type="text/javascript">
  
	
	var projectid = $('#projectid').val();
	//alert(projectid);
	
	/*
	
	function(data){
          $.each(data.products, function(i,product){
            content = '<p>' + product.product_title + '</p>';
            content += '<p>' + product.product_short_description + '</p>';
            content += '<img src="' + product.product_thumbnail_src + '"/>';
            content += '<br/>';
            $(content).appendTo("#product_list");
          });
	*/
	
	var currentUser = "";
  getCurrentUser();
  initialSetup();
  
 
  function setUser(msg){ 
  	currentUser = msg;	
  }
  
  function setupFlexTable1(){
  	
  	/* Apply datatable library to the list of tables. */
  	$('#componentlist').dataTable({
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
  function initGetComponents(id){
  $.ajax({
  	   cache: "false",
	   type: "POST",
	   url: "/scripts/project/getComponents.php",
	   data: "id="+id,
	   success: function(msg2){
	  
	     $("#componentlist").empty();
	     $("#componentlist").append(msg2);
	     setupFlexTable1();
	     
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
	     initGetComponents(projectid);
	     
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
	
	<h4>Components:</h4>
	<input type="hidden" id="projectid" value=<?php echo $_SESSION['projectid']; ?> />
	<div id="title"></div>
	<table id="componentlist" class="display" ></table>

</div>


	

<BR /><BR />