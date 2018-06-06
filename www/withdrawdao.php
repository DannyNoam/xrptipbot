<?php

require_once("db.php");
require_once("config.php");

$willExceedWithdrawalLimit = function ($userid, $amount) use ($db, $__WITHDRAWAL_LIMIT, $__WITHDRAWAL_ROLLING_PERIOD_DAYS) {

    try {
        $query = $db->prepare("
                select SUM(amount) as total_amount from withdraw where user = :userid and moment > NOW() - interval :rollingPeriodDays day;
                ");
        $query->bindValue(':userid', $userid);
        $query->bindValue(':rollingPeriodDays', $__WITHDRAWAL_ROLLING_PERIOD_DAYS);
        $query->execute();

        return ($query->fetch(PDO::FETCH_ASSOC)['total_amount'] + $amount) > $__WITHDRAWAL_LIMIT;
    } catch(Exception $e) {
        return "Unknown userid ".$userid;
    }
};

$getBalance = function ($userid) use ($db) {

    try {
        $query = $db->prepare('SELECT `balance` from `user` WHERE userid = :userid');
        $query->bindValue(':userid', $userid);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC)['balance'];
    }
    catch (\Throwable $e) {
        echo "\n ERROR: " . $e->getMessage() . "\n";
    }
};

$getNormalisedBalance = function ($userid) use ($db, $getBalance) {
    return number_format($getBalance($userid), 4);
};

$getSumOfWithdrawals = function () use ($db) {
    try {
        $query = $db->prepare("
                SELECT sum(amount) as total from withdraw;
                ");
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC)['total'];
    } catch(Exception $e) {
        return "Cannot get sum of withdrawals!";
    }
};

?>
