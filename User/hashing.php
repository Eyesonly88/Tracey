<?php
// i will edit this later and refactor it
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
	for ($i = 0; $i < 1000; $i++;)
	{
		$hash = sha1($hash);
	}
	return $hash;

}

function uniqueSalt(){

	return substr(sha1a(mt_rand()), 0, 22);

}

function checkPass($password){
	
	// get the uniqueSalt from user record
	$hash = sha1($uniqueSalt . $password);
	$hashed = myCrypt($hash);
	
	// get the hased password from user record
	
	// compare $hashed with the hashed password in user record
	
	
	

}

myHash();

?>