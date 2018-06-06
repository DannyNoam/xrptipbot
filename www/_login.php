<?php

include_once 'config.php';
include_once 'db.php';

if(!empty($o_postdata) && !empty($o_postdata['name'])){

    try {
        $query = $db->prepare('
            INSERT IGNORE INTO `user`
                (`username`, `last_login`, `create_reason`, `network`, `userid`)
            VALUES
                (:username, CURRENT_TIMESTAMP, "LOGIN", :network, :userid)
        ');
        $query->bindParam(':userid', $o_postdata['userid']);
        $query->bindParam(':username', $o_postdata['name']);
        $query->bindParam(':network', $o_postdata['type']);
        $query->execute();

        $insertId = (int) @$db->lastInsertId();

        if(empty($insertId)){
            $query = $db->prepare('UPDATE `user` SET `last_login` = CURRENT_TIMESTAMP WHERE `userid` = :userid AND `network` = :network LIMIT 1');
            $query->bindParam(':userid', $o_postdata['userid']);
            $query->bindParam(':network', $o_postdata['type']);
            $query->execute();
        }
    }
    catch (Throwable $e) {
        print_r($e);
    }
}
