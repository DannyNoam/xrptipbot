<?php

require_once '_bootstrap.php';
require_once '/data/db.php';

echo "\nProcessing TWITTER messages...\n";

try {
    $query = $db->prepare('
        SELECT
          `message`.*,
          `from`.`username` as _from_user_name,
          `from`.`balance` as _from_user_balance,
          `to`.`username` as _to_user_name,
          `to`.`balance` as _to_user_balance
        FROM  `message`
        LEFT JOIN `user` as `from` ON (`from`.`username` = `message`.`from_user` AND `from`.`network` = `message`.`network`)
        LEFT JOIN `user` as `to` ON (`to`.`username` = `message`.`parent_author` AND `to`.`network` = `message`.`network`)
        WHERE
            `processed` < 1 AND
            `message`.`network` = "twitter" AND
            `message`.`from_user` != "casinocointipbot"
        ORDER BY id ASC LIMIT 10
    ');

    $query->execute();
    $msgs = $query->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($msgs)){
        foreach($msgs as $m){
            $is_valid_tip = false;
            $msg = '';
            echo "\n -> " . $m['id'] . ' @ ' . $m['network'] . '...' . "\n";

            if($m['type'] == 'mention'){
                if(empty($m['parent_author'])){
                    // $msg = "Sorry, cannot determine the user you replied to when mentioning me :(";
                    $msg = '';
                }else{
                    if(strtolower($m['parent_author']) == strtolower($m['from_user'])){
                        // $msg = "Sorry @".$m['from_user'].", this didn't work. You replied to a tweet posted by yourself.";
                        $msg = '';
                    }else {
                        $_toParse = html_entity_decode(trim(preg_replace("@[t\r\n ]+@", " ", $m['message'])));
                        preg_match_all("@\+[ <&lgt;\t\r\n]*([0-9,\.]+)[&lgt;> \t\r\n\@\/u]*[\@\/uCSCcsc]*@ms", $_toParse, $match);

                        if(!empty($match[1][0])) {
                            $amount = round( (float) str_replace(",", ".", $match[1][0]), 6);

                            if ((float) $amount > $__MAX_TIP_AMOUNT) {
                                $amount = $__MAX_TIP_AMOUNT;
                            }

                            if(substr_count($amount, '.') > 1) {
                                $msg = '@'.$m['from_user'] . " Sorry, I don't know where the decimal sign and the thousands separators are. Please use only a dot as a decimal sign, and do not use a thousands separator.";
                            }else {
                                if(empty($m['_from_user_name'])){
                                    $msg = '@'.$m['from_user'] . " You cannot send tips untill you deposit some ".'$CSC'." at https://www.xrptipbot.com/deposit ...";
                                }else{

                                    if(empty($m['_to_user_name'])){
                                        // Create TO user
                                        $query = $db->prepare('INSERT IGNORE INTO user (username, create_reason, network) VALUES (:username, "TIPPED", "twitter")');
                                        $query->bindValue(':username', $m['parent_author']);
                                        $query->execute();
                                    }

                                    if($m['_from_user_balance'] < $amount){
                                        $msg = '@'.$m['from_user'].' Awwww... Your Tip Bot balance is too low :( Please deposit some $CSC at https://www.casinocointipbot.com/deposit first and tip @'.$m['parent_author'].' again.';
                                    }else{
                                        if(strtolower($m['parent_author']) == 'casinocointipbot'){
                                            $msg = '@'.$m['from_user'].' Thank you so much! Your donation to me, the one and only $CSC Tip Bot, is very much appreciated!';
                                        }else{
                                            $usdamount = '';
                                            $bid = (float) @json_decode(@file_get_contents('https://www.bitstamp.net/api/v2/ticker_hour/cscusd/', false, @stream_context_create(['http'=>['timeout'=>10]])))->bid;
                                            if(!empty($bid)){
                                                $usdamount = ' (' . number_format($bid * $amount, 2, '.', '') . ' USD)';
                                            }
                                            $msg = '@' . $m['parent_author'] . ' You have received a tip: ' . $amount . ' $CSC' . $usdamount . ' from @' . $m['from_user'] . ' ';
                                            // if(empty($m['_to_user_name'])){
                                                // $msg .= "\n".'(This is the first tip sent to @' . $m['parent_author'] . ' :D)';
                                            // }
                                        }

                                        // Process TIP
                                        $query = $db->prepare('INSERT IGNORE INTO `tip`
                                                                (`amount`, `from_user`, `to_user`, `message`, `sender_balance`, `recipient_balance`, `network`)
                                                                    VALUES
                                                                (:amount, :from, :to, :id, :senderbalance, :recipientbalance, "twitter")
                                        ');

                                        $query->bindValue(':amount', $amount);
                                        $query->bindValue(':from', $m['from_user']);
                                        $query->bindValue(':to', $m['parent_author']);
                                        $query->bindValue(':id', $m['id']);
                                        $query->bindValue(':senderbalance', - $amount);
                                        $query->bindValue(':recipientbalance', + $amount);

                                        $query->execute();

                                        $insertId = (int) @$db->lastInsertId();
                                        $is_valid_tip = true;

                                        if(!empty($insertId)) {
                                            $network = 'twitter';

                                            $query = $db->prepare('UPDATE `user` SET `balance` = `balance` - :amount WHERE username = :from AND `network` = :network LIMIT 1');
                                            $query->bindValue(':amount', $amount);
                                            $query->bindValue(':network', $network);
                                            $query->bindValue(':from', $m['from_user']);
                                            $query->execute();

                                            $query = $db->prepare('UPDATE `user` SET `balance` = `balance` + :amount WHERE username = :to AND `network` = :network LIMIT 1');
                                            $query->bindValue(':amount', $amount);
                                            $query->bindValue(':network', $network);
                                            $query->bindValue(':to', $m['parent_author']);
                                            $query->execute();
                                        }
                                    }
                                }
                            }
                        }else {
                            // $msg  = "<< PARSE MSG, NO MATCH >>: [" . $m['message'] . "] \n";
                            // $msg .= "\n------------------------------------------\n";
                            // $msg = "Sorry, I couldn't find the amount of #XRP to tip... Plase use the format as described in the Howto at https://www.xrptipbot.com/howto";
                            $msg = '';
                        }
                    }
                }
            }else{
                // $msg = "Sorry, I only understand comments (when I am mentioned). For more information check the Howto at https://www.xrptipbot.com/howto or contact the developer of the #XRP Tip Bot, @WietseWind";
                $msg = "";
            }

            if(strtolower($m['parent_author']) == 'xrptipbot' && strtolower($m['to_user']) == 'xrptipbot'){
                // Message to the XRP tip bot, process only if valid tip
                if(!$is_valid_tip){
                    $msg = '';
                }
            }

            echo "      > " . $msg;
            // Sending message ...
            echo "\n--- Sending reply --- ... \n";
            $to_post = $m['from_user']. '/status/' . $m['ext_id'];
            $msg_escaped = str_replace("'", "'\"'\"'", $msg);
            $msg_escaped = trim(preg_replace("@[ \t\r\n]+@", " ", $msg_escaped));
            echo `cd /data/cli/twitter; php send_reaction.php '$to_post' '$msg_escaped'`;
            sleep(2);
        }
    }
}
catch (\Throwable $e) {
    echo "\n ERROR: " . $e->getMessage();
}

echo "\n\n";
