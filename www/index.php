<?php

session_start();

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
                    <h1>CSC Tip Bot</h1>
                    <div class="description">
                        <p class="medium-paragraph">
                            <?php include_once("index_instructional.php") ?>
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

</body>

</html>