<?php

session_start();

require_once 'config.php';

$generateRandomString = function () {
    $length = 10;
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
};

$generateAuthURL = function() use ($__REDDIT_CLIENT_CONFIG, $__HOST, $generateRandomString) {
    $baseURL = "https://www.reddit.com/api/v1/authorize?response_type=code&duration=permanent&scope=identity";
    $redirectURI = $__HOST."/authorize-reddit";
    $state = $generateRandomString();
    $_SESSION['reddit_state'] = $state;

    return $baseURL."&redirect_uri=".$redirectURI."&client_id=".$__REDDIT_CLIENT_CONFIG['clientId']."&state=".$state;
};

header('Location: '.$generateAuthURL());

?>