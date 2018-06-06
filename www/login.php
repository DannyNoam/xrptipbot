<?php

include_once("redirect_to_homepage.php");

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
            <div class="col-sm-12 text">
                <h1>Login</h1>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4" style="background:rgba(0,132,180,0.6); border-radius: 10px; border: 1px solid #000">
                            <a href="/login/twitter" style="text-transform: none; text-decoration: none; font-size: 1em; color: #fff" class="btn btn-block btn-lg">
                                <img src="assets/img/twitter.png" style="max-width: 25px; display: inline-block;">
                                <b>Twitter</b><br>
                                <small>@csctipbot</small>
                            </a>
                        </div>
                        <div class="col-md-4" style="background:rgba(114,137,218,0.6); border-radius: 10px; border: 1px solid #000">
                            <a href="/login/discord" style="text-transform: none; text-decoration: none; font-size: 1em; color: #fff;" class="btn btn-block btn-lg">
                                <img src="assets/img/discord.png" style="max-width: 25px; display: inline-block;">
                                <b>Discord</b><br>
                                <small>@CSCTipBot</small>
                            </a>
                        </div>
                        <div class="col-md-4" style="background:rgba(255, 67, 1,0.6); border-radius: 10px; border: 1px solid #000">
                            <a href="/login/reddit" style="text-transform: none; text-decoration: none; font-size: 1em; color: #fff;" class="btn btn-block btn-lg">
                                <img src="assets/img/reddit.png" style="max-width: 25px; display: inline-block;">
                                <b>Reddit</b><br>
                                <small>@CSCTipBot</small>
                            </a>
                        </div>
                    </div>
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