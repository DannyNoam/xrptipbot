<?php

    include_once 'config.php';

    try {
      $db = new PDO('mysql:host=mariadb;dbname=CSC_TIPS_DB', 'XXX', 'XXX', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }
    catch (\Throwable $e) {
        print_r($e);
    }
