<?php

require_once("db.php");

$getUsernameFromUserId = function ($userid, $network) use ($db) {
    try {
        $query = $db->prepare("
                SELECT username from user where userid = :userid and network = :network
                ");
        $query->bindValue(':userid', $userid);
        $query->bindValue(':network', $network);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC)['username'];
    } catch(Exception $e) {
        return "Unknown username";
    }
};

$hasUserLoggedInSinceTipSent = function ($userid, $network, $tipTimestamp) use ($db) {
    try {
        $query = $db->prepare("
                SELECT last_login from user where userid = :userid and network = :network and last_login > :tipTimestamp
                ");
        $query->bindValue(':userid', $userid);
        $query->bindValue(':network', $network);
        $query->bindValue(':tipTimestamp', $tipTimestamp);
        $query->execute();

        $lastLogin = $query->fetch(PDO::FETCH_ASSOC)['last_login'];

        return $lastLogin == null ? "No" : "Yes";
    } catch(Exception $e) {
        return "Unknown username";
    }
};

$getTotalNumberOfUsers = function () use ($db) {
    try {
        $query = $db->prepare("
                SELECT count(userid) as total from user
                ");
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC)['total'];

    } catch(Exception $e) {
        return 0;
    }
};

?>
