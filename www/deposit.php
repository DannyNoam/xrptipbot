<?php

include_once("redirect_to_login.php");

?>

<!DOCTYPE html>
<html lang="en">

<?php
    include_once("header.html");
?>

<body>

<?php
    include_once("navbar.php")
?>

<!-- Top content -->
<div class="top-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text wow fadeInLeft">
                <h1>Deposit</h1>
                <div class="description">
                    <p class="medium-paragraph">
                        Deposit to the following address (do not forget to add the destination tag):<br /><br />
                        <b>Address: </b><?php require_once("config.php"); echo $__WALLETS[0] ?><br />
                        <b>Destination tag: </b><?php include_once("get_destination_tag.php") ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include_once("feature-container.html");

?>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 footer-copyright">
                &copy; Bootstrap Navbar Template by <a href="http://azmind.com">AZMIND</a>
            </div>
        </div>
    </div>
</footer>


<!-- Javascript -->
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.backstretch.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/retina-1.1.0.min.js"></script>
<script src="assets/js/waypoints.min.js"></script>
<script src="assets/js/scripts.js"></script>

<!--[if lt IE 10]>
<script src="assets/js/placeholder.js"></script>
<![endif]-->

</body>

</html>