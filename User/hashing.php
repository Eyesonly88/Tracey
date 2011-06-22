<?php
function myHash($password){
	
	$uniqueSalt = uniqueSalt();
	// store unique salt into user record
	$hash = sha1($uniqueSalt . $password);
	
	$hashed_p = myCrypt($hash);
	// store hashed password into user record
}

function myCrypt($hash){

	// hash it 1000 times so it takes more time for attackers
	// to build a rainbow table
	for ($i = 0; $i < 1000; $i++){
		$hash = sha1($hash);
	}
	return $hash;

}

function uniqueSalt(){

	return substr(sha1(mt_rand()), 0, 22);

}



function checkPass($password, $email){
	
	// get the uniqueSalt from user record
	
	$hash = sha1($uniqueSalt . $password);
	$hashed = myCrypt($hash);
	
	// get the hased password from user record
	
	// compare $hashed with the hashed password in user record

}

function get_user_salt($email){
	global $connection;
	$query = $connection->stmt_init();
	$sql_stmnt = "SELECT Salt FROM User WHERE Email = ?";
	if ($query->prepare($sql_stmnt)) {
		
		$query -> bind_param("s", $em);
		$em = $email;		
		$results = dynamicBindResults($query);
		print_r($results);
		
	}	
	
}
?>