<section class="content-header">
    <h1>Monthwise Join Reports /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>

</section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=month_join_reports" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="month" data-sort-order="desc" data-show-export="true" data-export-types='["txt","csv"]' data-export-options='{
                            "fileName": "yellow app-month_joinreportslist-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <!-- <th data-field="id" data-sortable="true">ID</th> -->
                                    <th data-field="date" data-sortable="true">Month</th>
                                    <th data-field="total_users" data-sortable="true">Total Registration</th>
                                    <th data-field="total_paid" data-sortable="true">Paid Withdrawals</th>
                                    <!-- <th data-field="operate">Action</th>-->
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="separator"> </div>
        </div>
        <!-- /.row (main row) -->
    </section>

<script>
    //   $('#date').on('change', function() {
    //         id = $('#date').val();
    //         $('#users_table').bootstrapTable('refresh');
    //     });
    //     $('#activeusers').on('change', function() {
    //         idf = $('#activeusers').val();
    //         $('#users_table').bootstrapTable('refresh');
    //     });
   

    function queryParams(p) {
        return {
            // "date": $('#date').val(),
            // "activeusers": $('#activeusers').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>

