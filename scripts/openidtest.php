<?php
require 'openid.php';
try {
    $openid = new LightOpenID;
    if(!$openid->mode) {
        if(isset($_GET['openid_identifier'])) {
            $openid->identity = $_GET['openid_identifier'];
            header('Location: ' . $openid->authUrl());
        }
    } elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
?>