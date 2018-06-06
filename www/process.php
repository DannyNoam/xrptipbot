<?php

require_once 'config.php';
require_once 'db.php';

$from = @$_SERVER["argv"][1];
$to = @$_SERVER["argv"][2];
$amount = (float) @$_SERVER["argv"][3];
$toname = @$_SERVER["argv"][4];
$guild = @$_SERVER["argv"][5];

try {
    $query = $db->prepare('
        SELECT *, "from" as type FROM `user` WHERE `network` = "discord" and userid = "'.$from.'" UNION SELECT *, "to" as type FROM `user` WHERE `network` = "discord" and userid = "'.$to.'"
    ');
    $query->execute();
    $usrs = $query->fetchAll(PDO::FETCH_ASSOC);

    if(!empty($usrs)) {
        $ufrom = [];
        $uto = [];
        foreach ($usrs as $u) {
            if($u['type'] == 'from') {
                $ufrom = $u;
            }else{
                $uto = $u;
            }
        }
    }

    if (!empty($ufrom) && $amount > (float) $ufrom['balance']) {
        echo "You don't have enough funds in your Tip Bot account! Deposit at https://www.csctipbot.com/deposit.";
    } else if(empty($ufrom)) {
        echo "Register your Tip Bot account first, visit https://www.csctipbot.com/ and deposit some CSC.";
    } elseif( (float) $ufrom['balance'] == 0) {
        echo "You don't have any CSC in your Tip Bot account, deposit at https://www.csctipbot.com/deposit";
    } elseif( $amount < $__MIN_TIP_AMOUNT) {
        echo "The minimum tip amount is ".$__MIN_TIP_AMOUNT." CSC. Please be more generous :wink:";
    } else if($amount > 0) {
        if(empty($uto)){
            // Create TO user
            $query = $db->prepare('INSERT IGNORE INTO user (username, userid, create_reason, network) VALUES (:username, :userid, "TIPPED", "discord")');
            $query->bindValue(':username', $toname);
            $query->bindValue(':userid', $to);
            $query->execute();
            $uto['balance'] = 0;
        }

        $usdamount = '';
        $bid = (float) @json_decode(@file_get_contents('https://www.nlexch.com:443//api/v2/tickers/cscbtc.json', false, @stream_context_create(['http'=>['timeout'=>4]])))->bid;
        if(!empty($bid)){
            $usdamount = ' (' . number_format($bid * $amount, 2, '.', '') . ' USD)';
        }
        $msg = 'tipped **' . $amount . ' CSC**'.$usdamount.' to <@' . $to . '> :tada:. Withdraw your tip at https://www.csctipbot.com :moneybag:';

        $query = $db->prepare('INSERT IGNORE INTO `tip`
                                (`amount`, `from_user`, `to_user`, `sender_balance`, `recipient_balance`, `network`, `context`)
                                    VALUES
                                (:amount, :from, :to, :senderbalance, :recipientbalance, "discord", :context)
        ');

        $query->bindValue(':amount', $amount);
        $query->bindValue(':from', $from);
        $query->bindValue(':to', $to);
        $query->bindValue(':senderbalance', - $amount);
        $query->bindValue(':recipientbalance', + $amount);
        $query->bindValue(':context', $guild);

        $query->execute();

        $insertId = (int) @$db->lastInsertId();
        $is_valid_tip = true;

        if(!empty($insertId)) {
            $network = 'discord';

            $query = $db->prepare('UPDATE `user` SET `balance` = `balance` - :amount WHERE userid = :from AND `network` = :network LIMIT 1');
            $query->bindValue(':amount', $amount);
            $query->bindValue(':network', $network);
            $query->bindValue(':from', $from);
            $query->execute();

            $query = $db->prepare('UPDATE `user` SET `balance` = `balance` + :amount WHERE userid = :to AND `network` = :network LIMIT 1');
            $query->bindValue(':amount', $amount);
            $query->bindValue(':network', $network);
            $query->bindValue(':to', $to);
            $query->execute();
        }

        echo $msg;

        // echo "\n\n";
        // echo "\n\n";
        // print_r($ufrom);
        // print_r($uto);
        // echo "\n\n";
        // exit;
    }
}
catch (\Throwable $e) {
    // Error
}
