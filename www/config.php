<?php

$__HOST = 'http://176.16.1.80:1450';

// For push messaging on transaction sent/received
$__ABLY_CREDENTIAL = 'xxxx:yyyyyyy';

$__MAX_TIP_AMOUNT  = 5000;
$__MIN_TIP_AMOUNT = 1;
$__WITHDRAWAL_LIMIT = 50000;
$__WITHDRAWAL_ROLLING_PERIOD_DAYS = 1;

// Monitor for transactions (to DB)
$__WALLETS = [
    'XXX'
];

// Allow sending funds
$__SECRETS = [
    'XXX' => 'XXX'
];

// User & Pass of MySQL database, db 'tipbot', schema: install/db.sql
$__DATABASE = [
    'user' => 'XXX',
    'pass' => 'XXX',
];

$__REDDIT_USER_AGENT = 'CSCTipBot:1.0.0 (by /u/whufc4life1)';

$__REDDIT_CLIENT_CONFIG = [
    'clientId'      => 'XXX',
    'clientSecret'  => 'XXX',
    'redirectUri'   => $__HOST.'/authorize-reddit',
    'userAgent'     => $__REDDIT_USER_AGENT,
    'scopes'        => [ 'identity', 'edit', 'history', 'mysubreddits', 'privatemessages', 'read', 'report', 'save', 'submit' ],
    'oauth2token'   =>
];

$__TWITTER_CLIENT_CONFIG = [
    'consumerKey'        => 'XXX',
    'consumerSecret'     => 'XXX',
    'accessToken'        => 'XXX',
    'accessTokenSecret'  => 'XXX'
];

$__TWILIO_CLIENT_CONFIG = [
    'accountSid' => 'XXX',
    'authToken'     => 'XXX',
    'to'      => 'XXX',
    'from'    => 'XXX'
];

$__DISCORD_BOT = [
    'secret' => 'XXX',
];

$configJson = json_encode([
    'wallets' => $__WALLETS,
    'secrets' => array_flip($__SECRETS),
    'twilio'  => $__TWILIO_CLIENT_CONFIG,
    'discord' => $__DISCORD_BOT,
]);