<?php

include 'loginService.php'

# Connect to database server and select tracey database
$connection = mysql_connect($server,$username,$password);

if (!$connection) {
	die("Connection Error: " . mysql_error());
 }


$traceydb = mysql_select_db($database, $connection);
if (!$traceydb) { 
	die("Database Selection Error: " . mysql_error());
}

?>