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
                <h1>Account Overview</h1>
                <div class="description">
                    <p class="medium-paragraph">
                        Your balance is: <b><?php include_once("withdrawdao.php"); echo $getNormalisedBalance($_SESSION["userid"]) ?> CSC</b>
                    </p>
                    <div class="col-sm-6">
                        <h4>Tips Sent</h4>
                        <table id="tipsto" class="table cell-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="style="border-left: 1px solid #000">Timestamp</th>
                                    <th>Amount (CSC)</th>
                                    <th>To</th>
                                    <th>Claimed</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                session_start();

                                require_once("db.php");
                                require_once("userdao.php");

                                try {
                                $query = $db->prepare("
                                  SELECT * from tip where from_user = :userid and network = :network
                                ");
                                $query->bindValue(':userid', $_SESSION['userid']);
                                $query->bindValue(':network', $_SESSION['network']);
                                $query->execute();
                                while($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                ?>
                                <tr>
                                    <td><?php echo $row['moment'] ?></td>
                                    <td><?php echo $row['amount']?></td>
                                    <td><?php echo empty($getUsernameFromUserId($row['to_user'], $_SESSION['network'])) ? "Unknown" : $getUsernameFromUserId($row['to_user'], $_SESSION['network']) ?></td>
                                    <td><?php echo $hasUserLoggedInSinceTipSent($row['to_user'], $_SESSION['network'], $row['moment']) ?></td>
                                </tr>
                                <?php }}catch (\Throwable $e) {
                                    echo "\n ERROR: " . $e->getMessage() . "\n";
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <h4>Tips Received</h4>
                        <table id="tipsfrom" class="table cell-border" style="width:100%">
                            <thead>
                            <tr>
                                <th style="border-left: 1px solid #000">Timestamp</th>
                                <th>Amount (CSC)</th>
                                <th>From</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            session_start();

                            require_once("db.php");
                            require_once("userdao.php");

                            try {
                                $query = $db->prepare("
                                  SELECT * from tip where to_user = :userid and network = :network
                                ");
                                $query->bindValue(':userid', $_SESSION['userid']);
                                $query->bindValue(':network', $_SESSION['network']);
                                $query->execute();
                                while($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                    ?>
                                    <tr>
                                        <td><?php echo $row['moment'] ?></td>
                                        <td><?php echo $row['amount']?></td>
                                        <td><?php echo empty($getUsernameFromUserId($row['from_user'], $_SESSION['network'])) ? "Unknown" : $getUsernameFromUserId($row['from_user'], $_SESSION['network']) ?></td>
                                    </tr>
                                <?php }}catch (\Throwable $e) {
                                echo "\n ERROR: " . $e->getMessage() . "\n";
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 text wow fadeInLeft">
                <div class="col-sm-6">
                    <h4>Deposits</h4>
                    <table id="deposits" class="table cell-border" style="width:100%">
                        <thead>
                        <tr>
                            <th style="border-left: 1px solid #000">Timestamp</th>
                            <th>Amount (CSC)</th>
                            <th>Transaction</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        session_start();

                        require_once("db.php");
                        require_once("userdao.php");

                        try {
                            $query = $db->prepare("
                                  SELECT * from deposit where user = :userid and network = :network
                                ");
                            $query->bindValue(':userid', $_SESSION['userid']);
                            $query->bindValue(':network', $_SESSION['network']);
                            $query->execute();
                            while($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                ?>
                                <tr>
                                    <td><?php echo $row['moment'] ?></td>
                                    <td><?php echo $row['amount']?></td>
                                    <td><a href="https://explorer.casinocoin.org/tx/<?php echo $row['tx']?>"><?php echo substr($row['tx'], 0, 12) ?>...</a></td>
                                </tr>
                            <?php }}catch (\Throwable $e) {
                            echo "Could not get transactions for user ".$_SESSION['username'];
                        } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6">
                    <h4>Withdrawals</h4>
                    <table id="withdrawals" class="table cell-border" style="width:100%">
                        <thead>
                        <tr>
                            <th style="border-left: 1px solid #000">Timestamp</th>
                            <th>Amount (CSC)</th>
                            <th>Transaction</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        session_start();

                        require_once("db.php");
                        require_once("userdao.php");

                        try {
                            $query = $db->prepare("
                                  SELECT * from withdraw where user = :userid and network = :network
                                ");
                            $query->bindValue(':userid', $_SESSION['userid']);
                            $query->bindValue(':network', $_SESSION['network']);
                            $query->execute();
                            while($row = $query->fetch(PDO::FETCH_ASSOC)) {

                                ?>
                                <tr>
                                    <td><?php echo $row['moment'] ?></td>
                                    <td><?php echo $row['amount']?></td>
                                    <td><a href="https://explorer.casinocoin.org/tx/<?php echo $row['tx']?>"><?php echo substr($row['tx'], 0, 12) ?>...</a></td>
                                </tr>
                            <?php }}catch (\Throwable $e) {
                            echo "\n ERROR: " . $e->getMessage() . "\n";
                        } ?>
                        </tbody>
                    </table>
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

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>

<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/assets/css/datatable.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css" type="text/css">


<script>
  $(function(){
    var config = {searching: false, "lengthChange": false, "pagingType": "simple", "pageLength": 5, "order": [[0, 'desc']], responsive: true, columnDefs: [
      { responsivePriority: 1, targets: -1 },
      { responsivePriority: 2, targets: -2 },
      { responsivePriority: 3, targets: -3 },
      { responsivePriority: 4, targets: 0 }
    ]};
    var tableNames = ['tipsto', 'tipsfrom', 'deposits', 'withdrawals'];
    for(var i in tableNames) {
      $("#"+tableNames[i]).dataTable(config);
    }
  })
</script>

</html>