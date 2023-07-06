<?php session_start();

include_once('includes/custom-functions.php');
include_once('includes/functions.php');
$function = new custom_functions;

// set time for session timeout
$currentTime = time() + 25200;
$expired = 7200;
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
    <title>ABCD - Reports</title>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <section class="content-header">
            <h1>Reports</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="home.php"> <i class="fa fa-home"></i> Home</a>
                </li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php
                            if($_SESSION['role'] == 'Super Admin'){
                                $join = "WHERE id IS NOT NULL";
                            }
                            else{
                                $refer_code = $_SESSION['refer_code'];
                                $join = "WHERE refer_code REGEXP '^$refer_code'";
                            }
                            $sql = "SELECT id FROM users $join AND today_codes < 800";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num;
                             ?></h3>
                            <p>Users</p>
                        </div>
                        
                        <a href="users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-maroon">
                        <div class="inner">
                        <h3><?php
                            if($_SESSION['role'] == 'Super Admin'){
                                $join = "WHERE id IS NOT NULL";
                            }
                            else{
                                $refer_code = $_SESSION['refer_code'];
                                $join = "WHERE refer_code REGEXP '^$refer_code'";
                            }
                            $sql = "SELECT id FROM users $join AND today_codes BETWEEN 800 AND 1800";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num;
                            ?></h3>
                                <p>Users</p>
                        </div>
                       
                        <a href="users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-teal">
                        <div class="inner">
                        <h3><?php
                            if($_SESSION['role'] == 'Super Admin'){
                                $join = "WHERE id IS NOT NULL";
                            }
                            else{
                                $refer_code = $_SESSION['refer_code'];
                                $join = "WHERE refer_code REGEXP '^$refer_code'";
                            }
                            $sql = "SELECT id FROM users $join AND today_codes>1800";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num;
                            ?></h3>
                                <p>Users</p>
                        </div>
                       
                        <a href="user.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </diV>
       </section>
    </div>
     

               
</body>
</html>