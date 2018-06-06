<?php

require_once("db.php");

$getTotalNumberOfTips = function () use ($db) {
    try {
        $query = $db->prepare("
                SELECT count(*) as total from tip;
                ");
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC)['total'];
    } catch(Exception $e) {
        return "Cannot get total number of tips!";
    }
};

?>
