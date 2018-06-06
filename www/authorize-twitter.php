<?php

session_start();

require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

require_once 'config.php';

$connection = new TwitterOAuth($__TWITTER_CLIENT_CONFIG['consumerKey'], $__TWITTER_CLIENT_CONFIG['consumerSecret'], $_SESSION['twitter_oauth_token'], $_SESSION['twitter_oauth_token_secret']);

$oAuthVerifier = $_GET['oauth_verifier'];

try {
    $token = $connection->oauth('oauth/access_token', ['oauth_verifier' => $oAuthVerifier]);
    $o_postdata = array(
        "userid" => $token['user_id'],
        "type" => "twitter",
        "name" => $token['screen_name']
    );

    $_SESSION['userid'] = $token['user_id'];
    $_SESSION['username'] = $token['screen_name'];
    $_SESSION['network'] = 'twitter';
    $_SESSION['twitter_oauth_token'] = $token['oauth_token'];
    $_SESSION['twitter_oauth_token_secret'] = $token['oauth_token_secret'];

    include_once("_login.php");
    include_once("index.php");
} catch (Exception $e) {
    include_once("authentication_failure.php");
}

?>