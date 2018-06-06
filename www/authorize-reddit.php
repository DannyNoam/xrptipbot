<?php

session_start();

require_once 'config.php';

$generateBasicAuthToken = function ($clientId, $clientSecret) {
    return "Basic ".base64_encode($clientId.":".$clientSecret);
};

if(isset($_REQUEST['state'])) {
    if($_REQUEST['state'] != $_SESSION['reddit_state']) {
        include_once("authentication_failure.php");
    }
} else {
    include_once("authentication_failure.php");
}

$code = $_GET['code'];
$client_id = $__REDDIT_CLIENT_CONFIG['clientId'];
$client_secret = $__REDDIT_CLIENT_CONFIG['clientSecret'];

$access_token_url = "https://www.reddit.com/api/v1/access_token";
$options = array(
    'http' => array(
        'method' => 'POST',
        'header' => "User-Agent: ".$__REDDIT_CLIENT_CONFIG['userAgent']."\r\n" .
            "Content-Type: application/x-www-form-urlencoded\r\n" .
            "Authorization: ".$generateBasicAuthToken($client_id, $client_secret)."\r\n",
        'content' => 'grant_type=authorization_code&redirect_uri=http://176.16.1.80:1450/authorize-reddit&code='.$code
    )
);

$context = stream_context_create($options);
$result = file_get_contents($access_token_url, false, $context);

$jsonResult = json_decode($result, true);

if(!isset($jsonResult->error)) {

    $headers = array(
        'http' => array(
            'method' => 'GET',
            'header' => "User-Agent: ".$__REDDIT_CLIENT_CONFIG['userAgent']."\r\n" .
                "Authorization: bearer ".$jsonResult['access_token']."\r\n",
        )
    );
    $ctx = stream_context_create($headers);
    $result = file_get_contents("https://oauth.reddit.com/api/v1/me.json", false, $ctx);
    $jsonResult = json_decode($result);
    $username = $jsonResult->name;
    $user_id = $jsonResult->id;

    $o_postdata = array(
        "userid" => $user_id,
        "type" => "reddit",
        "name" => $username
    );

    $_SESSION["username"] = $o_postdata["name"];
    $_SESSION["userid"] = $o_postdata["userid"];
    $_SESSION['network'] = "reddit";

    include_once("_login.php");
    include_once("index.php");
} else {
    include_once("authentication_failure.php");
}
?>