<?php

	include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/loginService.php');

	$connection = new mysqli($server, $username, $password, $database) or die ('Connection Problem');


?>