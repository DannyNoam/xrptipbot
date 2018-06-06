<?php

require_once("db.php");

$getSumOfDeposits = function () use ($db) {
    try {
        $query = $db->prepare("
                SELECT sum(amount) as total from deposit;
                ");
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC)['total'];
    } catch(Exception $e) {
        return "Cannot get sum of deposits!";
    }
};

?>
