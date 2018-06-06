<?php

session_start();

require_once("db.php");

$userid = $_SESSION['userid'];

try {
    $query = $db->prepare('SELECT `destination_tag` from `user` WHERE userid = :userid');
    $query->bindValue(':userid', $userid);
    $query->execute();

    echo $query->fetch(PDO::FETCH_ASSOC)['destination_tag'];
}
catch (\Throwable $e) {
    echo "\n ERROR: " . $e->getMessage() . "\n";
}

?>

