<?php

session_start();

require_once 'config.php';

$generateAccessToken = function () use ($__HOST) {

    $authCode = $_GET['code'];

    $tokenExchangeUrl = 'https://discordapp.com/api/oauth2/token';

    $data = array(
        'client_id' => 'XXX',
        'client_secret' => 'XXX',
        'grant_type' => 'authorization_code',
        'code' => $authCode,
        'redirect_uri' => $__HOST.'/authorize-discord'
    );

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context = stream_context_create($options);

    try {
        $result = @file_get_contents($tokenExchangeUrl, false, $context);
    } catch(Throwable $e) {
        print_r($e);
    }

    return $result;
};

$generateLoginPayload = function () use ($generateAccessToken) {
    $result = $generateAccessToken();

    $jsonResult = json_decode($result, true);

    $usernameUrl = 'http://discordapp.com/api/users/@me';

    $options = array(
        'http' => array(
            'header' => "Authorization: Bearer " . $jsonResult['access_token'],
            'method' => 'POST'
        )
    );
    $context = stream_context_create($options);
    $result = @file_get_contents($usernameUrl, false, $context);

    $jsonResult = json_decode($result, true);

    return $jsonResult;
};

function authenticationSuccessful($jsonResult) {
    if(!empty($jsonResult)) {
        return true;
    }

    return false;
}

$jsonResult = $generateLoginPayload();

if(authenticationSuccessful($jsonResult)) {

    $o_postdata = array(
        "userid" => $jsonResult['id'],
        "type" => "discord",
        "name" => $jsonResult['username']
    );

    $_SESSION["username"] = $o_postdata["name"];
    $_SESSION["userid"] = $o_postdata["userid"];
    $_SESSION['network'] = "discord";

    include_once("_login.php");
    include_once("index.php");
} else {
    include_once("authentication_failure.php");
}

?>