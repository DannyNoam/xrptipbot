<?php

session_start();

require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

require_once 'config.php';

$connection = new TwitterOAuth($__TWITTER_CLIENT_CONFIG['consumerKey'], $__TWITTER_CLIENT_CONFIG['consumerSecret']);

$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => $__HOST . "/authorize-twitter"));

$_SESSION['twitter_oauth_token'] = $request_token['oauth_token'];
$_SESSION['twitter_oauth_token_secret'] = $request_token['oauth_token_secret'];

$url = $connection->url('oauth/authenticate', array('oauth_token' => $request_token['oauth_token']));

header('Location: '.$url);

?>