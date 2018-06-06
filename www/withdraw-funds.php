<?php

define('accessible', TRUE);

session_start();

include_once("withdrawdao.php");
require_once('config.php');

$ONLY_WALLET = 0;
$csc_base_fee = 0.01;
$error = "";
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
$network = $_SESSION['network'];
$amount = $_POST['amount'];
$wallet = $_POST['address'];
$tag = $_POST['tag'];
$ipAddress = $_SERVER['REMOTE_ADDR'];
$balance = $getBalance($userid);

if($amount <= 0) {
    returnValidationError("Amount to withdraw cannot be 0 or less!");
} else if($balance < $amount) {
    returnValidationError("Balance is insufficient. Your balance is ".$balance." CSC.");
} else if($amount < $csc_base_fee) {
    returnValidationError("Amount is less than base fee (".$csc_base_fee." CSC).");
} else if($wallet == $__WALLETS[$ONLY_WALLET]) {
    returnValidationError("It is not possible to withdraw to the same originating wallet.");
} else if($amount > $__WITHDRAWAL_LIMIT || $willExceedWithdrawalLimit($userid, $amount)) {
    returnValidationError("The maximum withdrawal amount is ".number_format($__WITHDRAWAL_LIMIT)." CSC every ".$__WITHDRAWAL_ROLLING_PERIOD_DAYS." day(s).");
} else {
    $o_postdata = array(
        "name" => $username,
        "userid" => $userid,
        "type" => $network,
        "amount" => $amount,
        "wallet" => $wallet,
        "tag" => $tag,
        "ip" => $ipAddress
    );

    include_once("_storewithdrawalreq.php");
    include_once("withdrawal-success.php");
}

function returnValidationError($error) {
    include_once("withdrawal-error.php");
}

?>