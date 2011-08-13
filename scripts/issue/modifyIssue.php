<?php 

// Call-back script that accepts ajax POST requests, updates the information in a specified issue.
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_issuefunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_projectfunctions.php');

$issueid = '';
$reporter = '';
$assignee = '';
$issuetype =  '';
$issuestatus = '';
$priority = '';


if (isset($_POST['id'])) {
	$issueid = $_POST['id'];
}

if (isset($_POST['reporter'])) {
	$reporter = $_POST['reporter'];
}

if (isset($_POST['assignee'])) {
	$assignee = $_POST['assignee'];		
}

if (isset($_POST['type'])) {
	$issuetype = $_POST['type'];
}

if (isset($_POST['status'])) {
	$issuestatus = $_POST['status'];
}

if (isset($_POST['priority'])) {
	$priority = $_POST['priority'];	
}

?>