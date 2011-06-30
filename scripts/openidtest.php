<?php
require 'openid.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/scripts/includes/sql_userfunctions.php');
try {
    $openid = new LightOpenID;
    if(!$openid->mode) {
        if(isset($_GET['openid_identifier'])) {
            $openid->identity = $_GET['openid_identifier'];
			// require more information for the user from the openID provider before redirecting to provider
			$openid->required = array('namePerson/friendly', 'contact/email');
            header('Location: ' . $openid->authUrl());
        }
    } elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
		if ($openid->validate()) {
			$email = "";
			$nickname = "";
			// get the passed user info from provider
			$results = $openid->getAttributes();
			// store the identity of the user
			$userOpenID = $openid->identity;
			// make sure that the provider is sending some information because some providers don't.
			if ($results['contact/email'])	$email = $results['contact/email'];
			if ($results['namePerson/friendly'])	$nickname =  $results['namePerson/friendly'];
			
			// check if identity exists first
			$userExist = getUserIdByOpenId($userOpenID);
			if (!empty($userExist)) {
				header("Location: ../user_dashboard.php");
			} else {
				// create new user
				$givenUserID = createUser("", "", $email, "", $nickname, "", "");
				// map user to openID user
				$resultOfMapping = mapOpenID($givenUserID, $userOpenID);
				
				if ($resultOfMapping == true) {
					// redirect openID user to dashboard
					header("Location: ../user_dashboard.php");
				} else {
					// redirect to homepage
					header("Location: ../index.html");
				}
			}
		} else {
			echo "not logged in";
		}
		
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
?>