<?php

if(!empty($o_postdata) && is_object($o_postdata)){

    try {

        $query = $db->prepare('SELECT * FROM user WHERE (`destination_wallet` = :wallet AND `destination_tag` = :tag) LIMIT 1');
        $query->bindParam(':wallet', $o_postdata->to);
        $query->bindParam(':tag', $o_postdata->tag);
        $query->execute();
        $depositTo = $query->fetch(PDO::FETCH_ASSOC);

        if(!empty($depositTo)){
            // User matched, deposit can be processed
            $channel = substr(md5($depositTo['username'].$depositTo['destination_tag'].$depositTo['network']),0,20);
            $json['channel'] = $channel;

            $query = $db->prepare('
                INSERT IGNORE INTO `deposit`
                    (`tx`, `from_wallet`, `to_wallet`, `destination_tag`, `user`, `ledger`, `amount`, `balance_pre`, `balance_post`, `network`, `type`)
                VALUES
                    (:tx, :from_wallet, :to_wallet, :destination_tag, :user, :ledger, :amount, :balance_pre, :balance_post, :network, :type)
            ');

            $newBalance = ((float) $depositTo['balance']) + ((float) $o_postdata->csc);

            $type = 'tx';
            if (!empty($o_postdata->type)) {
                $type = $o_postdata->type;
            }

            $query->bindParam(':tx', $o_postdata->hash);
            $query->bindParam(':from_wallet', $o_postdata->from);
            $query->bindParam(':to_wallet', $o_postdata->to);
            $query->bindParam(':destination_tag', $o_postdata->tag);
            $query->bindParam(':user', $depositTo['userid']);
            $query->bindParam(':ledger', $o_postdata->ledger);
            $query->bindParam(':amount', $o_postdata->csc);
            $query->bindParam(':balance_pre', $depositTo['balance']);
            $query->bindParam(':balance_post', $newBalance);
            $query->bindParam(':network', $depositTo['network']);
            $query->bindParam(':type', $type);
            $query->execute();
            $txInsertId = (int) $db->lastInsertId();

            if($txInsertId > 0){

                $json['txId'] = $txInsertId;

                /* - - - - - - - - - - - - - - - - - - - - - - - - */

                /**
                 * UPDATE THE BALANCE
                 **/
                $query = $db->prepare('
                    UPDATE `user` SET `balance` = (`balance` + :amount) WHERE `userid` = :user AND `network` = :network LIMIT 1
                ');
                $query->bindParam(':user', $depositTo['userid']);
                $query->bindParam(':network', $depositTo['network']);
                $query->bindParam(':amount', $o_postdata->csc);
                $query->execute();

                echo "Updated balance";
                /**
                 * END -- UPDATE THE BALANCE
                 **/

                /* - - - - - - - - - - - - - - - - - - - - - - - - */

                /**
                 * SEND ABLY NOTIFICATION
                 **/
                $postdata = [ 'name' => 'deposit', 'data' => json_encode([
                    'txInsertId' => $txInsertId,
                    'amount' => preg_replace("@\.$@", "", preg_replace("@[0]+$@", "", number_format((float) $o_postdata->csc, 8, '.', ''))),
                    'user' => $depositTo,
                    'transaction' => $o_postdata,
                ])];

                $context = stream_context_create([ 'http' => [ 'method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => http_build_query($postdata) ] ]);
                $result = @file_get_contents('https://'.$__ABLY_CREDENTIAL.'@rest.ably.io/channels/'.$channel.'/messages', false, $context);
                /**
                 * END -- SEND ABLY NOTIFICATION
                 **/

                /* - - - - - - - - - - - - - - - - - - - - - - - - */

                /**
                 * SEND PB TO USER
                 **/

                // TODO: Activate for all users

                $pb_to = $depositTo['userid'];
                $pb_amount = $o_postdata->csc;

                if ($depositTo['network'] == 'reddit') {
                    $sent_pb = @`cd /data/cli/reddit/; php send_pb.php "$pb_to" "$pb_amount"`;
                }
                /**
                 * END -- SEND ABLY NOTIFICATION
                 **/
            }
        }
    }
    catch (\Throwable $e) {
        $json['error'] = true;
        // TODO: remove debug info {DEVDEVDEV}
        // $json['processDeposit'] = $e->getMessage();
    }
}