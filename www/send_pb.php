<?php

require_once 'twitter_bootstrap.php';

$to = preg_replace("@[^a-zA-Z0-9_\.-]@", "", (string) @$argv[1]);
$amount = preg_replace("@\.$@", "", preg_replace("@[0]+$@", "", number_format(preg_replace("@[^0-9,\.]@", "", (float) @$argv[2]), 8, '.', '')));

print_r($twitter_call('statuses/update', 'POST', [
    'status' => "@$to Your #CSCTipBot deposit of $amount ".'$CSC'." has been processed. Happy tipping! 🎉 For more information, please visit https://www.csctipbot.com #CasinoCoin",
]));

