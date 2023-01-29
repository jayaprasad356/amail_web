<section class="content-header">
    <h1>User Reports /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
    <ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add-user.php"><i class="fa fa-plus-square"></i> Add New User</a>
    </ol>

</section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="col-md-3">
                                <h4 class="box-title">From Date </h4>
                                <input type="date" class="form-control" id="date" name="date" value="<?php echo (isset($_GET['date'])) ? $_GET['date'] : "" ?>"></input>
                        </div>
                        <div class="col-md-3">
                                <h4 class="box-title">To Date </h4>
                                <input type="date" class="form-control" id="date" name="date" value="<?php echo (isset($_GET['date'])) ? $_GET['date'] : "" ?>"></input>
                        </div>
                        <div class="col-md-3">
                                <h4 class="box-title">From Time </h4>
                                <input type="time" class="form-control" id="date" name="date" value="<?php echo (isset($_GET['date'])) ? $_GET['date'] : "" ?>"></input>
                        </div>
                        <div class="col-md-3">
                            <h4 class="box-title">To Time</h4>
                            <input type="time" class="form-control" id="date" name="date" value="<?php echo (isset($_GET['date'])) ? $_GET['date'] : "" ?>"></input>
                         </div>
                    </div>
                    
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=user_reports" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="true" data-export-types='["txt","csv"]' data-export-options='{
                            "fileName": "yellow app-user_reportslist-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="mobile" data-sortable="true">Phone Number</th>
                                    <th data-field="avg_codes" data-sortable="true">Average Codes</th>
                                    <!-- <th data-field="operate">Action</th>                                     -->
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
      $('#date').on('change', function() {
            id = $('#date').val();
            $('#users_table').bootstrapTable('refresh');
        });
        $('#activeusers').on('change', function() {
            idf = $('#activeusers').val();
            $('#users_table').bootstrapTable('refresh');
        });
   

    function queryParams(p) {
        return {
            "date": $('#date').val(),
            "activeusers": $('#activeusers').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>

