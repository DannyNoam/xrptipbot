<?php

require "twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

require_once 'config.php';

echo "Logging in with Twitter...";

if(!function_exists('twitter_call')){
    $twitter_call = function ($url = 'statuses/home_timeline', $method = 'GET', $data = [], $json_data = []) use ($__TWITTER_CLIENT_CONFIG) {
        $connection = new TwitterOAuth(
            $__TWITTER_CLIENT_CONFIG['consumerKey'],
            $__TWITTER_CLIENT_CONFIG['consumerSecret'],
            $__TWITTER_CLIENT_CONFIG['accessToken'],
            $__TWITTER_CLIENT_CONFIG['accessTokenSecret']
        );

        $method = strtolower($method);

        return $connection->$method($url, $data, $json_data);
    };
}
