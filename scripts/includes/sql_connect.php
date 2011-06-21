<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/loginService.php');

# Connect to database server and select tracey database
global $connection;

$connection = new mysqli($server, $username, $password, $database) or die ('Connection Problem');
#$connection = mysql_connect($server,$username,$password);

/*
if (!$connection) {
	die("Connection Error: " . mysql_error());
 }


$traceydb = mysql_select_db($database, $connection);
if (!$traceydb) { 
	die("Database Selection Error: " . mysql_error());
}*/

?>