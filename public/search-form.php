<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$sql = "SELECT id, name FROM categories ORDER BY id ASC";
$db->sql($sql);
$res = $db->getResult();

?>
<section class="content">
    <div class="row">
        <div class="col-md-10">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                      <h4> Manage Referal Codes</h4>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="add_admin_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-6'>
                                       <label for="">Mobile Number</label> <i class="text-danger asterik">*</i>
                                        <select id='mobile' name="mobile" class='form-control' required>
                                            <option value="">select</option>
                                                <?php
                                                $sql = "SELECT id,mobile FROM `users`";
                                                $db->sql($sql);
                                                $result = $db->getResult();
                                                foreach ($result as $value) {
                                                ?>
                                                    <option value='<?= $value['id'] ?>'><?= $value['mobile'] ?></option>
                                            <?php } ?>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-2">
                                   <input type="submit" class="btn-primary btn" value="View" name="btnView" />&nbsp;
                               </div>
                            </div>

                        </div>
                </form>
                 <!-- Main content -->
                <section class="content">
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12">
                                <!-- /.box-header -->
                                <div class="table-responsive">
                                    <?php if(isset($_POST['btnView'])){
                                               $mobile = $db->escapeString(($_POST['mobile']));
                                      ?> 
                                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=referal_codes" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="false" data-export-types='["txt","excel"]' data-export-options='{
                                            "fileName": "students-list-<?= date('d-m-Y') ?>",
                                            "ignoreColumn": ["operate"] 
                                        }'>
                                            <thead>
                                                <tr>
                                                    <th data-field="id" data-sortable="true">ID</th>
                                                    <th data-field="name" data-sortable="true">Name</th>
                                                    <th data-field="mobile" data-sortable="true">Phone Number</th>
                                                    <th data-field="earn" data-sortable="true">Earn</th>
                                                    <th data-field="total_referrals" data-sortable="true">Total Referrals</th>
                                                    <th data-field="balance" data-sortable="true">Balance</th>
                                                    <th data-field="today_codes" data-sortable="true">Today Codes</th>
                                                    <th data-field="total_codes" data-sortable="true">Total Codes</th>
                                                    <th data-field="refer_code" data-sortable="true">Refer Code</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <br>
                                        <?php
                                           if (isset($_POST['btnUpdate'])) {
                                                   $refer_code = $db->escapeString(($_POST['refer_code']));
                                                   $error = array();
                                                if (!empty($refer_code)) 
                                                {
                                                    $sql_query = "UPDATE users SET refer_code='$refer_code' WHERE mobile=$mobile";
                                                    $db->sql($sql_query);
                                                    $result = $db->getResult();
                                                
                                                }
                                            }
                                        ?>
                                        <form name="update_code_form" method="post" enctype="multipart/form-data">
                                                   <div class="form-group">
                                                            <div class='col-md-6'>
                                                                   <label for="exampleInputEmail1">Refer Code</label><i class="text-danger asterik">*</i><?php echo isset($error['refer_code']) ? $error['refer_code'] : ''; ?>
                                                                   <input type="text" class="form-control" name="refer_code">
                                                            </div>
                                                            <br>
                                                            <div class="col-md-2">
                                                                  <button type="submit" class="btn btn-primary" name="btnUpdate">Update</button>
                                                            </div>
                                                    </div>
                                        </form>
                                    <?php } ?>
                                </div>
                                <!-- /.box-body -->
                            
                            <!-- /.box -->
                        </div>
                        <div class="separator"> </div>
                    </div>
                    <!-- /.row (main row) -->
                </section>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>
<script>
    $(document).ready(function () {
        $('#mobile').select2({
        width: 'element',
        placeholder: 'Type in Mobile to search',

    });
    });

</script>
<script>
    $('#seller_id').on('change', function() {
        $('#products_table').bootstrapTable('refresh');
    });
    $('#community').on('change', function() {
        $('#users_table').bootstrapTable('refresh');
    });

    function queryParams(p) {
        return {
            "category_id": $('#category_id').val(),
            "seller_id": $('#seller_id').val(),
            "community": $('#community').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>
<?php $db->disconnect(); ?>