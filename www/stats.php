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
                <h1>Stats</h1>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php require_once("userdao.php"); echo $getTotalNumberOfUsers() ?></div>
                                        <div>Users registered</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-commenting-o fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php require_once("tipdao.php"); echo number_format($getTotalNumberOfTips()) ?></div>
                                        <div>Tips processed</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="glyphicon glyphicon-piggy-bank fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div style="font-size:30px"><?php require_once("depositdao.php"); echo number_format($getSumOfDeposits()) ?></div>
                                        <div>Deposited (CSC)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-credit-card fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div style="font-size:30px"><?php require_once("withdrawdao.php"); echo number_format($getSumOfWithdrawals()) ?></div>
                                        <div>Withdrew (CSC)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div id="pie-placeholder" class="flot"></div>
                    </div>
                </div>
            </div>
            <!-- /#page-wrapper -->
        </div>
    </div>
</div>

<?php

include_once("feature-container.html");

?>

<script>
  var data = [{
    label: "Twitter",
    data: 500
  }, {
    label: "Discord",
    data: 450
  }];

  var options = {
    series: {
      pie: {
        show: true,
        radius: 1,
        label: {
          show: true,
          radius: 0.8,
          threshold: 0.1
          //formatter: "labelFormatter"
        }
      }
    },
    grid: {
      hoverable: true
    },
    tooltip: true,
    tooltipOpts: {
      cssClass: "flotTip",
      content: "%p.0%, %s",
      shifts: {
        x: 20,
        y: 0
      },
      defaultTheme: false
    },
    legend: { show: false }
  };

  $.plot($("#pie-placeholder"), data, options);
</script>

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