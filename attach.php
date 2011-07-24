<?php

$uploaded = 0;
$message = array();

foreach($_FILES['attachments']['name'] as $i => $name) {

	if($_FILES['attachments']['error'][$i] == 4) {
		continue ;
	}

	if($_FILES['attachments']['error'][$i] == 0) {
		//print_r($_FILES['attachments']);
		if($_FILES['attachments']['size'][$i] > 5120000) {
			$message[] = "$name exceeded file limit.";
			continue ;
		}
		// checking file extension and transfering to uploads dir.
		if($_FILES["attachments"]["type"][$i] == 'application/pdf' || $_FILES["attachments"]["type"][$i] == 'text/plain' || $_FILES["attachments"]["type"][$i] == 'image/gif' || $_FILES["attachments"]["type"][$i] == 'image/jpeg' || $_FILES["attachments"]["type"][$i] == 'image/png' || $_FILES["attachments"]["type"][$i] == 'application/msword' || $_FILES["attachments"]["type"][$i] == 'application/mspowerpoint' || $_FILES["attachments"]["type"][$i] == 'application/excel' || $_FILES["attachments"]["type"][$i] == 'application/zip' || $_FILES["attachments"]["type"][$i] == 'application/x-rar-compressed' || $_FILES["attachments"]["type"][$i] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $_FILES["attachments"]["type"][$i] == 'application/vnd.openxmlformats-officedocument.presentationml.presentation' || $_FILES["attachments"]["type"][$i] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
			
			$tmp_name = $_FILES["attachments"]["tmp_name"][$i];
			// @TODO use a randomly generated name and link it with a db table.
			$name = $_FILES["attachments"]["name"][$i];
			move_uploaded_file($tmp_name, "uploads/$name");
			$uploaded++;
		}

	}
}

echo $uploaded . ' files uploaded.';

foreach($message as $error) {
	echo $error;
}
?>