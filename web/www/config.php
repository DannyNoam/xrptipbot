<?php

// For push messaging on transaction sent/received
$__ABLY_CREDENTIAL = 'xxxx:yyyyyyy';

$__MAX_TIP_AMOUNT  = 10000;

// Monitor for transactions (to DB)
$__WALLETS = [
    'rXXXXX',
    'rYYYYY',
    'rQQQQQ',
];

// Allow sending funds
$__SECRETS = [
    'rXXXXX' => 'sQQQQQQ',
    'rYYYYY' => 'sZZZZZZZ',
];

// User & Pass of MySQL database, db 'tipbot', schema: install/db.sql
$__DATABASE = [
    'user' => 'root',
    'pass' => 'Password1',
];

$__REDDIT_USER_AGENT = 'Cli:XrpTipBotScript:v0.0.1 (by /u/xrptipbot)';

$__REDDIT_CLIENT_CONFIG = [
    'clientId'      => 'XXXX',
    'clientSecret'  => 'YYYYYY',
    'redirectUri'   => 'https://www.xrptipbot.com/script',
    'userAgent'     => $__REDDIT_USER_AGENT,
    'scopes'        => [ 'identity', 'edit', 'history', 'mysubreddits', 'privatemessages', 'read', 'report', 'save', 'submit' ]
];

$__TWITTER_CLIENT_CONFIG = [
    'consumerKey'        => 'xxxxx',
    'consumerSecret'     => 'yyyyy',
    'accessToken'        => 'qqqqqq',
    'accessTokenSecret'  => 'xxxxxx'
];

$__TWILIO_CLIENT_CONFIG = [
    'project' => 'xxx',
    'key'     => 'yyy',
    'to'      => '+31xx',
    'from'    => '+32xx'
];

$__DISCORD_BOT = [
    'secret' => 'NDIyODM4MjU2NTE0NjI5NjQz.DYhnxg.0hBQ9XeRq2RjRZWwYoIYSyQbphE',
];

$configJson = json_encode([
    'wallets' => $__WALLETS,
    'secrets' => array_flip($__SECRETS),
    'twilio'  => $__TWILIO_CLIENT_CONFIG,
    'discord' => $__DISCORD_BOT,
]);
file_put_contents('/data/.config.js', $configJson);