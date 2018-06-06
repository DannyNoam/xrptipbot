<?php

session_start();

if($_SESSION['userid']) {
    include_once("logged_in_index_instructional.php");
} else {
    include_once("logged_out_index_instructional.html");
}

?>