<?php session_start();

include_once('includes/custom-functions.php');
include_once('includes/functions.php');
$function = new custom_functions;

// set time for session timeout
$currentTime = time() + 25200;
$expired = 3600;
// if session not set go to login page
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}
// if current time is more than session timeout back to login page
if ($currentTime > $_SESSION['timeout']) {
    session_destroy();
    header("location:index.php");
}
// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;

include "header.php";
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ABCD - Dashboard</title>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Home</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="home.php"> <i class="fa fa-home"></i> Home</a>
                </li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php
                            $sql = "SELECT * FROM users";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num;
                             ?></h3>
                            <p>Users</p>
                        </div>
                        <div class="icon"><i class="fa fa-user"></i></div>
                        <a href="users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                        <h3><?php
                            $sql = "SELECT * FROM admin";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num;
                             ?></h3>
                            <p>Admins</p>
                        </div>
                        <div class="icon"><i class="fa fa-user"></i></div>
                        <a href="admins.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                        <h3><?php
                            $sql = "SELECT * FROM tyre_products";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num;
                             ?></h3>
                            <p>Tyre Products</p>
                        </div>
                        <div class="icon"><i class="fa fa-cubes"></i></div>
                        <a href="tyre_products.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div> -->
                <!-- <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                        <h3><?php
                            $sql = "SELECT * FROM showroom";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num;
                             ?></h3>
                            <p>Showrooms</p>
                        </div>
                        <div class="icon"><i class="fa fa-map"></i></div>
                        <a href="showrooms.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div> -->
            </div>
        </section>
    </div>
    <script>
        $('#filter_order').on('change', function() {
            $('#orders_table').bootstrapTable('refresh');
        });
        $('#seller_id').on('change', function() {
            $('#orders_table').bootstrapTable('refresh');
        });
    </script>
    <script>
        function queryParams(p) {
            return {
                "filter_order": $('#filter_order').val(),
                "seller_id": $('#seller_id').val(),
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                search: p.search
            };
        }

    </script>
    <?php include "footer.php"; ?>
</body>
</html>