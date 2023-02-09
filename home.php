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
                            $sql = "SELECT id FROM users $join";
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
                    <div class="small-box bg-aqua">
                        <div class="inner">
                        <h3><?php
                            $currentdate = date('Y-m-d');
                            if($_SESSION['role'] == 'Super Admin'){
                                $join = "WHERE status=1 AND code_generate = 1 AND today_codes != 0";
                            }
                            else{
                                $refer_code = $_SESSION['refer_code'];
                                $join = "WHERE status=1 AND code_generate = 1 AND refer_code REGEXP '^$refer_code' AND today_codes != 0 ";
                            }
                            $sql = "SELECT id FROM users $join";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num;
                             ?></h3>
                            <p>Active Users</p>
                        </div>
                        
                        <a href="users.php?activeusers=1" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <?php
                if($_SESSION['role'] == 'Super Admin'){?>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3><?php
                                $currentdate = date('Y-m-d');
                                $sql = "SELECT SUM(codes) AS today_codes FROM transactions WHERE DATE(datetime) = '$currentdate'";
                                $db->sql($sql);
                                $res = $db->getResult();
                                echo $res[0]['today_codes'];
                                ?></h3>
                                <p>Users Today Codes</p>
                        </div>
                        
                        <a href="users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <?php } ?>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3><?php
                            if($_SESSION['role'] == 'Super Admin'){
                                $join = "WHERE id IS NOT NULL AND task_type='champion'";
                            }
                            else{
                                $refer_code = $_SESSION['refer_code'];
                                $join = "WHERE refer_code REGEXP '^$refer_code' AND task_type='champion'";
                            }
                            $sql = "SELECT id FROM users $join";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num;
                             ?></h3>
                            <p>Champion Users</p>
                        </div>
                        
                        <a href="champion_users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3><?php
                            if($_SESSION['role'] == 'Super Admin'){
                                $join = "WHERE task_type='champion' AND status=1 AND code_generate = 1 AND today_codes != 0";
                            }
                            else{
                                $refer_code = $_SESSION['refer_code'];
                                $join = "WHERE refer_code REGEXP '^$refer_code' AND task_type='champion' AND status=1 AND code_generate = 1 AND today_codes != 0";
                            }
                            $sql = "SELECT id FROM users $join";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            echo $num;
                             ?></h3>
                            <p>Active Champion Users</p>
                        </div>
                        
                        <a href="champion_users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <?php
                if($_SESSION['role'] == 'Super Admin'){?>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-maroon">
                        <div class="inner">
                            <h3><?php
                                $currentdate = date('Y-m-d');
                                $sql = "SELECT SUM(codes) AS today_codes
                                FROM transactions
                                JOIN users ON transactions.user_id = users.id
                                WHERE DATE(transactions.datetime) = '$currentdate' AND users.task_type = 'champion'";
                                $db->sql($sql);
                                $res = $db->getResult();
                                echo $res[0]['today_codes'];
                                ?></h3>
                                <p>Champions Today Codes</p>
                        </div>
                       
                        <a href="champion_users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php
                                $currentdate = date('Y-m-d');
                                $sql = "SELECT id FROM users WHERE joined_date= '$currentdate'";
                                $db->sql($sql);
                                $res = $db->getResult();
                                $num = $db->numRows($res);
                                echo $num;
                                ?></h3>
                                <p>Today Registration</p>
                        </div>
                        
                        <a href="users.php?date=<?php echo date('Y-m-d') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-orange">
                        <div class="inner">
                        <h3><?php
                            $sql = "SELECT SUM(amount) AS amount FROM withdrawals WHERE status=0";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $totalamount = $res[0]['amount'];
                            echo "Rs.".$totalamount;
                             ?></h3>
                            <p>Unpaid Withdrawals</p>
                        </div>
                        
                        <a href="withdrawals.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                        <h3><?php
                            $sql = "SELECT SUM(amount) AS amount FROM withdrawals WHERE status=0";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $totalamount = $res[0]['amount'];
                            $currentdate = date('Y-m-d');
                            $sql = "SELECT id FROM users WHERE joined_date= '$currentdate'";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $num = $db->numRows($res);
                            $today_reg = $num * 3000;
                            $tvalue = $today_reg - $totalamount;
                            echo "Rs.". $tvalue;
                             ?></h3>
                            <p>Profit</p>
                        </div>
                        
                        <a href="withdrawals.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box bg-dark">
                        <div class="inner">
                        <h3><?php
                            $sql = "SELECT SUM(balance) + SUM(refer_balance) + SUM(sync_refer_wallet) AS balance FROM users WHERE status=1 AND today_codes != 0";
                            $db->sql($sql);
                            $res = $db->getResult();
                            $balance = $res[0]['balance'];
                           
                            echo "Rs.". number_format($balance);
                             ?></h3>
                            <p>Expect Withdrawals</p>
                        </div>
                        
                        <a href="withdrawals.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <?php    
                }
                ?>

            </div>
            <div class="row">
            <div class="col-md-12">
            <form id='notification_form' method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group">
                        <div class='col-md-3'>
                            <input type="date" class="form-control" id="date" name="date" value="<?php echo (isset($_POST['date']) && $_POST['date']!='') ? $_POST['date'] : date('Y-m-d') ?>"></input>       
                
                        </div>
                        <div class='col-md-6'>
                            <button type="submit" class="btn btn-primary" name="btnSubmit">Submit</button>
                 
                        </div>
                    </div>
                </div>
                   
            </form>
            </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="box box-success">
                        <?php 
                        $currentdate = (isset($_POST['date']) && $_POST['date']!='') ? $_POST['date'] : date('Y-m-d');
                        
                        $sql ="SELECT hour(datetime) AS time, count(*) AS numoft FROM montior WHERE datetime BETWEEN '$currentdate 00:00:00' AND '$currentdate 23:59:59'  GROUP BY hour( datetime ) , day( datetime )";
                        $db->sql($sql);
                        $result_order = $db->getResult();
                        $sql ="SELECT COUNT(id) AS total FROM montior WHERE datetime BETWEEN '$currentdate 00:00:00' AND '$currentdate 23:59:59'  ";
                        $db->sql($sql);
                        $stu_total = $db->getResult();
                        
                         ?>
                        <div class="tile-stats" style="padding:10px;">
                            <div id="earning_chart" style="width:100%;height:350px;"></div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="box box-success">
                        <?php 
                        $currentdate = (isset($_POST['date']) && $_POST['date']!='') ? $_POST['date'] : date('Y-m-d');
                        
                        $sql ="SELECT hour(datetime) AS time, SUM(codes) AS codes FROM transactions WHERE datetime BETWEEN '$currentdate 00:00:00' AND '$currentdate 23:59:59' AND type = 'generate' GROUP BY hour( datetime ) , day( datetime )";
                        $db->sql($sql);
                        $result_order2 = $db->getResult();
                        $sql ="SELECT SUM(codes) AS total FROM transactions WHERE datetime BETWEEN '$currentdate 00:00:00' AND '$currentdate 23:59:59' AND type = 'generate' ";
                        $db->sql($sql);
                        $stu_total2 = $db->getResult();
                        
                         ?>
                        <div class="tile-stats" style="padding:10px;">
                            <div id="earning_chart2" style="width:100%;height:350px;"></div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="box box-success">
                        <?php 
                        $currentdate = (isset($_POST['date']) && $_POST['date']!='') ? $_POST['date'] : date('Y-m-d');
                        
                        $sql ="SELECT hour(datetime) AS time, count(*) AS numoft FROM montior WHERE datetime BETWEEN '$currentdate 00:00:00' AND '$currentdate 23:59:59'   GROUP BY hour( datetime ) , day( datetime )";
                        $db->sql($sql);
                        $res_order = $db->getResult();
                        $sql ="SELECT COUNT(id) AS total FROM montior WHERE datetime BETWEEN '$currentdate 00:00:00' AND '$currentdate 23:59:59'  ";
                        $db->sql($sql);
                        $sts_total = $db->getResult();
                        
                         ?>
                        <div class="tile-stats" style="padding:10px;">
                            <div id="earning_chart3" style="width:100%;height:350px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="box box-success">
                        <?php 
                        $currentdate = (isset($_POST['date']) && $_POST['date']!='') ? $_POST['date'] : date('Y-m-d');
                        
                        $sql ="SELECT hour(datetime) AS time, count(*) AS numoft FROM montior WHERE datetime BETWEEN '$currentdate 00:00:00' AND '$currentdate 23:59:59'  GROUP BY hour( datetime ) , day( datetime ) AND task_type='champion'";
                        $db->sql($sql);
                        $result_order4 = $db->getResult();
                        $sql ="SELECT COUNT(id) AS total FROM montior WHERE datetime BETWEEN '$currentdate 00:00:00' AND '$currentdate 23:59:59' ";
                        $db->sql($sql);
                        $stu_total4 = $db->getResult();
                        
                         ?>
                        <div class="tile-stats" style="padding:10px;">
                            <div id="earning_chart4" style="width:100%;height:350px;"></div>
                        </div>
                    </div>

                </div>
            </div> -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Top Today Coders <small>( Day: <?= date("D"); ?>)</small></h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">

                            <div class="table-responsive">
                                <table class="table no-margin" id='top_seller_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=top_coders" data-page-list="[5, 10, 20, 50, 100, 200,500]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams_top_seller" data-sort-name="today_codes" data-sort-order="desc" data-show-export="true" data-export-types='["txt","csv"]' data-export-options='{
                                "fileName": "Yellow app-withdrawals-list-<?= date('d-m-Y') ?>",
                                "ignoreColumn": ["operate"] 
                            }'>
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-sortable='true'>ID</th>
                                            <!-- <th data-field="joined_date" data-visible="true">Joined Date</th> -->
                                            <th data-field="name">Name</th>
                                            <th data-field="mobile">Mobile</th>
                                            <th data-field="today_codes">Codes</th>
                                            <th data-field="earn" >Earn</th>
                                            <th data-field="task_type" >Task Type</th>
                                            <!-- <th data-field="balance" data-sortable='true' data-visible="true">Balance</th> -->
                                            <th data-field="total_referrals" data-sortable='true' data-visible="true">Total Referals</th>
                                            <!-- <th data-field="operate">Action</th> -->
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Top Categories <small> ( Month: <?= date("M"); ?>) </small></h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">

                            <div class="table-responsive">
                                <table class="table no-margin" id='top_seller_table' data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=top_categories" data-page-list="[5,10]" data-page-size="5" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-sort-name="total_revenues" data-sort-order="desc" data-toolbar="#toolbar" data-query-params="queryParams_top_cat">
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-sortable='true'>Rank</th>
                                            <th data-field="cat_name" data-sortable='true' data-visible="true">Category</th>
                                            <th data-field="p_name" data-sortable='true' data-visible="true">Product Name</th>
                                            <th data-field="total_revenues" data-sortable='true'>Total Revenue(<?= $settings['currency'] ?>)</th>
                                            <th data-field="operate">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

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
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                search: p.search
            };
        }
        function queryParams_top_seller(p) {
            return {
                "current_date": $('#date').val(),
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset
            };
        }

        function queryParams_top_cat(p) {
            return {
                limit: p.limit,
                sort: p.sort,
                order: p.order,
                offset: p.offset
            };
        }

    </script>
    <?php include "footer.php"; ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Hour', 'Total - <?= $stu_total[0]['total'] ?>'],
                <?php foreach ($result_order as $row) {
                    //$date = date('d-M', strtotime($row['order_date']));
                    echo "['" . $row['time'] . "'," . $row['numoft'] . "],";
                } ?>
            ]);
            var options = {
                chart: {
                    title: 'Transactions By Hour Wise',
                    //subtitle: 'Total Sale In Last Week (Month: <?php echo date("M"); ?>)',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('earning_chart'));
            chart.draw(data, google.charts.Bar.convertOptions(options));


            var data = google.visualization.arrayToDataTable([
                ['Hour', 'Total - <?= $stu_total2[0]['total'] .'\n₹'.$stu_total2[0]['total'] * COST_PER_CODE ?>'],
                <?php foreach ($result_order2 as $row) {
                    //$date = date('d-M', strtotime($row['order_date']));
                    echo "['" . $row['time'] . "'," . $row['codes'] . "],";
                } ?>
            ]);
            var options = {
                chart: {
                    title: 'Codes By Hour Wise',
                    //subtitle: 'Total Sale In Last Week (Month: <?php echo date("M"); ?>)',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('earning_chart2'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
</body>
</html>