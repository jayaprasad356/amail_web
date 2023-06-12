<section class="content-header">
    <h1>scratch cards /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>

    <ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add-scratch_cards.php"><i class="fa fa-plus-square"></i> Add New scratch cards</a>
    </ol>

</section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-header">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <h4 class="box-title">Filter by scartched</h4>
                            <select id='type' name="type" class='form-control'>
                               <option value="">--select--</option>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                             </select>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=scratch_card" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="true" data-export-types='["txt","csv"]' data-export-options='{
                            "fileName": "yellow app-scratch_card-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                   <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="user_id" data-sortable="true">User ID</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="mobile" data-sortable="true">Mobile Number</th>
                                    <th data-field="discount" data-sortable="true">Discount</th>
                                    <th data-field="expiry_date" data-sortable="true">Expiry Date</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="is_scratched" data-sortable="true">Is Scratched</th>
                                    <th data-field="operate">Action</th>
                                </tr>
                            </thead>
                         </table>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <div class="separator"> </div>
        </div>
        <!-- /.row (main row) -->
</section>
<script>
    $('#seller_id').on('change', function() {
        $('#products_table').bootstrapTable('refresh');
    });
    $('#community').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });
    $('#type').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });

    function queryParams(p) {
        return {
            "seller_id": $('#seller_id').val(),
            "community": $('#community').val(),
            "type": $('#type').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>
