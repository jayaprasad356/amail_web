<section class="content-header">
    <h1>Join Reports /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>

</section>
    <!-- Main content -->
<section class="content">
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                        <div class="row">
                            <div class="form-group col-md-3">
                                    <h4 class="box-title">Filter by Month </h4>
                                    <select id='month' name="month" class='form-control'>
                                        <option value="">select</option>
                                            <?php
                                            $sql = "SELECT id,month FROM `months`";
                                            $db->sql($sql);
                                            $result = $db->getResult();
                                            foreach ($result as $value) {
                                            ?>
                                                <option value='<?= $value['id'] ?>'><?= $value['month'] ?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                        </div>
                </div>
                
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=join_reports" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="true" data-export-types='["txt","csv"]' data-export-options='{
                        "fileName": "yellow app-joinreportslist-<?= date('d-m-Y') ?>",
                        "ignoreColumn": ["operate"] 
                    }'>
                        <thead>
                            <tr>
                                <!-- <th data-field="id" data-sortable="true">ID</th> -->
                                <th data-field="date" data-sortable="true">Date</th>
                                <th data-field="total_registrations" data-sortable="true">Total Registration</th>
                                <th data-field="paid_withdrawals" data-sortable="true">Paid Withdrawals</th>
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
     $('#month').on('change', function() {
        id = $('#month').val();
        $('#users_table').bootstrapTable('refresh');
    });
    //     $('#activeusers').on('change', function() {
    //         idf = $('#activeusers').val();
    //         $('#users_table').bootstrapTable('refresh');
    //     });
   

    function queryParams(p) {
        return {
            "month": $('#month').val(),
            // "activeusers": $('#activeusers').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>

