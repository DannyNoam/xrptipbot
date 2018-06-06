<?php

include_once("redirect_to_login.php");

?>

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
                <h1>Withdraw</h1>
                <div class="description">
                    <p class="medium-paragraph">
                        To withdraw your CSC, please fill in the following fields and submit. The withdrawal should
                        not take more than a few minutes.<br /><br />
                    <form method="post" action="/withdraw-funds" autocomplete="off">
                        <input autofocus="" required="required" class="form-control" type="text" id="amount" placeholder="Amount of CSC to withdraw" name="amount" value="<?php include_once("withdrawdao.php"); echo $getBalance($_SESSION['userid']) ?>">
                        <input autofocus="" required="required" class="form-control" type="text" id="address" placeholder="The wallet address to withdraw to, e.g. cDarPNJEpCnpBZSfmcquydockkePkjPGA2" name="address">
                        <input autofocus="" class="form-control" type="number" id="tag" placeholder="Destination tag if it's required, e.g. 1469" name="tag">
                        <button type="submit" class="btn btn-lg btn-block btn-primary">
                            <i class="fa fa-send"></i>
                            Withdraw
                        </button>
                        <br />
                        <div class="alert alert-info" role="alert">
                            <b>Please note:</b> You can withdraw up to a maximum of <?php include_once("config.php"); echo number_format($__WITHDRAWAL_LIMIT) ?> CSC every 24 hours.
                        </div>
                    </form>
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