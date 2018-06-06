<?php

session_start();

include("menu.html");

echo "Welcome, ".$_SESSION["username"];

?>