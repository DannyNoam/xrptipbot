<?php

require_once 'reddit_bootstrap.php';

$to = preg_replace("@[^a-zA-Z0-9_\.-]@", "", (string) @$argv[1]);
$amount = preg_replace("@\.$@", "", preg_replace("@[0]+$@", "", number_format(preg_replace("@[^0-9,\.]@", "", (float) @$argv[2]), 8, '.', '')));

print_r($reddit_call('/api/compose', 'POST', [
    'api_type' => 'json',
    'to' => $to,
    'subject' => 'Deposit of CSC confirmed :)',
    'text' => "Your deposit of **$amount CSC** just came through :D\n\nGreat! Happy tipping.\n\nMore info: https://www.casinocointipbot.com/howto",
]));

