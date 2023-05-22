<section class="content-header">
    <h1>Join Reports /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-3">
                       
                            </div>
                        </div>

                        <div class="col-md-9 text-left">
                              <form method="POST" action="">
                          <button class="btn btn-primary" type="submit" name="update">Update</button>
                         </form>
                        </div>
    
                         <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
                            $sql="INSERT INTO join_reports (date, total_users)
                            SELECT joined_date, COUNT(id) AS total_users
                            FROM users
                            WHERE status = 1
                            GROUP BY joined_date
                            ORDER BY joined_date;

                            UPDATE join_reports
                            SET total_paid = (
                              SELECT SUM(amount)
                              FROM withdrawals
                              WHERE status = 1 AND DATE(datetime) = join_reports.date
                              GROUP BY DATE(datetime)
                            )
                             WHERE EXISTS ( SELECT 1 FROM withdrawals WHERE status = 1 AND DATE(datetime) = join_reports.date);";
                            $db->sql($sql);
                           }
                           ?>

                </div>
                <div class="box-body table-responsive">
                    <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=join_reports" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="true" data-export-types='["txt","csv"]' data-export-options='{
                        "fileName": "yellow app-joinreportslist-<?= date('d-m-Y') ?>",
                        "ignoreColumn": ["operate"] 
                    }'>
                        <thead>
                            <tr>
                                <th data-field="date" data-sortable="true">Date</th>
                                <th data-field="total_users" data-sortable="true">Total Joined Users</th>
                                <th data-field="total_paid" data-sortable="true">Paid Withdrawals</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="separator"></div>
    </div>
</section>

<script>
    $('#month').on('change', function() {
        id = $('#month').val();
        $('#users_table').bootstrapTable('refresh');
    });

    $('.btn-update').on('click', function() {
        $('#users_table').bootstrapTable('refresh');
    });

    function queryParams(p) {
        return {
            "month": $('#month').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>


